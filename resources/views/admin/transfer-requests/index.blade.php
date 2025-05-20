@extends('layouts.app')

@section('content')

<form method="GET" action="{{ route('admin.transfer-requests.index') }}" class="mb-4 d-flex flex-wrap gap-3 align-items-end" aria-label="@lang('transfer.admin.filter_form_label')">
    <fieldset class="d-flex flex-wrap gap-3 border p-3 rounded w-100">
        <legend class="mb-2">@lang('transfer.admin.filters')</legend>

        {{-- Barre de recherche --}}
        <div class="form-group flex-grow-1" style="min-width: 250px;">
            <label for="search" class="form-label">@lang('transfer.admin.search')</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </span>
                <input type="text" name="search" id="search" class="form-control" 
                       value="{{ request('search') }}" 
                       placeholder="@lang('transfer.admin.search_placeholder')"
                       aria-label="@lang('transfer.admin.search')">
            </div>
        </div>

        {{-- Statut --}}
        <div class="form-group flex-grow-1" style="min-width: 180px;">
            <label for="status" class="form-label">@lang('transfer.admin.filter_status')</label>
            <select name="status" id="status" class="form-select" aria-label="@lang('transfer.admin.filter_status')">
                <option value="">-- @lang('transfer.admin.all_statuses') --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@lang('transfer.status.pending')</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>@lang('transfer.status.accepted')</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>@lang('transfer.status.rejected')</option>
            </select>
        </div>

        {{-- Formation Filter -->
        <div class="mb-4">
            <label for="formation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ __('transfer.admin.filters.formation') }}
            </label>
            <select name="formation" id="formation" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">{{ __('transfer.admin.filters.all_formations') }}</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation }}" {{ request('formation') == $formation ? 'selected' : '' }}>
                        {{ $formation }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Year Filter -->
        <div class="mb-4">
            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ __('transfer.admin.filters.year') }}
            </label>
            <select name="year" id="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">{{ __('transfer.admin.filters.all_years') }}</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Boutons --}}
        <div class="d-flex gap-2 align-items-center" style="min-width: 180px;">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" aria-label="@lang('transfer.admin.filter')">
                <i class="fas fa-filter" aria-hidden="true"></i> @lang('transfer.admin.filter')
            </button>
            <a href="{{ route('admin.transfer-requests.index') }}" class="btn btn-outline-secondary" aria-label="@lang('transfer.admin.reset_filters')">
                <i class="fas fa-undo" aria-hidden="true"></i> @lang('transfer.admin.reset')
            </a>
        </div>
    </fieldset>
</form>

<div class="requests-container">
    @forelse($transferRequests as $request)
        @php
            $statusConfig = [
                'pending'   => ['class' => 'warning', 'icon' => 'clock', 'tooltip' => 'En attente de traitement'],
                'confirmed' => ['class' => 'info', 'icon' => 'check-circle', 'tooltip' => 'Demande confirmée'],
                'accepted'  => ['class' => 'success', 'icon' => 'check-double', 'tooltip' => 'Demande acceptée'],
                'rejected'  => ['class' => 'danger', 'icon' => 'times-circle', 'tooltip' => 'Demande rejetée'],
            ];
            $config = $statusConfig[$request->status] ?? $statusConfig['pending'];
        @endphp

        <article class="request-card" aria-labelledby="request-title-{{ $request->id }}" tabindex="0">
            <header class="request-header">
                <div class="student-info">
                    <h3 id="request-title-{{ $request->id }}" class="mb-1">
                        {{ $request->student->name }} {{ $request->student->firstname }}
                    </h3>
                    <p>
                        <a href="mailto:{{ $request->student->email }}" class="student-email" tabindex="-1">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            {{ $request->student->email }}
                        </a>
                    </p>
                </div>

                <div class="request-meta" aria-label="@lang('transfer.admin.request_info')">
                    <span class="request-number">#{{ $loop->iteration }}</span>
                    <time datetime="{{ $request->request_date->toIso8601String() }}" class="request-date">
                        <i class="far fa-calendar-alt" aria-hidden="true"></i>
                        {{ $request->request_date->format('d/m/Y H:i') }}
                    </time>
                </div>
            </header>

            <section class="request-details">
                <div class="detail-item">
                    <label>@lang('transfer.admin.current_institution') :</label>
                    <span>{{ $request->current_institution }}</span>
                </div>
                <div class="detail-item">
                    <label>@lang('transfer.admin.current_formation') :</label>
                    <span>{{ $request->current_formation }}</span>
                </div>
                <div class="detail-item">
                    <label>@lang('transfer.admin.average_grade') :</label>
                    <span>{{ number_format($request->average_grade, 2) }}</span>
                </div>
            </section>

            <footer class="request-footer">
                <div class="status-badge" role="status" aria-live="polite" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $config['tooltip'] }}">
                    <span class="badge bg-{{ $config['class'] }}">
                        <i class="fas fa-{{ $config['icon'] }}" aria-hidden="true"></i>
                        @lang('transfer.status.' . $request->status)
                    </span>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('admin.transfer-requests.show', $request) }}" class="btn btn-primary" aria-label="@lang('transfer.admin.view_details')">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                        @lang('transfer.admin.view_details')
                    </a>
                </div>
            </footer>
        </article>
    @empty
        <div class="no-requests" role="alert" aria-live="polite">
            <i class="fas fa-inbox" aria-hidden="true"></i>
            <p>@lang('transfer.admin.no_requests')</p>
        </div>
    @endforelse
</div>

{{ $transferRequests->links() }}

<style>
.requests-container {
    display: grid;
    gap: 1.5rem;
    padding: 1rem;
}

.request-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    padding: 1.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    outline-offset: 4px;
    position: relative;
    overflow: hidden;
}

.request-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--bs-primary);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.request-card:hover::before,
.request-card:focus-within::before {
    opacity: 1;
}

.request-card:hover,
.request-card:focus-within,
.request-card:focus {
    box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
    transform: translateY(-3px);
    cursor: pointer;
}

.request-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.student-info h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #222;
    font-weight: 600;
}

.student-info p {
    margin: 0.25rem 0 0;
    color: #555;
    font-size: 0.9rem;
}

.student-email {
    color: #666;
    text-decoration: none;
    transition: color 0.2s ease;
}

.student-email:hover,
.student-email:focus {
    color: var(--bs-primary);
    text-decoration: none;
}

.student-email i {
    margin-right: 0.5rem;
    font-size: 0.9em;
}

.request-meta {
    text-align: right;
    min-width: 130px;
    font-size: 0.85rem;
    color: #888;
}

.request-number {
    display: block;
    font-weight: 600;
    color: var(--bs-primary);
}

.request-date {
    display: block;
    font-style: italic;
}

.request-date i {
    margin-right: 0.25rem;
}

.request-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.2rem;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item label {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.detail-item span {
    font-weight: 600;
    color: #333;
}

.request-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #ddd;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.status-badge .badge {
    padding: 0.45rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge .badge i {
    font-size: 1em;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-buttons .btn {
    padding: 0.45rem 1rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.action-buttons .btn:hover,
.action-buttons .btn:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgb(0 123 255 / 0.3);
}

.no-requests {
    text-align: center;
    padding: 3rem 1rem;
    color: #777;
    font-size: 1.1rem;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px dashed #ddd;
}

.no-requests i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #bbb;
}

@media (max-width: 768px) {
    .request-header {
        flex-direction: column;
    }

    .request-meta {
        text-align: left;
        margin-top: 0.5rem;
    }

    .request-footer {
        flex-direction: column;
        gap: 1rem;
    }

    .action-buttons {
        width: 100%;
    }

    .action-buttons .btn {
        width: 100%;
        justify-content: center;
    }

    .request-details {
        grid-template-columns: 1fr;
    }
}

/* Animation pour les cartes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.request-card {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Style pour les tooltips */
.tooltip {
    font-size: 0.85rem;
}

.tooltip-inner {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Animation des cartes au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.request-card').forEach((card) => {
        observer.observe(card);
    });
});
</script>
@endpush

@endsection
