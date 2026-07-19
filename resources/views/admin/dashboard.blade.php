@extends('layouts.dashboard-layout')

@section('page-title', 'Admin Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-navy), #1e293b); color: white;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="z-index-1 position-relative">
                    <h2 class="fw-bold mb-2">Welcome back, Admin! 🛡️</h2>
                    <p class="mb-4 opacity-75">Here is what's happening on the NextCampus platform today. You have pending approvals that need attention.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('admin.approvals') }}" class="btn btn-primary fw-bold px-4"><i class="bi bi-person-check-fill me-2"></i>Review Pending Approvals</a>
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-light"><i class="bi bi-file-earmark-bar-graph me-2"></i>Generate Reports</a>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="position-absolute" style="right: 5%; top: -20%; opacity: 0.1;">
                    <i class="bi bi-shield-check" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Total Students</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $studentsCount ?? 0 }}</h3>
                <span class="badge bg-primary-subtle text-primary mt-2"><i class="bi bi-mortarboard me-1"></i>Registered</span>
            </div>
            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-people fs-4 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Total Teachers</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $teachersCount ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-person-video3 me-1"></i>Verified</span>
            </div>
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-person-badge fs-4 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Companies</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $companiesCount ?? 0 }}</h3>
                <span class="badge bg-warning-subtle text-warning mt-2"><i class="bi bi-building-check me-1"></i>Partners</span>
            </div>
            <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-building fs-4 text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Active Internships</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $activeInternships ?? 0 }}</h3>
                <span class="badge bg-info-subtle text-info mt-2"><i class="bi bi-briefcase-fill me-1"></i>Live</span>
            </div>
            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-briefcase fs-4 text-info"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Registration Chart --}}
    <div class="col-12 col-lg-8">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm">
            <h5 class="fw-bold text-navy mb-4">
                <i class="bi bi-graph-up-arrow text-primary me-2"></i>User Registrations Overview
            </h5>
            <div style="position:relative;height:300px;width:100%;">
                <canvas id="registrationsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Activity Logs Timeline --}}
    <div class="col-12 col-lg-4">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="bi bi-activity text-primary me-2"></i>System Activity
                </h5>
                <a href="{{ route('admin.logs') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
            </div>
            <div class="position-relative ms-2 mt-2">
                <div class="position-absolute h-100 border-start border-2" style="left: 6px; top: 0; border-color: #e2e8f0 !important;"></div>
                
                <div class="position-relative mb-4 ps-4">
                    <span class="position-absolute bg-primary rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">New company "TechSphere" registered</p>
                    <span class="text-muted" style="font-size: 0.75rem;">10 minutes ago</span>
                </div>
                <div class="position-relative mb-4 ps-4">
                    <span class="position-absolute bg-success rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">System backup completed successfully</p>
                    <span class="text-muted" style="font-size: 0.75rem;">2 hours ago</span>
                </div>
                <div class="position-relative mb-4 ps-4">
                    <span class="position-absolute bg-warning rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Pending teacher approval</p>
                    <span class="text-muted" style="font-size: 0.75rem;">5 hours ago</span>
                </div>
                <div class="position-relative ps-4">
                    <span class="position-absolute bg-danger rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Failed login attempt (Admin)</p>
                    <span class="text-muted" style="font-size: 0.75rem;">Yesterday</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== QUICK ACTIONS & PLATFORM HEALTH ===== --}}
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-heart-pulse text-danger me-2"></i>Platform Health Checks</h5>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded bg-success text-white p-2"><i class="bi bi-database"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold text-navy">Database Status</h6>
                                <span class="small text-secondary">Optimal Performance</span>
                            </div>
                        </div>
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded bg-primary text-white p-2"><i class="bi bi-hdd-network"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold text-navy">Storage Usage</h6>
                                <span class="small text-secondary">32% Utilized (450GB Free)</span>
                            </div>
                        </div>
                        <span class="badge bg-primary">Normal</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded bg-warning text-dark p-2"><i class="bi bi-shield-lock"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold text-navy">Pending Approvals</h6>
                                <span class="small text-secondary">15 Users Awaiting Review</span>
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark">Attention</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded bg-info text-white p-2"><i class="bi bi-cloud-arrow-up"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold text-navy">Cache Servers</h6>
                                <span class="small text-secondary">Redis Cluster Active</span>
                            </div>
                        </div>
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions List --}}
    <div class="col-12 col-lg-4">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm">
            <h5 class="fw-bold text-navy mb-4">
                <i class="bi bi-grid-1x2 text-primary me-2"></i>Management Console
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.approvals') }}" class="btn btn-light text-start text-navy border fw-semibold px-4 py-3 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-primary-subtle')" onmouseout="this.classList.remove('bg-primary-subtle')">
                    <i class="bi bi-person-check fs-5 me-2 text-primary"></i> Pending Approvals
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-light text-start text-navy border fw-semibold px-4 py-3 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-success-subtle')" onmouseout="this.classList.remove('bg-success-subtle')">
                    <i class="bi bi-people fs-5 me-2 text-success"></i> Manage Users
                </a>
                <a href="{{ route('admin.categories') }}" class="btn btn-light text-start text-navy border fw-semibold px-4 py-3 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-warning-subtle')" onmouseout="this.classList.remove('bg-warning-subtle')">
                    <i class="bi bi-tags fs-5 me-2 text-warning"></i> Manage Categories
                </a>
                <a href="{{ route('admin.reports') }}" class="btn btn-light text-start text-navy border fw-semibold px-4 py-3 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-danger-subtle')" onmouseout="this.classList.remove('bg-danger-subtle')">
                    <i class="bi bi-file-earmark-bar-graph fs-5 me-2 text-danger"></i> Export Reports
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
    
    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.8)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.2)');

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($months ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
            datasets: [{
                label: 'New Registrations',
                data: {!! json_encode($registrations ?? [10, 25, 40, 55, 70, 90]) !!},
                backgroundColor: gradient,
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { size: 14, family: 'Inter' },
                    bodyFont: { size: 13, family: 'Inter' },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { stepSize: 20, font: { family: 'Inter' } }
                },
                x: { 
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { family: 'Inter', weight: '600' } }
                }
            }
        }
    });
});
</script>
@endsection