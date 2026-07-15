@extends('layouts.dashboard-layout')

@section('page-title', 'Manage Events')

@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-calendar-event text-primary me-2"></i>My Events</h5>
        <a href="{{ route('club_leader.events.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-lg me-1"></i>Create Event</a>
    </div>

    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $event->title }}</td>
                        <td><span class="badge bg-primary">{{ $event->type }}</span></td>
                        <td>{{ $event->event_date->format('M d, Y @ h:i A') }}</td>
                        <td>{{ $event->location }}</td>
                        <td class="text-danger">{{ $event->registration_deadline->format('M d, Y') }}</td>
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
                                <form action="{{ route('club_leader.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-secondary py-4">No events found. Create your first event today!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
