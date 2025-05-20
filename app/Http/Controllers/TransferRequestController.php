<?php

namespace App\Http\Controllers;

use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TransferRequestStatusUpdated;
use PDF;


class TransferRequestController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Début de la soumission de la demande de transfert', [
            'request' => $request->all(),
            'files' => $request->allFiles(),
            'user' => auth()->user()
        ]);
        
        try {
            $request->validate([
                'current_institution' => 'required|string',
                'current_formation' => 'required|string',
                'current_year' => 'required|string',
                'average_grade' => 'required|numeric',
                'specialization' => 'required|string',
                'projects' => 'nullable|string',
                'motivation' => 'required|string',
                'career_plan' => 'required|string',
                'desired_formation' => 'required|string',
                'technical_skills' => 'nullable|string',
                'languages' => 'nullable|array',
                'transcript' => 'required|file|mimes:pdf|max:9048',
                'cv' => 'required|file|mimes:pdf|max:9048',
                'motivation_letter' => 'required|file|mimes:pdf|max:9048',
                'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:9048',
                'certificates' => 'nullable|array',
                'certificates.*' => 'file|mimes:pdf|max:9048'
            ]);

            \Log::info('Validation réussie, début du traitement des fichiers');

            $paths = [];
            foreach ($request->allFiles() as $key => $file) {
                if ($key === 'certificates') {
                    foreach ($file as $certificate) {
                        $paths['certificates'][] = $certificate->store('transfer_documents/' . auth()->id());
                    }
                } else {
                    $paths[$key] = $file->store('transfer_documents/' . auth()->id());
                }
            }

            \Log::info('Fichiers stockés avec succès', ['paths' => $paths]);

            // Create transfer request
            $transferRequest = new TransferRequest();
            $transferRequest->student_id = auth()->id(); // Set the student_id
            $transferRequest->current_institution = $request->current_institution;
            $transferRequest->current_formation = $request->current_formation;
            $transferRequest->current_year = $request->current_year;
            $transferRequest->average_grade = $request->average_grade;
            $transferRequest->specialization = $request->specialization;
            $transferRequest->projects = $request->projects;
            $transferRequest->motivation = $request->motivation;
            $transferRequest->career_plan = $request->career_plan;
            $transferRequest->desired_formation = $request->desired_formation;
            $transferRequest->technical_skills = $request->technical_skills;
            $transferRequest->languages = $request->languages;
            $transferRequest->transcript_path = $paths['transcript'];
            $transferRequest->cv_path = $paths['cv'];
            $transferRequest->motivation_letter_path = $paths['motivation_letter'];
            $transferRequest->id_document_path = $paths['id_document'];
            $transferRequest->certificates_paths = $paths['certificates'] ?? [];
            $transferRequest->status = 'pending';
            $transferRequest->save();

            // Create initial status history
            $transferRequest->statusHistory()->create([
                'status' => 'pending',
                'notes' => 'Demande soumise',
                'changed_by' => auth()->id(),
                'changed_at' => now()
            ]);

            \Log::info('Demande de transfert créée avec succès', ['transfer_request' => $transferRequest]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('transfer.messages.request_submitted'),
                    'transfer_request' => $transferRequest
                ]);
            }

            return redirect()->route('transfer.decision', $transferRequest)
                ->with('success', __('transfer.messages.request_submitted'));

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la soumission de la demande de transfert', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('transfer.messages.request_error'),
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', __('transfer.messages.request_error'))
                ->withInput();
        }
    }

    // public function index()
    // {
    //     $transferRequests = TransferRequest::with(['student'])
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);
        
    //     return view('admin.transfer-requests.index', compact('transferRequests'));
    // }


    public function index(Request $request)
    {
        $query = TransferRequest::with('student');
    
        // Filtrage par statut (dans transfer_requests)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // Filtrage par formation (dans users/students)
        if ($request->filled('formation')) {
            $formation = $request->formation;
            $query->whereHas('student', function ($q) use ($formation) {
                $q->where('formation', $formation);
            });
        }
    
        // Filtrage par année (dans users/students)
        if ($request->filled('year')) {
            $year = $request->year;
            $query->whereHas('student', function ($q) use ($year) {
                $q->where('year', $year);
            });
        }
    
        // Recherche texte dans nom, prénom, email (relation student)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        // Pagination et ordre
        $transferRequests = $query->orderBy('created_at', 'desc')->paginate(10);
    
        // Conserver les filtres dans la pagination
        $transferRequests->appends($request->only(['status', 'formation', 'year', 'search']));
    
        return view('admin.transfer-requests.index', compact('transferRequests'));
    }
    
    public function show(TransferRequest $transferRequest)
    {
        return view('admin.transfer-requests.show', compact('transferRequest'));
        
    }

    public function updateStatus(Request $request, TransferRequest $transferRequest)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $transferRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'approval_date' => now()
        ]);

        // Notifier l'étudiant du changement de statut
        $transferRequest->student->notify(new TransferRequestStatusUpdated($transferRequest));

        return redirect()->route('admin.transfer-requests.index')
            ->with('success', 'Le statut de la demande a été mis à jour.');
    }

    public function downloadDocument(TransferRequest $transferRequest, $documentType)
    {
        $documentPath = $transferRequest->documents[$documentType] ?? null;

        if (!$documentPath || !Storage::disk('public')->exists($documentPath)) {
            return redirect()->back()->with('error', 'Document non trouvé.');
        }

        return Storage::disk('public')->download($documentPath);
    }

    public function step7()
    {
        $transferRequest = Auth::user()->transferRequest;
        
        if (!$transferRequest) {
            return redirect()->route('dashboard')->with('error', 'No transfer request found.');
        }

        return view('Admin.transfer-requests.step7', compact('transferRequest'));
    }

    public function studentStatus()
    {
        $transferRequest = Auth::user()->transferRequest;
        
        if (!$transferRequest) {
            return redirect()->route('dashboard')->with('error', 'No transfer request found.');
        }

        // Redirect to step 7 instead of showing the status page
        return redirect()->route('transfer-requests.step7');
    }

    public function checkTransferStatus()
    {
        $user = Auth::user();
        $transferRequest = $user->transferRequest()->latest()->first();

        if ($transferRequest) {
            $statusHistory = $transferRequest->statusHistory()
                ->orderBy('changed_at', 'desc')
                ->get()
                ->map(function ($history) {
                    return [
                        'date' => $history->changed_at->format('Y-m-d H:i:s'),
                        'status' => $history->status,
                        'status_text' => $history->status_text,
                        'notes' => $history->notes,
                        'changed_by' => $history->changed_by
                    ];
                });

            return response()->json([
                'has_completed' => true,
                'current_step' => 8,
                'transfer_request' => $transferRequest,
                'status_history' => $statusHistory
            ]);
        }

        return response()->json([
            'has_completed' => false,
            'current_step' => 0
        ]);
    }

    public function detailedTracking()
    {
        $user = Auth::user();
        $transferRequest = $user->transferRequest()->latest()->first();
        
        if (!$transferRequest) {
            return redirect()->route('dashboard')->with('error', 'No transfer request found.');
        }

        $statusHistory = $transferRequest->statusHistory()
            ->orderBy('changed_at', 'desc')
            ->get()
            ->map(function ($history) {
                return [
                    'date' => $history->changed_at->format('Y-m-d H:i:s'),
                    'status' => $history->status,
                    'status_text' => $history->status_text,
                    'notes' => $history->notes,
                    'changed_by' => $history->changed_by
                ];
            });

        return view('demende', [
            'transfer_request' => $transferRequest,
            'status_history' => $statusHistory,
            'current_step' => 8
        ]);
    }

    public function verification(TransferRequest $transferRequest)
    {
        return view('transfer.verification', compact('transferRequest'));
    }

    public function verify(Request $request, TransferRequest $transferRequest)
    {
        // Vérifier si l'utilisateur a le droit de vérifier cette demande
        if (!$this->canVerify($transferRequest)) {
            return redirect()->back()->with('error', __('transfer.messages.unauthorized'));
        }

        // Valider la demande
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'comments' => 'nullable|string|max:500'
        ]);

        // Mettre à jour le statut de la demande
        $transferRequest->update([
            'status' => $validated['status'],
            'comments' => $validated['comments'],
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        // Envoyer une notification à l'étudiant
        $transferRequest->user->notify(new TransferRequestStatusUpdated($transferRequest));

        return redirect()->route('transfer.verification', $transferRequest)
            ->with('success', __('transfer.messages.status_updated'));
    }

    private function canVerify(TransferRequest $transferRequest)
    {
        // Vérifier si l'utilisateur est un administrateur ou un responsable de département
        return auth()->user()->isAdmin() || 
               auth()->user()->isDepartmentHead($transferRequest->target_department);
    }

    public function decision(TransferRequest $transferRequest)
    {
        // Vérifier si l'utilisateur a le droit de voir cette demande
        if ($transferRequest->student_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('transfer.decision', compact('transferRequest'));
    }

    public function downloadAcceptance(TransferRequest $transferRequest)
    {
        // Vérifier si l'utilisateur a le droit de télécharger cette lettre
        if ($transferRequest->student_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Vérifier si la demande a été acceptée
        if ($transferRequest->status !== 'accepted') {
            return redirect()->back()->with('error', __('transfer.messages.not_accepted'));
        }

        // Générer la lettre d'acceptation
        $pdf = PDF::loadView('transfer.acceptance_letter', compact('transferRequest'));

        return $pdf->download('lettre_acceptation_' . $transferRequest->id . '.pdf');
    }
} 