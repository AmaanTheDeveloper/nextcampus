@extends('layouts.guest-bootstrap')

@section('title', $scholarship->title . ' - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guest.scholarships') }}" class="text-decoration-none text-secondary">Scholarships</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">{{ Str::limit($scholarship->title, 30) }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <i class="bi bi-award-fill fs-2 text-primary"></i>
                </div>
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1 px-2 py-1 rounded-pill fw-semibold">{{ $scholarship->category->name ?? 'Scholarship' }}</span>
                    <h2 class="fw-bold text-navy mb-0">{{ $scholarship->title }}</h2>
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
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Award Amount</span>
                                    <span class="fw-semibold text-navy">{{ $scholarship->amount ?: 'Varies / Fully Funded' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded-circle p-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-x fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-secondary small mb-1">Application Deadline</span>
                                    <span class="fw-semibold text-navy">{{ $scholarship->deadline->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-navy mb-3 mt-4">Description</h5>
                    <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                        {{ $scholarship->description }}
                    </p>

                    @if($scholarship->eligibility)
                        <h5 class="fw-bold text-navy mb-3 mt-5"><i class="bi bi-person-check text-primary me-2"></i>Eligibility Criteria</h5>
                        <p class="text-secondary" style="line-height: 1.8; white-space: pre-line;">
                            {{ $scholarship->eligibility }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Action Sidebar -->
            <div class="col-lg-4">
                <div class="card card-premium p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Apply & Save</h5>
                    
                    <a href="{{ $scholarship->official_apply_link }}" target="_blank" class="btn btn-premium btn-lg w-100 mb-4 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-up-right"></i> Visit Official Site
                    </a>

                    @auth
                        @if(auth()->user()->role === 'student')
                            @php
                                $alreadyBookmarked = \App\Models\ScholarshipBookmark::where('scholarship_id', $scholarship->id)
                                    ->where('student_id', auth()->id())
                                    ->exists();
                            @endphp

                            @if($alreadyBookmarked)
                                <form action="{{ route('student.scholarship.unbookmark', $scholarship->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                                        <i class="bi bi-bookmark-dash-fill"></i> Remove Bookmark
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('student.scholarship.bookmark', $scholarship->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-premium-outline w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                                        <i class="bi bi-bookmark-plus"></i> Bookmark Scholarship
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0 border-0 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2 text-warning"></i>
                                Only <strong class="text-navy">Student</strong> accounts can bookmark scholarships.
                            </div>
                        @endif
                    @else
                        <div class="text-center mt-2">
                            <h6 class="fw-bold text-navy">Save for Later</h6>
                            <p class="text-secondary small mb-3">Log in to bookmark this scholarship to your dashboard.</p>
                            <a href="{{ route('login') }}" class="btn btn-premium-outline w-100 py-2">Log In to Bookmark</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
