@extends('layouts.guest-bootstrap')

@section('title', $internship->title . ' - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Main Details Card -->
                <div class="p-5 bg-white rounded-4 border shadow-sm">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 me-4">
                            <i class="bi bi-briefcase fs-1"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold text-navy mb-1">{{ $internship->title }}</h2>
                            <h5 class="text-secondary">{{ $internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'N/A' }}</h5>
                        </div>
                    </div>

                    <div class="row g-3 py-3 my-3 border-top border-bottom">
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-geo-alt me-1"></i>Location</span>
                            <span class="fw-bold text-navy">{{ $internship->location }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-cash-stack me-1"></i>Stipend/Salary</span>
                            <span class="fw-bold text-navy">{{ $internship->salary ?: 'Unpaid' }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-check me-1"></i>Apply Before</span>
                            <span class="fw-bold text-danger">{{ $internship->deadline->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold text-navy mb-3">Job Description</h5>
                        <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                            {{ $internship->description }}
                        </p>
                    </div>

                    @if($internship->requirements)
                        <div class="mt-4">
                            <h5 class="fw-bold text-navy mb-3">Requirements</h5>
                            <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                                {{ $internship->requirements }}
                            </p>
                        </div>
                    @endif

                    @if($internship->skills)
                        <div class="mt-4">
                            <h5 class="fw-bold text-navy mb-3">Skills Required</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $internship->skills) as $skill)
                                    <span class="badge bg-light text-navy border px-3 py-2 fw-semibold">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Apply Sidebar Card -->
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-4 border shadow-sm sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-3">Application</h5>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyApplied = \App\Models\InternshipApplication::where('internship_id', $internship->id)
                                    ->where('student_id', auth()->id())
                                    ->first();
                            @endphp

                            @if($alreadyApplied)
                                <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>
                                        You have already applied! <br>
                                        <small class="fw-bold">Status: {{ ucfirst($alreadyApplied->status) }}</small>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('student.internship.apply', $internship->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-bold">Upload Resume (PDF)</label>
                                        <input type="file" name="resume" class="form-control" required accept="application/pdf">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-bold">Cover Letter (Optional)</label>
                                        <textarea name="cover_letter" class="form-control" rows="4" placeholder="Briefly introduce yourself and why you're a great fit..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-premium w-full py-2.5 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-send-fill"></i> Submit Application
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0" role="alert">
                                Only accounts registered as <strong class="text-navy">Students</strong> can apply for internships.
                            </div>
                        @endif
                    @else
                        <p class="text-secondary small mb-4">You must be logged in as a Student to apply for this internship.</p>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('login') }}" class="btn btn-premium w-100 py-2.5">Login to Apply</a>
                            <a href="{{ route('register') }}" class="btn btn-premium-outline w-100 py-2.5">Create an Account</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
