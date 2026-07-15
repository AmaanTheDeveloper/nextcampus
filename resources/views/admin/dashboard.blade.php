@extends('layouts.dashboard-layout')

@section('page-title', 'Admin Dashboard')

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-premium p-3 h-100 border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Total Students</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $studentsCount }}</h3>
                </div>
                <div class="fs-2 text-primary opacity-75"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-premium p-3 h-100 border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Total Teachers</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $teachersCount }}</h3>
                </div>
                <div class="fs-2 text-success opacity-75"><i class="bi bi-person-badge"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-premium p-3 h-100 border-start border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Companies</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $companiesCount }}</h3>
                </div>
                <div class="fs-2 text-warning opacity-75"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-premium p-3 h-100 border-start border-4 border-info">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Active Internships</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $activeInternships }}</h3>
                </div>
                <div class="fs-2 text-info opacity-75"><i class="bi bi-briefcase"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHART + QUICK ACTIONS ===== --}}
<div class="row g-3 mb-4">
    {{-- Registration Chart --}}
    <div class="col-12 col-lg-8">
        <div class="card card-premium p-4 h-100">
            <h5 class="fw-bold text-navy mb-4">
                <i class="bi bi-graph-up-arrow text-primary me-2"></i>User Registrations (Last 6 Months)
            </h5>
            <div style="position:relative;min-height:200px;">
                <canvas id="registrationsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-12 col-lg-4">
        <div class="card card-premium p-4 h-100">
            <h5 class="fw-bold text-navy mb-3">
                <i class="bi bi-lightning-charge text-primary me-2"></i>Quick Actions
            </h5>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.approvals') }}" class="btn btn-premium w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-person-check fs-5"></i>
                    <span>Review Pending Approvals</span>
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-premium-outline w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-people fs-5"></i>
                    <span>Manage All Users</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="btn btn-premium-outline w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-tags fs-5"></i>
                    <span>Manage Categories</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="btn btn-premium-outline w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-bar-graph fs-5"></i>
                    <span>Export Reports</span>
                </a>
                <a href="{{ route('admin.logs') }}" class="btn btn-premium-outline w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-activity fs-5"></i>
                    <span>View Activity Logs</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('registrationsChart');
    if (!ctx) return;
    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'New Registrations',
                data: {!! json_encode($registrations) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                borderColor: 'rgba(30, 58, 138, 1)',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection