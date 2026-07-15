@extends('layouts.dashboard-layout')

@section('page-title', 'Club Leader Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-6">
        <div class="card p-4 card-premium border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">My Hosted Events</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $eventsCount }}</h3>
                </div>
                <div class="fs-2 text-primary"><i class="bi bi-calendar-event"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 card-premium border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Total Registrations</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $totalRegistrations }}</h3>
                </div>
                <div class="fs-2 text-success"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-calendar2-week text-primary me-2"></i>My Recent Events</h5>
        <a href="{{ route('club_leader.events.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-lg me-1"></i>Create Event</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEvents as $event)
                    <tr>
                        <td class="fw-bold text-navy">{{ $event->title }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $event->type }}</span></td>
                        <td>{{ $event->event_date->format('M d, Y @ h:i A') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('club_leader.events.registrations', $event->id) }}" class="btn btn-outline-info btn-sm" title="Registrations">
                                    <i class="bi bi-people"></i>
                                </a>
                                <a href="{{ route('club_leader.events.gallery', $event->id) }}" class="btn btn-outline-warning btn-sm" title="Gallery">
                                    <i class="bi bi-images"></i>
                                </a>
                                <a href="{{ route('club_leader.events.edit', $event->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">No events created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
