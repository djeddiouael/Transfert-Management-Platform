@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        @lang('transfer.student.request_status')
                    </h3>
                    <span class="badge bg-white text-primary">
                        <i class="fas fa-info-circle me-1"></i>
                        @lang('transfer.student.step7')
                    </span>
                </div>
                <div class="card-body">
                    @if($transferRequest)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">@lang('transfer.student.basic_info')</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted" style="width: 40%">@lang('transfer.student.current_institution')</th>
                                                        <td>{{ $transferRequest->current_institution }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">@lang('transfer.student.current_formation')</th>
                                                        <td>{{ $transferRequest->current_formation }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">@lang('transfer.student.average_grade')</th>
                                                        <td>{{ $transferRequest->average_grade }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">@lang('transfer.student.desired_formation')</th>
                                                        <td>{{ $transferRequest->desired_formation }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">@lang('transfer.student.status_info')</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted" style="width: 40%">@lang('transfer.student.status')</th>
                                                        <td>
                                                            @switch($transferRequest->status)
                                                                @case('pending')
                                                                    <span class="badge bg-warning rounded-pill px-3 py-2">
                                                                        <i class="fas fa-clock me-1"></i>
                                                                        @lang('transfer.status.pending')
                                                                    </span>
                                                                    @break
                                                                @case('confirmed')
                                                                    <span class="badge bg-info rounded-pill px-3 py-2">
                                                                        <i class="fas fa-check-circle me-1"></i>
                                                                        @lang('transfer.status.confirmed')
                                                                    </span>
                                                                    @break
                                                                @case('accepted')
                                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                                        <i class="fas fa-check-double me-1"></i>
                                                                        @lang('transfer.status.accepted')
                                                                    </span>
                                                                    @break
                                                                @case('rejected')
                                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                                        <i class="fas fa-times-circle me-1"></i>
                                                                        @lang('transfer.status.rejected')
                                                                    </span>
                                                                    @break
                                                            @endswitch
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">@lang('transfer.student.request_date')</th>
                                                        <td>{{ $transferRequest->request_date->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                    @if($transferRequest->admin_notes)
                                                    <tr>
                                                        <th class="text-muted">@lang('transfer.student.admin_notes')</th>
                                                        <td>
                                                            <div class="alert alert-info p-2 mb-0">
                                                                <i class="fas fa-comment-alt me-2"></i>
                                                                {{ $transferRequest->admin_notes }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">@lang('transfer.student.documents')</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <a href="{{ route('transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => 'transcript']) }}" 
                                           class="card document-card h-100 text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="document-icon bg-primary text-white rounded-circle p-3 me-3">
                                                        <i class="fas fa-file-pdf fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title text-dark mb-1">@lang('transfer.student.transcript')</h5>
                                                        <p class="text-muted mb-0">@lang('transfer.student.download_document')</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => 'cv']) }}" 
                                           class="card document-card h-100 text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="document-icon bg-primary text-white rounded-circle p-3 me-3">
                                                        <i class="fas fa-file-pdf fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title text-dark mb-1">@lang('transfer.student.cv')</h5>
                                                        <p class="text-muted mb-0">@lang('transfer.student.download_document')</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => 'motivation_letter']) }}" 
                                           class="card document-card h-100 text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="document-icon bg-primary text-white rounded-circle p-3 me-3">
                                                        <i class="fas fa-file-pdf fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title text-dark mb-1">@lang('transfer.student.motivation_letter')</h5>
                                                        <p class="text-muted mb-0">@lang('transfer.student.download_document')</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => 'id_document']) }}" 
                                           class="card document-card h-100 text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="document-icon bg-primary text-white rounded-circle p-3 me-3">
                                                        <i class="fas fa-file-pdf fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title text-dark mb-1">@lang('transfer.student.id_document')</h5>
                                                        <p class="text-muted mb-0">@lang('transfer.student.download_document')</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h4 class="alert-heading mb-1">@lang('transfer.student.no_request_found')</h4>
                                <p class="mb-0">@lang('transfer.student.no_request_description')</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .card-header {
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .document-card {
        border: 1px solid rgba(0,0,0,.125);
        transition: all 0.3s ease;
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
    }

    .document-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 1em;
    }

    .table th {
        font-weight: 600;
    }

    .alert {
        border: none;
        border-radius: 0.5rem;
    }
</style>
@endpush 