@extends('layouts.guest-bootstrap')

@section('title', 'Campus Events - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-navy"><i class="bi bi-calendar-event text-primary me-2"></i>Campus Events</h1>
            <p class="text-secondary">Join dynamic workshops, interactive bootcamps, and career seminars.</p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <form action="{{ route('guest.events') }}" method="GET" class="d-flex shadow-sm rounded-3">
                    <input type="text" name="search" class="form-control border-end-0 rounded-start-3 py-3" placeholder="Search events..." value="{{ $search }}">
                    <button type="submit" class="btn btn-premium rounded-end-3 px-4"><i class="bi bi-search"></i> Search</button>
                </form>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-4">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-3">{{ $event->type }}</span>
                            <h5 class="fw-bold text-navy mb-2">{{ $event->title }}</h5>
                            <p class="text-secondary small line-clamp-3">{{ Str::limit($event->description, 130) }}</p>
                            
                            <div class="mt-3 bg-light p-2.5 rounded border small text-secondary">
                                <div class="mb-1"><i class="bi bi-calendar-check me-2"></i>Date: {{ $event->event_date->format('M d, Y @ h:i A') }}</div>
                                <div><i class="bi bi-geo-alt me-2"></i>Location: {{ $event->location }}</div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>Reg till: {{ $event->registration_deadline->format('M d, Y') }}</span>
                            <a href="{{ route('guest.event.detail', $event->id) }}" class="btn btn-premium btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="fs-1 text-secondary"><i class="bi bi-inbox"></i></div>
                    <p class="text-secondary mt-2">No upcoming campus events scheduled right now.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $events->appends(['search' => $search])->links() }}
        </div>
    </div>
@endsection
