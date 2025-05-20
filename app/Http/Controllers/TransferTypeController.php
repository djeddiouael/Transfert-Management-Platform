<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferRequest;

class TransferTypeController extends Controller
{
    public function index()
    {
        return view('transfer.type');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transfer_type' => 'required|in:internal,external',
            'internal_type' => 'required_if:transfer_type,internal|in:faculty,department,specialty',
            'current_faculty' => 'required_if:internal_type,faculty|nullable|string',
            'current_department' => 'required_if:internal_type,department|nullable|string',
            'current_specialty' => 'required_if:internal_type,specialty|nullable|string',
            'target_faculty' => 'required_if:internal_type,faculty|nullable|string',
            'target_department' => 'required_if:internal_type,department|nullable|string',
            'target_specialty' => 'required_if:internal_type,specialty|nullable|string',
            'external_university' => 'required_if:transfer_type,external|nullable|string',
            'external_faculty' => 'required_if:transfer_type,external|nullable|string',
            'external_department' => 'required_if:transfer_type,external|nullable|string',
        ]);

        // Créer une nouvelle demande de transfert
        $transferRequest = new TransferRequest();
        $transferRequest->user_id = auth()->id();
        $transferRequest->transfer_type = $validated['transfer_type'];
        
        if ($validated['transfer_type'] === 'internal') {
            $transferRequest->internal_type = $validated['internal_type'];
            switch ($validated['internal_type']) {
                case 'faculty':
                    $transferRequest->current_faculty = $validated['current_faculty'];
                    $transferRequest->target_faculty = $validated['target_faculty'];
                    break;
                case 'department':
                    $transferRequest->current_department = $validated['current_department'];
                    $transferRequest->target_department = $validated['target_department'];
                    break;
                case 'specialty':
                    $transferRequest->current_specialty = $validated['current_specialty'];
                    $transferRequest->target_specialty = $validated['target_specialty'];
                    break;
            }
        } else {
            $transferRequest->external_university = $validated['external_university'];
            $transferRequest->external_faculty = $validated['external_faculty'];
            $transferRequest->external_department = $validated['external_department'];
        }

        $transferRequest->status = 'pending';
        $transferRequest->save();

        return redirect()->route('transfer.documents')
            ->with('success', __('transfer.messages.transfer_type_saved'));
    }
} 