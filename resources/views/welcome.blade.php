@extends('layouts.guest-bootstrap')

@section('title', 'NextCampus - One Platform for Learning, Opportunities & Student Growth')

@section('content')
    <!-- Hero Section -->
    <header class="bg-white py-5 border-bottom">
        <div class="container my-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 animate-fade-in-up">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">🚀 Discover Your Future</span>
                    <h1 class="display-4 fw-extrabold text-navy lh-sm mb-3">
                        Everything a Student Needs, <br>
                        <span class="text-primary">All in One Platform.</span>
                    </h1>
                    <p class="lead text-secondary mb-4">
                        Discover internships, register for hackathons, apply for scholarships, download class notes, construct professional resumes, and secure your academic certificates.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('guest.internships') }}" class="btn btn-premium btn-lg px-4 py-3"><i class="bi bi-compass-fill me-2"></i>Explore Opportunities</a>
                        <a href="{{ route('register') }}" class="btn btn-premium-outline btn-lg px-4 py-3"><i class="bi bi-rocket-takeoff-fill me-2"></i>Join Now</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="p-4 bg-light rounded-4 shadow-sm border">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <span class="fw-bold text-navy"><i class="bi bi-activity text-primary me-2"></i>Live Platform Statistics</span>
                            <span class="badge bg-success-subtle text-success"><i class="bi bi-circle-fill me-1 small"></i>Live</span>
                        </div>
                        <div class="row g-4 text-center">
                            <div class="col-6">
                                <div class="p-3 bg-white border rounded-3">
                                    <h3 class="fw-bold text-primary mb-1">{{ $stats['students'] }}+</h3>
                                    <span class="text-secondary small">Students Registered</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white border rounded-3">
                                    <h3 class="fw-bold text-primary mb-1">{{ $stats['internships'] }}+</h3>
                                    <span class="text-secondary small">Active Internships</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white border rounded-3">
                                    <h3 class="fw-bold text-primary mb-1">{{ $stats['notes'] }}+</h3>
                                    <span class="text-secondary small">Study Materials</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white border rounded-3">
                                    <h3 class="fw-bold text-primary mb-1">{{ $stats['competitions'] }}+</h3>
                                    <span class="text-secondary small">Competitions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Core Features Grid -->
    <section class="py-5 bg-light" id="features">
        <div class="container my-4">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small">What We Offer</span>
                <h2 class="fw-bold text-navy mt-1">Platform Modules & Features</h2>
                <p class="text-secondary">We unify scattered student services into a centralized professional workflow.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-briefcase"></i></div>
                        <h5 class="fw-bold text-navy">Internship Portal</h5>
                        <p class="text-secondary small mb-0">Apply to remote or local internships, track your application status, and kickstart your career.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-file-earmark-person"></i></div>
                        <h5 class="fw-bold text-navy">Resume Builder</h5>
                        <p class="text-secondary small mb-0">Build standard, recruiter-ready resumes dynamically and export them as clean PDF templates.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <h5 class="fw-bold text-navy">Class Notes Vault</h5>
                        <p class="text-secondary small mb-0">Browse and download semester-wise, subject-wise PDF study materials uploaded by verified faculty.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-award"></i></div>
                        <h5 class="fw-bold text-navy">Scholarships Listing</h5>
                        <p class="text-secondary small mb-0">Find government and institutional scholarships, check eligibility criteria, and bookmark listings.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-trophy"></i></div>
                        <h5 class="fw-bold text-navy">Competitions & Hackathons</h5>
                        <p class="text-secondary small mb-0">Register for campus and external hacking competitions, seminars, and quizzes to win prizes.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-calendar2-event"></i></div>
                        <h5 class="fw-bold text-navy">Events & Webinars</h5>
                        <p class="text-secondary small mb-0">Join academic workshops, guest lectures, bootcamps, and view photo galleries of previous events.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-bold text-navy">Certificate Vault</h5>
                        <p class="text-secondary small mb-0">Securely upload and catalog your co-curricular and academic achievement certificates for easy reference.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-premium p-4 h-100">
                        <div class="fs-2 text-primary mb-3"><i class="bi bi-chat-square-text"></i></div>
                        <h5 class="fw-bold text-navy">Discussion Forum</h5>
                        <p class="text-secondary small mb-0">Engage in collaborative academic queries, pose curriculum-related questions, and answers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Internships -->
    <section class="py-5">
        <div class="container my-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <span class="text-primary fw-bold text-uppercase small">Recent Roles</span>
                    <h3 class="fw-bold text-navy mt-1">Latest Internships</h3>
                </div>
                <a href="{{ route('guest.internships') }}" class="btn btn-premium-outline btn-sm">View All <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4">
                @forelse($latestInternships as $internship)
                    <div class="col-md-4">
                        <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                        <i class="bi bi-building fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-navy mb-0">{{ $internship->title }}</h5>
                                        <span class="text-secondary small">{{ $internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <p class="text-secondary small line-clamp-3">
                                    {{ Str::limit($internship->description, 130) }}
                                </p>
                                <div class="mb-3">
                                    <span class="badge bg-light text-secondary me-2"><i class="bi bi-geo-alt me-1"></i>{{ $internship->location }}</span>
                                    <span class="badge bg-light text-secondary"><i class="bi bi-cash me-1"></i>{{ $internship->salary ?: 'Unpaid' }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>Deadline: {{ $internship->deadline->format('M d, Y') }}</span>
                                <a href="{{ route('guest.internship.detail', $internship->id) }}" class="btn btn-premium btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="fs-1 text-secondary"><i class="bi bi-inbox"></i></div>
                        <p class="text-secondary mt-2">No active internship opportunities found right now.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Upcoming Competitions & Events -->
    <section class="py-5 bg-light">
        <div class="container my-4">
            <div class="row g-5">
                <!-- Competitions -->
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h4 class="fw-bold text-navy mb-0"><i class="bi bi-trophy text-primary me-2"></i>Upcoming Competitions</h4>
                        <a href="{{ route('guest.competitions') }}" class="btn btn-premium-outline btn-sm">All Competitions</a>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($latestCompetitions as $comp)
                            <div class="p-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold text-navy mb-1">{{ $comp->title }}</h6>
                                    <span class="text-danger small"><i class="bi bi-calendar-x me-1"></i>Register by: {{ $comp->registration_deadline->format('M d, Y') }}</span>
                                </div>
                                <a href="{{ route('guest.competition.detail', $comp->id) }}" class="btn btn-primary btn-sm">Register</a>
                            </div>
                        @empty
                            <p class="text-secondary small">No upcoming hackathons or coding challenges scheduled.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Events -->
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h4 class="fw-bold text-navy mb-0"><i class="bi bi-calendar-event text-primary me-2"></i>Upcoming Events</h4>
                        <a href="{{ route('guest.events') }}" class="btn btn-premium-outline btn-sm">All Events</a>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($latestEvents as $event)
                            <div class="p-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold text-navy mb-1">{{ $event->title }}</h6>
                                    <span class="text-secondary small"><i class="bi bi-calendar2-check me-1"></i>{{ $event->event_date->format('M d, Y @ h:i A') }}</span>
                                </div>
                                <a href="{{ route('guest.event.detail', $event->id) }}" class="btn btn-primary btn-sm">Details</a>
                            </div>
                        @empty
                            <p class="text-secondary small">No upcoming workshops or webinars scheduled.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Scholarships -->
    <section class="py-5">
        <div class="container my-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <span class="text-primary fw-bold text-uppercase small">Funding</span>
                    <h3 class="fw-bold text-navy mt-1">Latest Scholarships</h3>
                </div>
                <a href="{{ route('guest.scholarships') }}" class="btn btn-premium-outline btn-sm">View All Scholarships</a>
            </div>
            <div class="row g-4">
                @forelse($latestScholarships as $scholarship)
                    <div class="col-md-4">
                        <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-navy mb-2">{{ $scholarship->title }}</h5>
                                <p class="text-secondary small">{{ Str::limit($scholarship->description, 130) }}</p>
                                <div class="mb-3">
                                    <span class="badge bg-primary-subtle text-primary"><i class="bi bi-cash-stack me-1"></i>Amount: {{ $scholarship->amount ?: 'Varies' }}</span>
                                </div>
                            </div>
                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>{{ $scholarship->deadline->format('M d, Y') }}</span>
                                <a href="{{ route('guest.scholarship.detail', $scholarship->id) }}" class="btn btn-premium btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-secondary small">No active scholarships listed at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container my-4">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small">Success Stories</span>
                <h3 class="fw-bold text-navy mt-1">What Students Say About NextCampus</h3>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 border h-100">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="text-secondary small mb-3">"I constructed my professional resume using the NextCampus Resume Builder and applied for an internship posted by an IT company here. Within two weeks, I was shortlisted and hired!"</p>
                        <h6 class="fw-bold text-navy mb-0">Hassan Raza</h6>
                        <span class="text-muted small">Computer Science Student</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 border h-100">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="text-secondary small mb-3">"The notes portal is incredibly helpful. I no longer have to request resources on WhatsApp groups. I can find semester-wise study materials cataloged by our professors directly here."</p>
                        <h6 class="fw-bold text-navy mb-0">Aisha Khan</h6>
                        <span class="text-muted small">Software Engineering Student</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 border h-100">
                        <div class="text-warning mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="text-secondary small mb-3">"Our university club organized a bootcamp and handled registrations through NextCampus. It saved us massive spreadsheet headaches, and our students loved it."</p>
                        <h6 class="fw-bold text-navy mb-0">Bilal Siddiqui</h6>
                        <span class="text-muted small">Club Leader</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="py-5" id="faq">
        <div class="container my-4">
            <div class="text-center mb-5">
                <h3 class="fw-bold text-navy">Frequently Asked Questions</h3>
                <p class="text-secondary">Clear answers to help you navigate our campus opportunities platform.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How do Teachers & Companies get verified?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary small">
                                    When a Teacher or Company registers on NextCampus, their account status is set to 'Pending' by default. The site administrator reviews their profiles and updates their status to 'Active'. They will receive access to their respective posting dashboards once approved.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can Guest users apply for internships or download study materials?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary small">
                                    Guest users can browse internships, competitions, events, scholarships, and preview notes. However, to apply for jobs, register for contests, upload/download notes, or save bookmark listings, they must register for a Student account.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What is the Certificate Vault?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary small">
                                    The Certificate Vault is a secure digital file locker for students to upload, organize, and download their academic degree files, co-curricular awards, and professional credentials, ensuring they are always stored securely and accessible in one place.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
