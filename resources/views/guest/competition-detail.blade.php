@extends('layouts.guest-bootstrap')

@section('title', $competition->title . ' - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="p-5 bg-white rounded-4 border shadow-sm">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">{{ $competition->category->name ?? 'Campus Contest' }}</span>
                    <h2 class="fw-bold text-navy mb-4">{{ $competition->title }}</h2>

                    <div class="row g-3 py-3 my-3 border-top border-bottom">
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-event me-1"></i>Starts On</span>
                            <span class="fw-bold text-navy">{{ $competition->start_date->format('M d, Y') }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-check me-1"></i>Ends On</span>
                            <span class="fw-bold text-navy">{{ $competition->end_date->format('M d, Y') }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-x me-1"></i>Registration Closes</span>
                            <span class="fw-bold text-danger">{{ $competition->registration_deadline->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold text-navy mb-3">About the Competition</h5>
                        <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                            {{ $competition->description }}
                        </p>
                    </div>

                    @if($competition->rules)
                        <div class="mt-4">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-journal-text text-primary me-2"></i>Rules & Guidelines</h5>
                            <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                                {{ $competition->rules }}
                            </p>
                        </div>
                    @endif

                    @if($competition->prizes)
                        <div class="mt-4">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-gift text-primary me-2"></i>Prizes & Rewards</h5>
                            <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                                {{ $competition->prizes }}
                            </p>
                        </div>
                    @endif

                    @if($competition->winners)
                        <div class="mt-4 p-4 bg-success-subtle rounded-3 border border-success">
                            <h5 class="fw-bold text-success mb-2"><i class="bi bi-trophy-fill me-2"></i>Winners Announcement</h5>
                            <p class="text-secondary mb-0" style="white-space: pre-line;">
                                {{ $competition->winners }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration Box -->
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-4 border shadow-sm sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-3">Participation</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyRegistered = \App\Models\CompetitionRegistration::where('competition_id', $competition->id)
                                    ->where('student_id', auth()->id())
                                    ->first();
                            @endphp

                            @if($alreadyRegistered)
                                <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>
                                        You are registered! <br>
                                        <small class="fw-bold">Status: {{ ucfirst($alreadyRegistered->status) }}</small>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.competition.register', $competition->id) }}" method="POST">
                                    @csrf
                                    <p class="text-secondary small mb-3">By registering, you agree to follow the rules and guidelines of this competition.</p>
                                    <button type="submit" class="btn btn-premium w-100 py-2.5">
                                        Register for Competition
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0" role="alert">
                                Only Student accounts can register for competitions.
                            </div>
                        @endif
                    @else
                        <p class="text-secondary small mb-4">Please log in to register for this competition.</p>
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
