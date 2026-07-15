@extends('layouts.guest-bootstrap')

@section('title', $scholarship->title . ' - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="p-5 bg-white rounded-4 border shadow-sm">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">{{ $scholarship->category->name ?? 'Scholarship' }}</span>
                    <h2 class="fw-bold text-navy mb-4">{{ $scholarship->title }}</h2>

                    <div class="row g-3 py-3 my-3 border-top border-bottom">
                        <div class="col-md-6">
                            <span class="text-secondary small d-block"><i class="bi bi-cash-stack me-1"></i>Award Amount</span>
                            <span class="fw-bold text-navy fs-5">{{ $scholarship->amount ?: 'Varies / Fully Funded' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-secondary small d-block"><i class="bi bi-calendar-x me-1"></i>Application Deadline</span>
                            <span class="fw-bold text-danger fs-5">{{ $scholarship->deadline->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold text-navy mb-3">Description</h5>
                        <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                            {{ $scholarship->description }}
                        </p>
                    </div>

                    @if($scholarship->eligibility)
                        <div class="mt-4">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-person-check text-primary me-2"></i>Eligibility Criteria</h5>
                            <p class="text-secondary" style="line-height: 1.7; white-space: pre-line;">
                                {{ $scholarship->eligibility }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Box -->
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-4 border shadow-sm sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-navy mb-3">Apply & Save</h5>
                    
                    <a href="{{ $scholarship->official_apply_link }}" target="_blank" class="btn btn-premium w-100 py-2.5 mb-3 d-flex align-items-center justify-content-center gap-2">
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
                                    <button type="submit" class="btn btn-danger w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-bookmark-dash-fill"></i> Remove Bookmark
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('student.scholarship.bookmark', $scholarship->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-premium-outline w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-bookmark-plus-fill"></i> Bookmark Scholarship
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning text-center small mb-0" role="alert">
                                Only Student accounts can bookmark scholarships.
                            </div>
                        @endif
                    @else
                        <p class="text-secondary small mb-4">Log in to bookmark scholarships to your student dashboard.</p>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('login') }}" class="btn btn-premium-outline w-100 py-2.5">Login to Bookmark</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
