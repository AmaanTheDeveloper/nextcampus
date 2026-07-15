@extends('layouts.dashboard-layout')

@section('page-title', 'Student Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Applied Internships</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $appliedInternshipsCount }}</h3>
                </div>
                <div class="fs-2 text-primary"><i class="bi bi-briefcase"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Competitions</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $registeredCompetitionsCount }}</h3>
                </div>
                <div class="fs-2 text-success"><i class="bi bi-trophy"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium border-start border-4 border-info">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Registered Events</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $registeredEventsCount }}</h3>
                </div>
                <div class="fs-2 text-info"><i class="bi bi-calendar-event"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-4 card-premium border-start border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Certificates Vault</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $certificatesCount }}</h3>
                </div>
                <div class="fs-2 text-warning"><i class="bi bi-shield-lock"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Applications -->
    <div class="col-lg-8">
        <div class="card card-premium p-4 h-100">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-file-earmark-check text-primary me-2"></i>Recent Internship Applications</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th>Internship Role</th>
                            <th>Company</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="small text-navy">
                        @forelse($recentApplications as $app)
                            <tr>
                                <td class="fw-bold">{{ $app->internship->title }}</td>
                                <td>{{ $app->internship?->company?->companyProfile?->company_name ?? $app->internship?->company?->name ?? 'N/A' }}</td>
                                <td>{{ $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($app->status === 'applied')
                                        <span class="badge bg-secondary">Applied</span>
                                    @elseif($app->status === 'shortlisted')
                                        <span class="badge bg-success">Shortlisted</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-4">No recent internship applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Event schedule -->
    <div class="col-lg-4">
        <div class="card card-premium p-4 h-100">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-calendar2-week text-primary me-2"></i>My Registered Events</h5>
            <div class="d-flex flex-column gap-3">
                @forelse($upcomingEvents as $event)
                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-navy mb-1">{{ $event->title }}</h6>
                        <span class="badge bg-primary-subtle text-primary mb-2">{{ $event->type }}</span>
                        <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $event->event_date->format('M d, Y @ h:i A') }}</div>
                        <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</div>
                    </div>
                @empty
                    <p class="text-secondary small py-4 text-center">No upcoming registered events.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Featured Notes -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-file-pdf text-primary me-2"></i>Recent Study Materials</h5>
            <div class="row g-3">
                @forelse($latestNotes as $note)
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 border rounded-3 bg-light d-flex flex-column justify-content-between h-100">
                            <div>
                                <span class="badge bg-secondary mb-2">{{ $note->semester }}</span>
                                <h6 class="fw-bold text-navy mb-1 text-truncate">{{ $note->title }}</h6>
                                <span class="text-muted small d-block mb-2">Subject: {{ $note->subject }}</span>
                            </div>
                            <a href="{{ route('notes.download', $note->id) }}" class="btn btn-premium btn-sm w-100"><i class="bi bi-download"></i> Download</a>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary small py-2">No study materials uploaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection