@extends('layouts.dashboard-layout')

@section('page-title', 'Company Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-navy), #3b82f6); color: white;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="z-index-1 position-relative">
                    <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->companyProfile->company_name ?? auth()->user()->name }}! 🏢</h2>
                    <p class="mb-4 opacity-75">Find the best talent for your organization. Manage your internship postings and review incoming applications.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('company.internships.create') }}" class="btn btn-light text-primary fw-bold px-4"><i class="bi bi-plus-lg me-2"></i>Post New Internship</a>
                        <a href="{{ route('company.applications') }}" class="btn btn-outline-light"><i class="bi bi-people me-2"></i>Review Applicants</a>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="position-absolute" style="right: 5%; top: -20%; opacity: 0.1;">
                    <i class="bi bi-buildings" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Posted Internships</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $internshipsCount ?? 0 }}</h3>
                <span class="badge bg-primary-subtle text-primary mt-2"><i class="bi bi-briefcase me-1"></i>Active Roles</span>
            </div>
            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-briefcase fs-4 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Total Applications</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $applicationsCount ?? 0 }}</h3>
                <span class="badge bg-info-subtle text-info mt-2"><i class="bi bi-people me-1"></i>Candidates</span>
            </div>
            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-people fs-4 text-info"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Shortlisted</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $shortlistedCount ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-person-check me-1"></i>In Progress</span>
            </div>
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-person-check fs-4 text-success"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card card-premium p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Recent Internship Postings</h5>
                <a href="{{ route('company.internships.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top border-bottom small">
                    <thead class="table-light text-secondary text-uppercase">
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-navy">
                        @forelse($recentPostings ?? [] as $item)
                            <tr>
                                <td class="fw-bold">{{ $item->title }}</td>
                                <td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $item->location }}</td>
                                <td class="text-danger"><i class="bi bi-clock me-1"></i>{{ $item->deadline->format('M d, Y') }}</td>
                                <td>
                                    @if($item->status === 'active')
                                        <span class="badge bg-success-subtle text-success border px-2 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1"><i class="bi bi-pause-circle me-1"></i>{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('company.internships.edit', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>
                                    No internships posted yet.<br>
                                    <a href="{{ route('company.internships.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">Post Your First Internship</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4">
        <!-- Quick Actions Row -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions</h5>
            
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('company.internships.create') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-primary-subtle')" onmouseout="this.classList.remove('bg-primary-subtle')">
                    <div class="bg-primary rounded p-2 text-white">
                        <i class="bi bi-briefcase fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Post Internship</div>
                        <div class="text-muted small">Find the best talent</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>

                <a href="{{ route('company.applications') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-info-subtle')" onmouseout="this.classList.remove('bg-info-subtle')">
                    <div class="bg-info rounded p-2 text-white">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Review Applicants</div>
                        <div class="text-muted small">Manage incoming applications</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>
            </div>
        </div>
        
        <!-- Applicant Funnel Stats -->
        <div class="card card-premium p-4 border-0 shadow-sm" style="background-color: var(--primary-navy); color: white;">
            <h5 class="fw-bold text-white mb-4"><i class="bi bi-funnel text-info me-2"></i>Recruitment Pipeline</h5>
            
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-eye me-2"></i>Profile Views</span>
                <span class="fw-bold fs-5">450+</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-send me-2"></i>Applications Received</span>
                <span class="fw-bold fs-5">{{ $applicationsCount ?? 0 }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-white-50"><i class="bi bi-person-check me-2"></i>Candidates Shortlisted</span>
                <span class="fw-bold fs-5 text-success">{{ $shortlistedCount ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>
@endsection