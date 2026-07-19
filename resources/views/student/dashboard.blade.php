@extends('layouts.dashboard-layout')

@section('page-title', 'Student Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-blue), var(--steel-blue)); color: white;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="z-index-1 position-relative">
                    <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 🚀</h2>
                    <p class="mb-4 opacity-75">Your career journey is looking bright. Complete your profile to unlock AI-powered opportunities.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('student.resume') }}" class="btn btn-light text-primary fw-bold"><i class="bi bi-magic me-2"></i>AI Career Assistant</a>
                        <a href="{{ route('profile.settings') }}" class="btn btn-outline-light"><i class="bi bi-person-lines-fill me-2"></i>Complete Profile</a>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="position-absolute" style="right: -5%; top: -20%; opacity: 0.1;">
                    <i class="bi bi-mortarboard-fill" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics Row -->
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Applied Internships</h6>
                <h3 class="fw-bold text-navy mb-0">{{ $appliedInternshipsCount ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-arrow-up-right me-1"></i>Active</span>
            </div>
            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-briefcase fs-4 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Competitions</h6>
                <h3 class="fw-bold text-navy mb-0">{{ $registeredCompetitionsCount ?? 0 }}</h3>
                <span class="badge bg-warning-subtle text-warning mt-2"><i class="bi bi-lightning-fill me-1"></i>Registered</span>
            </div>
            <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-trophy fs-4 text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Upcoming Events</h6>
                <h3 class="fw-bold text-navy mb-0">{{ $registeredEventsCount ?? 0 }}</h3>
                <span class="badge bg-info-subtle text-info mt-2"><i class="bi bi-calendar-check me-1"></i>Attending</span>
            </div>
            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-calendar-event fs-4 text-info"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Certificates</h6>
                <h3 class="fw-bold text-navy mb-0">{{ $certificatesCount ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-shield-check me-1"></i>Verified</span>
            </div>
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-patch-check fs-4 text-success"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Column -->
    <div class="col-lg-8">
        
        <!-- Career Progress & Verification Status -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Career Readiness Profile</h5>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded-4 p-4 text-center h-100 bg-light">
                        <i class="bi bi-person-vcard text-secondary fs-1 mb-2 d-block"></i>
                        <h6 class="fw-bold text-navy">Profile Completion</h6>
                        <div class="progress mt-3 mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="small text-secondary fw-semibold">65% Completed</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded-4 p-4 text-center h-100 bg-light">
                        <i class="bi bi-shield-lock text-success fs-1 mb-2 d-block"></i>
                        <h6 class="fw-bold text-navy">Student Verification</h6>
                        @if(auth()->user()->is_approved)
                            <div class="mt-3">
                                <span class="badge bg-success px-3 py-2 rounded-pill fs-6"><i class="bi bi-check-circle me-1"></i>Verified Student</span>
                            </div>
                            <p class="small text-secondary mt-2 mb-0">Your account is fully verified.</p>
                        @else
                            <div class="mt-3">
                                <span class="badge bg-warning px-3 py-2 rounded-pill fs-6 text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending Verification</span>
                            </div>
                            <p class="small text-secondary mt-2 mb-0">Verified students unlock premium internships.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications Table -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-file-earmark-check text-primary me-2"></i>Recent Applications</h5>
                <a href="{{ route('student.internships') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top border-bottom">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th>Internship Role</th>
                            <th>Company</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="small text-navy">
                        @forelse($recentApplications ?? [] as $app)
                            <tr>
                                <td class="fw-bold">{{ $app->internship->title ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($app->internship?->company?->companyProfile?->company_name ?? $app->internship?->company?->name ?? 'C') }}&background=random" class="rounded" width="24" height="24">
                                        {{ $app->internship?->company?->companyProfile?->company_name ?? $app->internship?->company?->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>{{ $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($app->status === 'applied')
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 border"><i class="bi bi-send me-1"></i>Applied</span>
                                    @elseif($app->status === 'shortlisted')
                                        <span class="badge bg-success-subtle text-success px-2 py-1 border"><i class="bi bi-check-circle me-1"></i>Shortlisted</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1 border"><i class="bi bi-x-circle me-1"></i>Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>
                                    No recent internship applications found.<br>
                                    <a href="{{ route('guest.internships') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">Explore Opportunities</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Featured Notes / Study Vault Summary -->
        <div class="card card-premium p-4 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-journal-arrow-down text-primary me-2"></i>Study Materials Overview</h5>
                <a href="{{ route('student.notes') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Open Vault</a>
            </div>
            
            <div class="row g-3">
                @forelse($latestNotes ?? [] as $note)
                    <div class="col-md-4 col-sm-6">
                        <div class="p-3 border rounded-3 bg-white hover-shadow transition d-flex flex-column h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="bg-danger-subtle text-danger rounded p-2 d-inline-flex">
                                    <i class="bi bi-file-earmark-pdf fs-5"></i>
                                </div>
                                <span class="badge bg-light text-dark border">{{ $note->semester }}</span>
                            </div>
                            <h6 class="fw-bold text-navy mb-1 text-truncate" title="{{ $note->title }}">{{ $note->title }}</h6>
                            <p class="text-secondary small mb-3 text-truncate">{{ $note->subject }}</p>
                            <a href="{{ route('notes.download', $note->id) }}" class="mt-auto btn btn-outline-premium btn-sm w-100 rounded-pill"><i class="bi bi-download me-1"></i>Download</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-secondary py-4">
                        <i class="bi bi-folder2-open fs-2 d-block mb-2 text-muted"></i>
                        No study materials available yet.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Sidebar Column -->
    <div class="col-lg-4">
        
        <!-- Activity Timeline -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-activity text-primary me-2"></i>Recent Activity</h5>
            <div class="position-relative ms-2">
                <div class="position-absolute h-100 border-start border-2" style="left: 6px; top: 0; border-color: #e2e8f0 !important;"></div>
                
                <div class="position-relative mb-3 ps-4">
                    <span class="position-absolute bg-primary rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Logged into NextCampus Enterprise</p>
                    <span class="text-muted" style="font-size: 0.75rem;">Just now</span>
                </div>
                <div class="position-relative mb-3 ps-4">
                    <span class="position-absolute bg-success rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Profile updated</p>
                    <span class="text-muted" style="font-size: 0.75rem;">2 hours ago</span>
                </div>
                <div class="position-relative mb-3 ps-4">
                    <span class="position-absolute bg-warning rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Viewed National Hackathon</p>
                    <span class="text-muted" style="font-size: 0.75rem;">Yesterday</span>
                </div>
                <div class="position-relative ps-4">
                    <span class="position-absolute bg-secondary rounded-circle border border-2 border-white" style="width: 14px; height: 14px; left: 0; top: 4px;"></span>
                    <p class="mb-0 fw-semibold text-navy small">Account created</p>
                    <span class="text-muted" style="font-size: 0.75rem;">Last week</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Schedule -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4" style="background-color: var(--primary-navy); color: white;">
            <h5 class="fw-bold text-white mb-4"><i class="bi bi-calendar-event text-info me-2"></i>Upcoming Schedule</h5>
            
            <div class="d-flex flex-column gap-3">
                @forelse($upcomingEvents ?? [] as $event)
                    <div class="p-3 rounded-3" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-info text-navy">{{ $event->event_date->format('M d') }}</span>
                            <span class="small text-white-50"><i class="bi bi-clock me-1"></i>{{ $event->event_date->format('H:i') }}</span>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $event->title }}</h6>
                        <div class="text-white-50 small text-truncate"><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-white-50 fs-2 d-block mb-2"></i>
                        <p class="text-white-50 small mb-0">No upcoming events on your schedule.</p>
                        <a href="{{ route('guest.events') }}" class="btn btn-sm btn-outline-light mt-3 rounded-pill">Discover Events</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card card-premium p-4 border-0 shadow-sm">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('student.resume') }}" class="btn btn-light text-start text-navy border fw-semibold px-3 py-2 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-primary-subtle')" onmouseout="this.classList.remove('bg-primary-subtle')"><i class="bi bi-file-earmark-person me-2 text-primary"></i> Update Resume</a>
                <a href="{{ route('guest.scholarships') }}" class="btn btn-light text-start text-navy border fw-semibold px-3 py-2 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-warning-subtle')" onmouseout="this.classList.remove('bg-warning-subtle')"><i class="bi bi-award me-2 text-warning"></i> Find Scholarships</a>
                <a href="{{ route('student.forum') }}" class="btn btn-light text-start text-navy border fw-semibold px-3 py-2 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-success-subtle')" onmouseout="this.classList.remove('bg-success-subtle')"><i class="bi bi-chat-square-text me-2 text-success"></i> Community Forum</a>
                <a href="{{ route('guest.internships') }}" class="btn btn-light text-start text-navy border fw-semibold px-3 py-2 rounded-3" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-info-subtle')" onmouseout="this.classList.remove('bg-info-subtle')"><i class="bi bi-search me-2 text-info"></i> Search Jobs</a>
            </div>
        </div>

    </div>
</div>
@endsection