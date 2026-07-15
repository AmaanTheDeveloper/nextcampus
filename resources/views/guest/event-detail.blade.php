@extends('layouts.guest-bootstrap')

@section('title', $event->title . ' - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="p-5 bg-white rounded-4 border shadow-sm">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">{{ $event->type }}</span>
                    <h2 class="fw-bold text-navy mb-4">{{ $event->title }}</h2>

                    <div class="row g-3 py-3 my-3 border-top border-bottom">
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-clock me-1"></i>Date & Time</span>
                            <span class="fw-bold text-navy">{{ $event->event_date->format('M d, Y @ h:i A') }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-geo-alt me-1"></i>Location / Venue</span>
                            <span class="fw-bold text-navy">{{ $event->location }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-x me-1"></i>Registration Deadline</span>
                            <span class="fw-bold text-danger">{{ $event->registration_deadline->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold text-navy mb-3">Event Overview</h5>
                        <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                            {{ $event->description }}
                        </p>
                    </div>

                    <!-- Gallery Section -->
                    @if($event->gallery->isNotEmpty())
                        <div class="mt-5 pt-4 border-top">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-images text-primary me-2"></i>Event Gallery</h5>
                            <div class="row g-3">
                                @foreach($event->gallery as $image)
                                    <div class="col-md-4 col-6">
                                        <div class="overflow-hidden rounded-3 border" style="height: 150px;">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="w-100 h-100 object-fit-cover hover-zoom" alt="Event photo" style="transition: transform 0.3s ease;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration sidebar box -->
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-4 border shadow-sm sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-3">Reserve Your Spot</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyRegistered = \App\Models\EventRegistration::where('event_id', $event->id)
                                    ->where('student_id', auth()->id())
                                    ->exists();
                            @endphp

                            @if($alreadyRegistered)
                                <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>
                                        You are registered for this event!
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.event.register', $event->id) }}" method="POST">
                                    @csrf
                                    <p class="text-secondary small mb-3">Make sure your registration details are correct before submitting.</p>
                                    <button type="submit" class="btn btn-premium w-100 py-2.5">
                                        Register Now
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0" role="alert">
                                Only Student accounts can register for campus events.
                            </div>
                        @endif
                    @else
                        <p class="text-secondary small mb-4">Please log in to reserve your ticket for this event.</p>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('login') }}" class="btn btn-premium w-100 py-2.5">Login to Register</a>
                            <a href="{{ route('register') }}" class="btn btn-premium-outline w-100 py-2.5">Create an Account</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
