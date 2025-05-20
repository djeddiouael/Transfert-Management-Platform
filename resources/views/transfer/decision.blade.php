<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('transfer.decision.title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --text-color: #2d3436;
            --light-bg: #f8f9fa;
            --border-radius: 12px;
            --box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        body {
            background-color: #f5f6fa;
            color: var(--text-color);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .decision-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            border: none;
            transition: transform 0.2s ease;
        }

        .decision-card:hover {
            transform: translateY(-5px);
        }

        .decision-header {
            background: linear-gradient(135deg, var(--primary-color), #3a0ca3);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 1.5rem;
        }

        .decision-header h2, .decision-header h3 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        .decision-body {
            padding: 2rem;
        }

        .status-badge {
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.accepted {
            background-color: var(--success-color);
            color: white;
        }

        .status-badge.rejected {
            background-color: var(--danger-color);
            color: white;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            margin-bottom: 2rem;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--primary-color);
            border: 4px solid white;
            box-shadow: 0 0 0 3px var(--primary-color);
        }

        .timeline-content {
            background-color: var(--light-bg);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .document-list {
            list-style: none;
            padding: 0;
        }

        .document-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            margin-bottom: 0.8rem;
            background: white;
            transition: all 0.2s ease;
        }

        .document-item:hover {
            background: var(--light-bg);
            transform: translateX(5px);
        }

        .document-item i {
            margin-right: 1rem;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: #3a0ca3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.2rem;
        }

        strong {
            color: var(--text-color);
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .decision-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- En-tête avec le statut -->
                <div class="decision-card">
                    <div class="decision-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">@lang('transfer.decision.title')</h2>
                            <span class="status-badge {{ $transferRequest?->status ?? 'pending' }}">
                                @lang('transfer.status.' . ($transferRequest?->status ?? 'pending'))
                            </span>
                        </div>
                    </div>
                    <div class="decision-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>@lang('transfer.decision.request_details')</h5>
                                <p><strong>@lang('transfer.decision.request_id')</strong>: {{ $transferRequest?->id ?? '-' }}</p>
                                <p><strong>@lang('transfer.decision.submission_date')</strong>: {{ $transferRequest?->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                                <p><strong>@lang('transfer.decision.current_formation')</strong>: {{ $transferRequest?->current_formation ?? '-' }}</p>
                                <p><strong>@lang('transfer.decision.desired_formation')</strong>: {{ $transferRequest?->desired_formation ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>@lang('transfer.decision.student_info')</h5>
                                <p><strong>@lang('transfer.decision.name')</strong>: {{ $transferRequest?->student?->name ?? '-' }}</p>
                                <p><strong>@lang('transfer.decision.email')</strong>: {{ $transferRequest?->student?->email ?? '-' }}</p>
                                <p><strong>@lang('transfer.decision.average_grade')</strong>: {{ $transferRequest?->average_grade ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Décision finale -->
                <div class="decision-card">
                    <div class="decision-header">
                        <h3 class="mb-0">@lang('transfer.decision.final_decision')</h3>
                    </div>
                    <div class="decision-body">
                        @if($transferRequest?->status === 'accepted')
                            <div class="alert alert-success">
                                <h4 class="alert-heading">@lang('transfer.decision.congratulations')</h4>
                                <p>@lang('transfer.decision.accepted_message')</p>
                            </div>
                            <div class="mt-4">
                                <h5>@lang('transfer.decision.next_steps')</h5>
                                <ul>
                                    <li>@lang('transfer.decision.step1')</li>
                                    <li>@lang('transfer.decision.step2')</li>
                                    <li>@lang('transfer.decision.step3')</li>
                                </ul>
                            </div>
                        @elseif($transferRequest?->status === 'rejected')
                            <div class="alert alert-danger">
                                <h4 class="alert-heading">@lang('transfer.decision.regret')</h4>
                                <p>@lang('transfer.decision.rejected_message')</p>
                            </div>
                            @if($transferRequest?->admin_notes)
                                <div class="mt-4">
                                    <h5>@lang('transfer.decision.rejection_reason')</h5>
                                    <p>{{ $transferRequest?->admin_notes }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Historique du traitement -->
                <div class="decision-card">
                    <div class="decision-header">
                        <h3 class="mb-0">@lang('transfer.decision.processing_history')</h3>
                    </div>
                    <div class="decision-body">
                        <div class="timeline">
                            @foreach($transferRequest?->statusHistory ?? [] as $history)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">@lang('transfer.status.' . $history->status)</h6>
                                            <small>{{ $history->changed_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        @if($history->notes)
                                            <p class="mb-0">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Documents soumis -->
                <div class="decision-card">
                    <div class="decision-header">
                        <h3 class="mb-0">@lang('transfer.decision.submitted_documents')</h3>
                    </div>
                    <div class="decision-body">
                        <ul class="document-list">
                            @if($transferRequest?->transcript_path)
                                <li class="document-item">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>@lang('transfer.documents.transcript')</span>
                                </li>
                            @endif
                            @if($transferRequest?->cv_path)
                                <li class="document-item">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>@lang('transfer.documents.cv')</span>
                                </li>
                            @endif
                            @if($transferRequest?->motivation_letter_path)
                                <li class="document-item">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>@lang('transfer.documents.motivation_letter')</span>
                                </li>
                            @endif
                            @if($transferRequest?->id_document_path)
                                <li class="document-item">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>@lang('transfer.documents.id_document')</span>
                                </li>
                            @endif
                            @if($transferRequest?->certificates_paths)
                                @foreach($transferRequest?->certificates_paths as $certificate)
                                    <li class="document-item">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>@lang('transfer.documents.certificate') {{ $loop->iteration }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="text-center mt-4">
                    @if($transferRequest?->status === 'accepted')
                        <a href="{{ route('transfer-request.download-acceptance', $transferRequest) }}" class="btn btn-primary">
                            <i class="fas fa-download me-2"></i>@lang('transfer.decision.download_acceptance')
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-home me-2"></i>@lang('transfer.decision.return_dashboard')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 