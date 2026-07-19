@extends('layouts.guest-bootstrap')

@section('title', $internship->title . ' - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guest.internships') }}" class="text-decoration-none text-secondary">Internships</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">{{ Str::limit($internship->title, 30) }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'C') }}&background=random" class="rounded-circle w-100 h-100" alt="Logo">
                </div>
                <div>
                    <h2 class="fw-bold text-navy mb-1">{{ $internship->title }}</h2>
                    <h6 class="text-secondary mb-0">{{ $internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'NextCampus Partner' }}</h6>
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
                                    <i class="bi bi-geo-alt fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Location</span>
                                    <span class="fw-semibold text-navy">{{ $internship->location }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Stipend/Salary</span>
                                    <span class="fw-semibold text-navy">{{ $internship->salary ?: 'Unpaid' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Apply Before</span>
                                    <span class="fw-semibold text-navy">{{ $internship->deadline->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-navy mb-3">Job Description</h5>
                    <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                        {{ $internship->description }}
                    </p>

                    @if($internship->requirements)
                        <h5 class="fw-bold text-navy mb-3 mt-5">Requirements</h5>
                        <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                            {{ $internship->requirements }}
                        </p>
                    @endif

                    @if($internship->skills)
                        <h5 class="fw-bold text-navy mb-3 mt-5">Skills Required</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $internship->skills) as $skill)
                                <span class="badge bg-light text-navy border px-3 py-2 fw-semibold rounded-pill">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Application Sidebar -->
            <div class="col-lg-4">
                <div class="card card-premium p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Application</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyApplied = \App\Models\InternshipApplication::where('internship_id', $internship->id)
                                    ->where('student_id', auth()->id())
                                    ->first();
                            @endphp

                            @if($alreadyApplied)
                                <div class="alert alert-success d-flex align-items-start border-0 shadow-sm" role="alert">
                                    <i class="bi bi-check-circle-fill me-3 fs-4 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Application Submitted</h6>
                                        <p class="mb-0 small">You have already applied for this position. <br>
                                        <span class="fw-bold mt-1 d-inline-block">Status: {{ ucfirst($alreadyApplied->status) }}</span></p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.internship.apply', $internship->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label text-secondary small fw-bold">Upload Resume (PDF)</label>
                                        <input type="file" name="resume" class="form-control form-control-lg" required accept="application/pdf">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-secondary small fw-bold">Cover Letter (Optional)</label>
                                        <textarea name="cover_letter" class="form-control" rows="4" placeholder="Briefly introduce yourself and why you're a great fit..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-premium btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-send-fill"></i> Submit Application
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0 border-0 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2 text-warning"></i>
                                Only accounts registered as <strong class="text-navy">Students</strong> can apply for internships.
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 60px; height: 60px;">
                                <i class="bi bi-lock-fill fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-navy">Login to Apply</h6>
                            <p class="text-secondary small mb-4">You must be logged in as a Student to apply for this internship.</p>
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
