@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Retour --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">
            <i class="fas fa-file-alt me-2"></i> @lang('transfer.details.title')
        </h2>
        <a href="{{ route('admin.transfer-requests.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> @lang('transfer.buttons.back')
        </a>
    </div>

    {{-- Informations personnelles --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-user me-2"></i>
            <h4 class="mb-0">@lang('transfer.personal_info.title')</h4>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4 text-muted">@lang('transfer.personal_info.lastname')</dt>
                <dd class="col-sm-8">{{ $transferRequest->student->name }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.personal_info.firstname')</dt>
                <dd class="col-sm-8">{{ $transferRequest->student->firstname }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.personal_info.email')</dt>
                <dd class="col-sm-8">{{ $transferRequest->student->email }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.personal_info.phone')</dt>
                <dd class="col-sm-8">{{ $transferRequest->student->phone }}</dd>
            </dl>
        </div>
    </div>

    {{-- Formation actuelle --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-graduation-cap me-2"></i>
            <h4 class="mb-0">@lang('transfer.current_formation.title')</h4>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4 text-muted">@lang('transfer.current_formation.institution')</dt>
                <dd class="col-sm-8">{{ $transferRequest->current_institution }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.current_formation.formation')</dt>
                <dd class="col-sm-8">{{ $transferRequest->current_formation }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.current_formation.year')</dt>
                <dd class="col-sm-8">{{ $transferRequest->current_year }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.current_formation.average_grade')</dt>
                <dd class="col-sm-8">{{ $transferRequest->average_grade }}</dd>

                <dt class="col-sm-4 text-muted">@lang('transfer.current_formation.specialization')</dt>
                <dd class="col-sm-8">{{ $transferRequest->specialization }}</dd>
            </dl>

            @if($transferRequest->projects)
            <hr>
            <h5 class="text-primary">@lang('transfer.current_formation.projects')</h5>
            <p class="border rounded p-3 bg-light">{{ $transferRequest->projects }}</p>
            @endif
        </div>
    </div>

    {{-- Motivation --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-lightbulb me-2"></i>
            <h4 class="mb-0">@lang('transfer.motivation.title')</h4>
        </div>
        <div class="card-body">
            <section class="mb-4">
                <h5 class="text-muted">@lang('transfer.motivation.why_paris_saclay')</h5>
                <p class="border rounded p-3 bg-light">{{ $transferRequest->motivation }}</p>
            </section>

            <section class="mb-4">
                <h5 class="text-muted">@lang('transfer.motivation.career_plan')</h5>
                <p class="border rounded p-3 bg-light">{{ $transferRequest->career_plan }}</p>
            </section>

            <section class="mb-4">
                <h5 class="text-muted">@lang('transfer.motivation.desired_formation')</h5>
                <p>{{ $transferRequest->desired_formation }}</p>
            </section>

            @if($transferRequest->technical_skills)
            <section class="mb-4">
                <h5 class="text-muted">@lang('transfer.motivation.technical_skills')</h5>
                <p class="border rounded p-3 bg-light">{{ $transferRequest->technical_skills }}</p>
            </section>
            @endif

            @if($transferRequest->languages && count($transferRequest->languages) > 0)
            <section>
                <h5 class="text-muted">@lang('transfer.motivation.languages')</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($transferRequest->languages as $language)
                    <span class="badge bg-primary-subtle text-primary">{{ $language }}</span>
                    @endforeach
                </div>
            </section>
            @endif
        </div>
    </div>

    {{-- Documents --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-file-pdf me-2"></i>
            <h4 class="mb-0">@lang('transfer.documents.title')</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @php
                    $docs = [
                        'transcript' => 'transfer.documents.transcript',
                        'cv' => 'transfer.documents.cv',
                        'motivation_letter' => 'transfer.documents.motivation_letter',
                        'id_document' => 'transfer.documents.id_document',
                    ];
                @endphp
                @foreach($docs as $type => $label)
                <div class="col-md-6">
                    <a href="{{ route('admin.transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => $type]) }}"
                       class="card h-100 text-decoration-none border-0 shadow-sm document-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="document-icon bg-primary-subtle text-primary rounded-circle p-3">
                                <i class="fas fa-file-pdf fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 text-dark">@lang($label)</h5>
                                <small class="text-muted">@lang('transfer.student.download_document')</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                @if($transferRequest->certificates_paths)
                    @foreach($transferRequest->certificates_paths as $index => $certificate)
                    <div class="col-md-6">
                        <a href="{{ route('admin.transfer-requests.download', ['transferRequest' => $transferRequest, 'documentType' => 'certificates', 'index' => $index]) }}"
                           class="card h-100 text-decoration-none border-0 shadow-sm document-card">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="document-icon bg-primary-subtle text-primary rounded-circle p-3">
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark">@lang('transfer.documents.certificate') {{ $index + 1 }}</h5>
                                    <small class="text-muted">@lang('transfer.student.download_document')</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Mise à jour du statut ou affichage du statut --}}
    @if($transferRequest->status == 'pending')
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-edit me-2"></i>
            <h4 class="mb-0">@lang('transfer.status.update')</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.transfer-requests.update-status', $transferRequest) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('transfer.status.title')</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="accepted">@lang('transfer.status.accepted')</option>
                        <option value="rejected">@lang('transfer.status.rejected')</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="admin_notes" class="form-label">@lang('transfer.status.notes')</label>
                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" required></textarea>
                    <small class="text-muted">@lang('transfer.status.notes_help', [], 'fr')</small>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> @lang('transfer.buttons.update_status')
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-info-circle me-2"></i>
            <h4 class="mb-0">@lang('transfer.status.current')</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-{{ $transferRequest->status_badge }} d-flex align-items-center gap-3 mb-0 shadow-sm">
                <i class="fas fa-info-circle fa-2x"></i>
                <div>
                    <h5 class="mb-1">{{ $transferRequest->status_text }}</h5>
                    <p class="mb-1">{{ $transferRequest->status_details }}</p>
                    @if($transferRequest->admin_notes)
                    <hr>
                    <div class="bg-light p-3 rounded">
                        <h6>@lang('transfer.status.notes') :</h6>
                        <p class="mb-0">{{ $transferRequest->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
