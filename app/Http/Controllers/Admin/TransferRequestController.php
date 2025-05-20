<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\DB;

class TransferRequestController extends Controller
{
    public function export(Request $request)
    {
        $format = $request->input('format', 'excel');
        $columns = $request->input('columns', []);
        
        $query = TransferRequest::with('student')
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                return $query->whereDate('request_date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                return $query->whereDate('request_date', '<=', $request->end_date);
            });

        $transferRequests = $query->get();

        $data = $transferRequests->map(function ($request) use ($columns) {
            $row = [];
            
            if (in_array('student', $columns)) {
                $row[__('transfer.admin.student_name')] = $request->student->name . ' ' . $request->student->firstname;
            }
            
            if (in_array('institution', $columns)) {
                $row[__('transfer.admin.current_institution')] = $request->current_institution;
            }
            
            if (in_array('formation', $columns)) {
                $row[__('transfer.admin.current_formation')] = $request->current_formation;
            }
            
            if (in_array('grade', $columns)) {
                $row[__('transfer.admin.average_grade')] = $request->average_grade;
            }
            
            if (in_array('status', $columns)) {
                $row[__('transfer.admin.status')] = __('transfer.status.' . $request->status);
            }
            
            if (in_array('date', $columns)) {
                $row[__('transfer.admin.request_date')] = $request->request_date->format('d/m/Y H:i');
            }
            
            return $row;
        });

        $filename = 'transfer_requests_' . now()->format('Y-m-d_H-i-s');

        switch ($format) {
            case 'excel':
                return Excel::download(new TransferRequestsExport($data), $filename . '.xlsx');
            case 'pdf':
                $pdf = PDF::loadView('admin.transfer-requests.export-pdf', [
                    'data' => $data,
                    'columns' => $columns
                ]);
                return $pdf->download($filename . '.pdf');
            case 'csv':
                return Excel::download(new TransferRequestsExport($data), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
            default:
                return back()->with('error', __('transfer.admin.invalid_export_format'));
        }
    }

    public function index(Request $request)
    {
        $query = TransferRequest::with('student');

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('formation')) {
            $query->where('current_formation', $request->formation);
        }

        if ($request->has('year')) {
            $query->where('current_year', $request->year);
        }

        // Recherche par nom d'étudiant
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('student', function ($q) use ($searchTerm) {
                $q->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            });
        }

        // Get statistics data with fallback to empty arrays
        $statusData = $this->getStatusStatistics() ?? ['labels' => [], 'data' => []];
        $institutionData = $this->getInstitutionStatistics() ?? ['labels' => [], 'data' => []];
        $monthlyData = $this->getMonthlyStatistics() ?? ['labels' => [], 'data' => []];

        $transferRequests = $query->orderBy('request_date', 'desc')->paginate(10);

        // Si c'est une requête AJAX, retourner les données en JSON
        if ($request->ajax()) {
            return response()->json([
                'statistics' => [
                    'statusLabels' => $statusData['labels'],
                    'statusData' => $statusData['data'],
                    'institutionLabels' => $institutionData['labels'],
                    'institutionData' => $institutionData['data'],
                    'monthlyLabels' => $monthlyData['labels'],
                    'monthlyData' => $monthlyData['data']
                ],
                'requests' => $transferRequests
            ]);
        }

        // Sinon, retourner la vue normale
        return view('admin.transfer-requests.index', [
            'transferRequests' => $transferRequests,
            'statuses' => TransferRequest::STATUSES ?? [],
            'formations' => TransferRequest::distinct()->pluck('current_formation') ?? [],
            'years' => TransferRequest::distinct()->pluck('current_year') ?? [],
            'statusLabels' => $statusData['labels'],
            'statusData' => $statusData['data'],
            'institutionLabels' => $institutionData['labels'],
            'institutionData' => $institutionData['data'],
            'monthlyLabels' => $monthlyData['labels'],
            'monthlyData' => $monthlyData['data']
        ]);
    }

    private function getStatusStatistics()
    {
        $statistics = TransferRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $labels = [];
        $data = [];

        foreach ($statistics as $stat) {
            $labels[] = trans('transfer.status.' . $stat->status);
            $data[] = $stat->count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getInstitutionStatistics()
    {
        $statistics = TransferRequest::select('current_institution', DB::raw('count(*) as count'))
            ->groupBy('current_institution')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $labels = [];
        $data = [];

        foreach ($statistics as $stat) {
            $labels[] = $stat->current_institution;
            $data[] = $stat->count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getMonthlyStatistics()
    {
        $statistics = TransferRequest::select(
                DB::raw('DATE_FORMAT(request_date, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get();

        $labels = [];
        $data = [];

        foreach ($statistics as $stat) {
            $labels[] = date('M Y', strtotime($stat->month));
            $data[] = $stat->count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'current_institution' => 'required|string|max:255',
            'current_formation' => 'required|string|max:255',
            'current_year' => 'required|string|max:255',
            'average_grade' => 'required|numeric|min:0|max:20',
            'projects' => 'nullable|string',
            'motivation' => 'required|string',
            'career_plan' => 'required|string',
            'desired_formation' => 'required|string|max:255',
            'technical_skills' => 'nullable|string',
            'languages' => 'nullable|array',
            'transcript' => 'required|file|mimes:pdf|max:2048',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'motivation_letter' => 'required|file|mimes:pdf|max:2048',
            'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificates' => 'nullable|array',
            'certificates.*' => 'file|mimes:pdf|max:2048',
            'specialization' => 'nullable|string|max:255'
        ]);

        // Stockage des fichiers
        $transcriptPath = $request->file('transcript')->store('transfer_documents/' . $request->student_id);
        $cvPath = $request->file('cv')->store('transfer_documents/' . $request->student_id);
        $motivationLetterPath = $request->file('motivation_letter')->store('transfer_documents/' . $request->student_id);
        $idDocumentPath = $request->file('id_document')->store('transfer_documents/' . $request->student_id);

        $certificatesPaths = [];
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $certificate) {
                $certificatesPaths[] = $certificate->store('transfer_documents/' . $request->student_id);
            }
        }

        // Création de la demande de transfert
        $transferRequest = TransferRequest::create([
            'student_id' => $validated['student_id'],
            'current_institution' => $validated['current_institution'],
            'current_formation' => $validated['current_formation'],
            'current_year' => $validated['current_year'],
            'average_grade' => $validated['average_grade'],
            'projects' => $validated['projects'],
            'motivation' => $validated['motivation'],
            'career_plan' => $validated['career_plan'],
            'desired_formation' => $validated['desired_formation'],
            'technical_skills' => $validated['technical_skills'],
            'languages' => $validated['languages'],
            'transcript_path' => $transcriptPath,
            'cv_path' => $cvPath,
            'motivation_letter_path' => $motivationLetterPath,
            'id_document_path' => $idDocumentPath,
            'certificates_paths' => $certificatesPaths,
            'status' => 'pending',
            'specialization' => $validated['specialization'] ?? 'Non spécifié'
        ]);

        return response()->json([
            'success' => true,
            'message' => __('transfer.messages.submission_success'),
            'transfer_request' => $transferRequest
        ]);
    }
} 