@extends('layouts.guest-bootstrap')

@section('title', 'Campus Events - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4 mb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">Events</li>
                </ol>
            </nav>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-calendar-event fs-2 text-danger"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-navy mb-1">Campus Events</h2>
                        <p class="text-secondary mb-0">Join dynamic workshops, interactive bootcamps, and career seminars.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card card-premium p-3">
                    <form action="{{ route('guest.events') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 py-2 ps-0" placeholder="Search upcoming events..." value="{{ $search }}">
                            <button type="submit" class="btn btn-premium px-4">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-4">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-danger-subtle text-danger fw-semibold px-2 py-1 mb-3"><i class="bi bi-calendar-week-fill me-1"></i>{{ $event->type }}</span>
                            <h5 class="fw-bold text-navy mb-2">{{ Str::limit($event->title, 50) }}</h5>
                            <p class="text-secondary small line-clamp-3 mb-3" style="line-height: 1.6;">
                                {{ Str::limit($event->description, 130) }}
                            </p>
                            
                            <div class="bg-light p-3 rounded-3 border-light small text-secondary">
                                <div class="mb-2 d-flex align-items-center gap-2"><i class="bi bi-clock text-primary"></i> <span class="fw-medium text-navy">{{ $event->event_date->format('M d, Y @ h:i A') }}</span></div>
                                <div class="d-flex align-items-center gap-2"><i class="bi bi-geo-alt text-primary"></i> <span class="fw-medium text-navy">{{ Str::limit($event->location, 25) }}</span></div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>Reg till: {{ $event->registration_deadline->format('M d') }}</span>
                            <a href="{{ route('guest.event.detail', $event->id) }}" class="btn btn-premium-outline btn-sm rounded-pill px-3">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 my-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 80px; height: 80px;">
                        <i class="bi bi-calendar-event fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">No Upcoming Events</h5>
                    <p class="text-secondary">No upcoming campus events scheduled right now. Check back later!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5 pt-3 border-top">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
