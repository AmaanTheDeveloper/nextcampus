@extends('layouts.dashboard-layout')

@section('page-title', 'Club Leader Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-navy), #8b5cf6); color: white;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="z-index-1 position-relative">
                    <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 🎭</h2>
                    <p class="mb-4 opacity-75">Lead your community to success. Create events, manage registrations, and grow your club's presence on campus.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('club_leader.events.create') }}" class="btn btn-light text-primary fw-bold px-4"><i class="bi bi-calendar-plus me-2"></i>Create New Event</a>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="position-absolute" style="right: 5%; top: -20%; opacity: 0.1;">
                    <i class="bi bi-stars" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">My Hosted Events</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $eventsCount ?? 0 }}</h3>
                <span class="badge bg-primary-subtle text-primary mt-2"><i class="bi bi-calendar-event me-1"></i>Organized</span>
            </div>
            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-calendar-event fs-3 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Total Registrations</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $totalRegistrations ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-people me-1"></i>Attendees</span>
            </div>
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-people fs-3 text-success"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card card-premium p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0"><i class="bi bi-calendar2-week text-primary me-2"></i>My Recent Events</h5>
                <a href="{{ route('club_leader.events.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All Events</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top border-bottom small">
                    <thead class="table-light text-secondary text-uppercase">
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Location</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-navy">
                        @forelse($recentEvents ?? [] as $event)
                            <tr>
                                <td class="fw-bold">{{ $event->title }}</td>
                                <td><span class="badge bg-primary-subtle text-primary border px-2 py-1">{{ $event->type }}</span></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $event->event_date->format('M d, Y') }}</span>
                                        <span class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $event->event_date->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td><i class="bi bi-geo-alt text-muted me-1"></i>{{ $event->location }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('club_leader.events.registrations', $event->id) }}" class="btn btn-light border text-info btn-sm rounded-circle hover-shadow" title="Registrations" style="width:32px;height:32px;padding:0;line-height:30px;">
                                            <i class="bi bi-people"></i>
                                        </a>
                                        <a href="{{ route('club_leader.events.gallery', $event->id) }}" class="btn btn-light border text-warning btn-sm rounded-circle hover-shadow" title="Gallery" style="width:32px;height:32px;padding:0;line-height:30px;">
                                            <i class="bi bi-images"></i>
                                        </a>
                                        <a href="{{ route('club_leader.events.edit', $event->id) }}" class="btn btn-light border text-primary btn-sm rounded-circle hover-shadow" title="Edit" style="width:32px;height:32px;padding:0;line-height:30px;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>
                                    No events created yet.<br>
                                    <a href="{{ route('club_leader.events.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">Create Your First Event</a>
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
                <a href="{{ route('club_leader.events.create') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-primary-subtle')" onmouseout="this.classList.remove('bg-primary-subtle')">
                    <div class="bg-primary rounded p-2 text-white">
                        <i class="bi bi-calendar-plus fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Create Event</div>
                        <div class="text-muted small">Host a new activity</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>

                <a href="{{ route('club_leader.events.index') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-success-subtle')" onmouseout="this.classList.remove('bg-success-subtle')">
                    <div class="bg-success rounded p-2 text-white">
                        <i class="bi bi-kanban fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Manage Events</div>
                        <div class="text-muted small">View & update details</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>
            </div>
        </div>
        
        <!-- Club Community Stats -->
        <div class="card card-premium p-4 border-0 shadow-sm" style="background-color: var(--primary-navy); color: white;">
            <h5 class="fw-bold text-white mb-4"><i class="bi bi-stars text-warning me-2"></i>Community Engagement</h5>
            
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-eye me-2"></i>Event Page Views</span>
                <span class="fw-bold fs-5">320+</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-person-check me-2"></i>Avg. Turnout Rate</span>
                <span class="fw-bold fs-5">85%</span>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-white-50"><i class="bi bi-images me-2"></i>Gallery Photos</span>
                <span class="fw-bold fs-5">42</span>
            </div>
        </div>
    </div>
</div>
@endsection
