@extends('layouts.dashboard-layout')

@section('page-title', 'Event Registrations')

@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="bi bi-people text-primary me-2"></i>Event Registrations</h5>
            <p class="text-secondary small mb-0">Event: <strong>{{ $event->title }}</strong> &bull; Date: {{ $event->event_date->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('club_leader.events.index') }}" class="btn btn-premium-outline btn-sm"><i class="bi bi-arrow-left me-1"></i>Back to Events</a>
    </div>

    @if($registrations->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-secondary"><i class="bi bi-people"></i></div>
            <p class="text-secondary mt-2">No students registered for this event yet.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatables table-hover align-middle small">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold text-navy">{{ $reg->student->name }}</td>
                            <td>{{ $reg->student->email }}</td>
                            <td class="text-muted">{{ $reg->created_at->format('M d, Y @ h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
