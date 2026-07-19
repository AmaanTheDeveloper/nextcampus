@extends('layouts.guest-bootstrap')

@section('title', $event->title . ' - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guest.events') }}" class="text-decoration-none text-secondary">Events</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">{{ Str::limit($event->title, 30) }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <i class="bi bi-calendar-event-fill fs-2 text-danger"></i>
                </div>
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1 px-2 py-1 rounded-pill fw-semibold">{{ $event->type ?? 'Campus Event' }}</span>
                    <h2 class="fw-bold text-navy mb-0">{{ $event->title }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Overview Card -->
                <div class="card card-premium p-4 mb-4">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Event Overview</h5>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle text-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Date & Time</span>
                                    <span class="fw-semibold text-navy">{{ $event->event_date->format('M d, Y @ h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-info-subtle text-info rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-geo-alt fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Location / Venue</span>
                                    <span class="fw-semibold text-navy">{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-x fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Registration Deadline</span>
                                    <span class="fw-semibold text-navy">{{ $event->registration_deadline->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-navy mb-3 mt-4">Description</h5>
                    <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                        {{ $event->description }}
                    </p>

                    <!-- Gallery Section -->
                    @if($event->gallery && $event->gallery->isNotEmpty())
                        <div class="mt-5 pt-4 border-top">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-images text-primary me-2"></i>Event Gallery</h5>
                            <div class="row g-3">
                                @foreach($event->gallery as $image)
                                    <div class="col-md-4 col-6">
                                        <div class="overflow-hidden rounded-3 border" style="height: 150px;">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Event photo" style="transition: transform 0.3s ease;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration Sidebar -->
            <div class="col-lg-4">
                <div class="card card-premium p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Reserve Your Spot</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyRegistered = \App\Models\EventRegistration::where('event_id', $event->id)
                                    ->where('student_id', auth()->id())
                                    ->exists();
                            @endphp

                            @if($alreadyRegistered)
                                <div class="alert alert-success d-flex align-items-start border-0 shadow-sm" role="alert">
                                    <i class="bi bi-check-circle-fill me-3 fs-4 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Registration Confirmed</h6>
                                        <p class="mb-0 small">You are registered for this event. See you there!</p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.event.register', $event->id) }}" method="POST">
                                    @csrf
                                    <div class="bg-light p-3 rounded-3 mb-4">
                                        <p class="text-secondary small mb-0 fw-medium"><i class="bi bi-info-circle-fill text-primary me-2"></i>Make sure your registration details are correct before submitting.</p>
                                    </div>
                                    <button type="submit" class="btn btn-premium btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-ticket-perforated-fill"></i> Register Now
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0 border-0 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2 text-warning"></i>
                                Only <strong class="text-navy">Student</strong> accounts can register for campus events.
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 60px; height: 60px;">
                                <i class="bi bi-lock-fill fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-navy">Login to Register</h6>
                            <p class="text-secondary small mb-4">Please log in to reserve your ticket for this event.</p>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('login') }}" class="btn btn-premium w-100 py-2">Log In</a>
                                <a href="{{ route('register') }}" class="btn btn-premium-outline w-100 py-2">Create Account</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
