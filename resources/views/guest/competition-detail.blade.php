@extends('layouts.guest-bootstrap')

@section('title', $competition->title . ' - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guest.competitions') }}" class="text-decoration-none text-secondary">Competitions</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">{{ Str::limit($competition->title, 30) }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <i class="bi bi-trophy-fill fs-2 text-warning"></i>
                </div>
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1 px-2 py-1 rounded-pill fw-semibold">{{ $competition->category->name ?? 'Campus Contest' }}</span>
                    <h2 class="fw-bold text-navy mb-0">{{ $competition->title }}</h2>
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
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Overview</h5>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle text-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Starts On</span>
                                    <span class="fw-semibold text-navy">{{ $competition->start_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-info-subtle text-info rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-check fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Ends On</span>
                                    <span class="fw-semibold text-navy">{{ $competition->end_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-x fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Reg. Closes</span>
                                    <span class="fw-semibold text-navy">{{ $competition->registration_deadline->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-navy mb-3 mt-4">About the Competition</h5>
                    <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                        {{ $competition->description }}
                    </p>

                    @if($competition->rules)
                        <h5 class="fw-bold text-navy mb-3 mt-5"><i class="bi bi-journal-text text-primary me-2"></i>Rules & Guidelines</h5>
                        <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                            {{ $competition->rules }}
                        </p>
                    @endif

                    @if($competition->prizes)
                        <h5 class="fw-bold text-navy mb-3 mt-5"><i class="bi bi-gift text-primary me-2"></i>Prizes & Rewards</h5>
                        <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                            {{ $competition->prizes }}
                        </p>
                    @endif

                    @if($competition->winners)
                        <div class="mt-5 p-4 bg-success-subtle rounded-4 border border-success">
                            <h5 class="fw-bold text-success mb-2"><i class="bi bi-trophy-fill me-2"></i>Winners Announcement</h5>
                            <p class="text-secondary mb-0" style="white-space: pre-line;">
                                {{ $competition->winners }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration Sidebar -->
            <div class="col-lg-4">
                <div class="card card-premium p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Participation</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyRegistered = \App\Models\CompetitionRegistration::where('competition_id', $competition->id)
                                    ->where('student_id', auth()->id())
                                    ->first();
                            @endphp

                            @if($alreadyRegistered)
                                <div class="alert alert-success d-flex align-items-start border-0 shadow-sm" role="alert">
                                    <i class="bi bi-check-circle-fill me-3 fs-4 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Successfully Registered</h6>
                                        <p class="mb-0 small">You are registered for this competition. <br>
                                        <span class="fw-bold mt-1 d-inline-block">Status: {{ ucfirst($alreadyRegistered->status) }}</span></p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.competition.register', $competition->id) }}" method="POST">
                                    @csrf
                                    <div class="bg-light p-3 rounded-3 mb-4">
                                        <p class="text-secondary small mb-0 fw-medium"><i class="bi bi-info-circle-fill text-primary me-2"></i>By registering, you agree to follow the rules and guidelines of this competition.</p>
                                    </div>
                                    <button type="submit" class="btn btn-premium btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-person-plus-fill"></i> Register Now
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0 border-0 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2 text-warning"></i>
                                Only <strong class="text-navy">Student</strong> accounts can register for competitions.
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 60px; height: 60px;">
                                <i class="bi bi-lock-fill fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-navy">Login to Register</h6>
                            <p class="text-secondary small mb-4">Please log in to participate in this competition.</p>
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
