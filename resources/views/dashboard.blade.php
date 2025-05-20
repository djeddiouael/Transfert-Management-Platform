@extends('layouts.app')
@section('title', __('dashboard.dashboard'))
@section('content')
@if(auth()->user()->user_type !== 'admin')
    @include('demende', ['transfer_request' => $transfer_request])
@else
<div class="dashboard-overview">
    <!-- Navigation Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="dashboard-title">@lang('dashboard.dashboard')</h1>
                <p class="dashboard-subtitle">@lang('dashboard.welcome')</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->user_type }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-content">
            <div class="filter-group">
                <label for="dateRange">@lang('dashboard.filter.date_range')</label>
                <select id="dateRange" class="form-control">
                    <option value="all">@lang('dashboard.filter.all_time')</option>
                    <option value="month">@lang('dashboard.filter.last_month')</option>
                    <option value="quarter">@lang('dashboard.filter.last_quarter')</option>
                    <option value="year">@lang('dashboard.filter.last_year')</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="facultyFilter">@lang('dashboard.filter.faculty')</label>
                <select id="facultyFilter" class="form-control">
                    <option value="all">@lang('dashboard.filter.all_faculties')</option>
                    @foreach($facultyStats ?? collect() as $faculty)
                        <option value="{{ $faculty->name }}">{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="departmentFilter">@lang('dashboard.filter.department')</label>
                <select id="departmentFilter" class="form-control">
                    <option value="all">@lang('dashboard.filter.all_departments')</option>
                    @foreach($departmentStats as $department)
                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="statusFilter">@lang('dashboard.filter.status')</label>
                <select id="statusFilter" class="form-control">
                    <option value="all">@lang('dashboard.filter.all_status')</option>
                    <option value="pending">@lang('transfer.status.pending')</option>
                    <option value="accepted">@lang('transfer.status.accepted')</option>
                    <option value="rejected">@lang('transfer.status.rejected')</option>
                </select>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Overview Cards -->
        <div class="overview-section">
            <div class="overview-grid">
            <div class="overview-card total-transfers">
                <div class="card-icon">
                <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="card-info">
                <span class="card-value">{{ $totalTransfers ?? 0 }}</span>
                <span class="card-title">@lang('transfer.admin.statistics.total_requests')</span>
                </div>
            </div>

            <div class="overview-card pending-transfers">
                <div class="card-icon">
                <i class="fas fa-clock"></i>
                </div>
                <div class="card-info">
                <span class="card-value">{{ $pendingTransfers ?? 0 }}</span>
                <span class="card-title">@lang('transfer.admin.statistics.pending_requests')</span>
                </div>
            </div>

            <div class="overview-card accepted-transfers">
                <div class="card-icon">
                <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-info">
                <span class="card-value">{{ $acceptedTransfers ?? 0 }}</span>
                <span class="card-title">@lang('transfer.admin.statistics.accepted_requests')</span>
                </div>
            </div>

            <div class="overview-card rejected-transfers">
                <div class="card-icon">
                <i class="fas fa-times-circle"></i>
                </div>
                <div class="card-info">
                <span class="card-value">{{ $rejectedTransfers ?? 0 }}</span>
                <span class="card-title">@lang('transfer.admin.statistics.rejected_requests')</span>
                </div>
            </div>
            </div>
        </div>

<!-- Main Statistics Section -->
<div class="statistics-section">
    <div class="statistics-grid">

        <!-- Status Distribution -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.status_distribution')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart1', [
                'pendingTransfers' => $pendingTransfers,
                'acceptedTransfers' => $acceptedTransfers,
                'rejectedTransfers' => $rejectedTransfers,
            ])
        </div>

        <!-- Monthly Trend -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.monthly_trend')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart2')
        </div>

        <!-- Department Distribution -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.by_department')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart3')
        </div>

        <!-- Faculty Distribution -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.by_faculty')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart4')
        </div>

        <!-- Specialization Distribution -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.by_specialization')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart5')
        </div>

        <!-- Transfer Timeline -->
        <div class="statistics-card">
            <div class="card-header">
                <h3>@lang('transfer.admin.statistics.transfer_timeline')</h3>
                <div class="card-actions">
                    <button class="btn-icon" aria-label="Options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            @include('charts.chart6')
        </div>

    </div>
</div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/dashbordstyle.css') }}">

{{-- @push('scripts') --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: [
                '@lang("transfer.status.pending")',
                '@lang("transfer.status.accepted")',
                '@lang("transfer.status.rejected")'
            ],
            datasets: [{
                data: [
                    {{ $pendingTransfers }},
                    {{ $acceptedTransfers }},
                    {{ $rejectedTransfers }}
                ],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Monthly Trend Chart
    const monthlyCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(($monthlyStats ?? collect())->pluck('month')) !!},
            datasets: [{
                label: 'Tendance mensuelle',
                data: {!! json_encode(($monthlyStats ?? collect())->pluck('count')) !!},
                fill: true,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Department Chart
    const departmentCtx = document.getElementById('departmentChart').getContext('2d');
    new Chart(departmentCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(($departmentStats ?? collect())->pluck('name')) !!},
            datasets: [{
                label: 'Demandes par département',
                data: {!! json_encode(($departmentStats ?? collect())->pluck('count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Faculty Chart
    const facultyCtx = document.getElementById('facultyChart').getContext('2d');
    new Chart(facultyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(($facultyStats ?? collect())->pluck('name')) !!},
            datasets: [{
                label: 'Demandes par faculté',
                data: {!! json_encode(($facultyStats ?? collect())->pluck('count')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Specialization Chart
    const specializationCtx = document.getElementById('specializationChart').getContext('2d');
    new Chart(specializationCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(($specializationStats ?? collect())->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode(($specializationStats ?? collect())->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Transfer Timeline Chart
    const timelineCtx = document.getElementById('transferTimelineChart').getContext('2d');
    new Chart(timelineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(($monthlyStats ?? collect())->pluck('month')) !!},
            datasets: [
                {
                    label: '@lang("transfer.status.pending")',
                    data: {!! json_encode(($monthlyStats ?? collect())->pluck('pending_count')) !!},
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: true
                },
                {
                    label: '@lang("transfer.status.accepted")',
                    data: {!! json_encode(($monthlyStats ?? collect())->pluck('accepted_count')) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                },
                {
                    label: '@lang("transfer.status.rejected")',
                    data: {!! json_encode(($monthlyStats ?? collect())->pluck('rejected_count')) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        }
    });

    // Filter Event Listeners
    const filters = ['dateRange', 'facultyFilter', 'departmentFilter', 'statusFilter'];
    filters.forEach(filterId => {
        document.getElementById(filterId).addEventListener('change', function() {
            updateCharts();
        });
    });

    function updateCharts() {
        const filters = {
            dateRange: document.getElementById('dateRange').value,
            faculty: document.getElementById('facultyFilter').value,
            department: document.getElementById('departmentFilter').value,
            status: document.getElementById('statusFilter').value
        };

        fetch('/dashboard/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {
            updateChartData(data);
        });
    }

    function updateChartData(data) {
        // Update each chart with new data
        // This is a placeholder - implement actual chart updates based on your data structure
        console.log('Updating charts with new data:', data);
    }
}); --}}
{{-- </script> --}}
{{-- @endpush --}}
@endif
@endsection


