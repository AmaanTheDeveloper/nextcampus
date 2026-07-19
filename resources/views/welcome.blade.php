@extends('layouts.guest-bootstrap')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* Custom Design System for Homepage */
    :root {
        --primary-color: #4F46E5;
        --secondary-color: #6366F1;
        --dark-navy: #0F172A;
        --light-bg: #F8FAFC;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--light-bg);
    }

    /* Navbar */
    .navbar {
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .navbar.scrolled {
        background-color: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .nav-link {
        font-weight: 500;
        color: var(--dark-navy) !important;
        position: relative;
        padding-bottom: 0.25rem;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--primary-color);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Hero Section */
    .hero-section {
        padding: 120px 0 80px;
        background: linear-gradient(135deg, #F8FAFC 0%, #EEF2FF 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
    }

    .shape-1 {
        width: 400px;
        height: 400px;
        background: rgba(79, 70, 229, 0.2);
        top: -100px;
        right: -100px;
    }

    .shape-2 {
        width: 300px;
        height: 300px;
        background: rgba(99, 102, 241, 0.2);
        bottom: -50px;
        left: -50px;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    /* Cards */
    .premium-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    /* Buttons */
    .btn-premium {
        background-color: var(--primary-color);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.4);
    }

    .btn-premium:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.5);
        color: white;
    }

    .btn-outline-premium {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-outline-premium:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Statistics */
    .stat-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Floating Back to top */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--dark-navy);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
    }
    .back-to-top:hover {
        color: white;
        background: var(--primary-color);
        transform: translateY(-5px);
    }

    /* Accordion */
    .accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.05);
        color: var(--primary-color);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="shape-1 hero-shape"></div>
        <div class="shape-2 hero-shape"></div>
        <div class="container hero-content">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                    <span class="badge bg-white text-primary border border-primary px-3 py-2 rounded-pill mb-4 fw-bold shadow-sm">
                        <i class="bi bi-stars me-1"></i> The Premier University Ecosystem
                    </span>
                    <h1 class="display-3 fw-extrabold text-navy lh-sm mb-4" style="letter-spacing: -1px;">
                        Accelerate Your <br>
                        <span class="text-primary">Career Journey.</span>
                    </h1>
                    <p class="lead text-secondary mb-5 pe-lg-5 fs-5">
                        NextCampus is the enterprise platform connecting ambitious students with top-tier companies, exclusive scholarships, hackathons, and a world-class academic vault.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn btn-premium btn-lg px-5 py-3 fs-6">Explore Opportunities</a>
                        <a href="#stats" class="btn btn-outline-premium btn-lg px-5 py-3 fs-6 d-flex align-items-center">
                            <i class="bi bi-play-circle-fill me-2 fs-5"></i> Watch Demo
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="position-relative">
                        <!-- Abstract Dashboard UI Representation -->
                        <div class="bg-white p-2 rounded-4 shadow-lg border border-light position-relative z-index-1">
                            <div class="bg-light rounded-3 p-4 h-100 border">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Platform Overview</h5>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2"><i class="bi bi-circle-fill small me-2"></i>Live</span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm text-center border-start border-primary border-4">
                                            <i class="bi bi-briefcase fs-3 text-primary mb-2"></i>
                                            <h4 class="fw-bold mb-0">{{ $stats['internships'] }}+</h4>
                                            <span class="text-secondary small">Internships</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm text-center border-start border-warning border-4">
                                            <i class="bi bi-trophy fs-3 text-warning mb-2"></i>
                                            <h4 class="fw-bold mb-0">{{ $stats['competitions'] }}+</h4>
                                            <span class="text-secondary small">Competitions</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm text-center border-start border-success border-4">
                                            <i class="bi bi-journal-check fs-3 text-success mb-2"></i>
                                            <h4 class="fw-bold mb-0">{{ $stats['certificates'] }}+</h4>
                                            <span class="text-secondary small">Certificates</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm text-center border-start border-danger border-4">
                                            <i class="bi bi-mortarboard fs-3 text-danger mb-2"></i>
                                            <h4 class="fw-bold mb-0">{{ $stats['scholarships'] }}+</h4>
                                            <span class="text-secondary small">Scholarships</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Badges -->
                        <div class="position-absolute bg-white rounded-pill shadow px-4 py-3 d-flex align-items-center gap-3" style="top: 10%; right: -20px; z-index: 2; animation: float 3s ease-in-out infinite;">
                            <img src="https://ui-avatars.com/api/?name=Stripe&background=random&color=fff" class="rounded-circle" width="32" alt="Company">
                            <div>
                                <p class="mb-0 fw-bold small">Stripe hiring Interns</p>
                                <span class="text-success small">Just now</span>
                            </div>
                        </div>
                        
                        <div class="position-absolute bg-white rounded-pill shadow px-4 py-3 d-flex align-items-center gap-3" style="bottom: 10%; left: -30px; z-index: 2; animation: float 4s ease-in-out infinite reverse;">
                            <div class="bg-primary-subtle text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold small">Hackathon Won!</p>
                                <span class="text-secondary small">2 mins ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Statistics -->
    <section class="py-5 bg-white border-bottom" id="stats">
        <div class="container py-4">
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="text-center">
                        <h2 class="stat-number mb-2 counter" data-target="{{ $stats['students'] }}">0</h2>
                        <p class="text-secondary fw-medium mb-0">Active Students</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <h2 class="stat-number mb-2 counter" data-target="{{ $stats['companies'] }}">0</h2>
                        <p class="text-secondary fw-medium mb-0">Partner Companies</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <h2 class="stat-number mb-2 counter" data-target="{{ $stats['teachers'] }}">0</h2>
                        <p class="text-secondary fw-medium mb-0">Verified Faculty</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <h2 class="stat-number mb-2 counter" data-target="{{ $stats['events'] }}">0</h2>
                        <p class="text-secondary fw-medium mb-0">Campus Events</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Internships -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div data-aos="fade-right">
                    <span class="text-primary fw-bold tracking-wide text-uppercase small">Careers</span>
                    <h2 class="fw-bold text-navy mt-2 mb-0">Featured Internships</h2>
                    <p class="text-secondary mt-2 mb-0">Launch your career with top tech companies.</p>
                </div>
                <a href="{{ route('guest.internships') }}" class="btn btn-outline-secondary d-none d-md-inline-block" data-aos="fade-left">View All <i class="bi bi-arrow-right"></i></a>
            </div>
            
            <div class="row g-4">
                @forelse($latestInternships as $internship)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="premium-card p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($internship->company?->companyProfile?->company_name ?? 'C') }}&background=random" class="rounded-3" width="48" alt="Logo">
                                <span class="badge bg-light text-dark border"><i class="bi bi-briefcase me-1"></i>Internship</span>
                            </div>
                            <h5 class="fw-bold text-navy mb-1">{{ $internship->title }}</h5>
                            <p class="text-secondary small mb-3">{{ $internship->company?->companyProfile?->company_name ?? 'Unknown Company' }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-light text-secondary"><i class="bi bi-geo-alt me-1"></i>{{ $internship->location }}</span>
                                    <span class="badge bg-light text-secondary"><i class="bi bi-cash me-1"></i>Stipend</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>{{ $internship->deadline->diffForHumans() }}</span>
                                    <a href="{{ route('guest.internship.detail', $internship->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">Apply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-secondary">No internships available at the moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4 d-md-none">
                 <a href="{{ route('guest.internships') }}" class="btn btn-outline-secondary w-100">View All</a>
            </div>
        </div>
    </section>

    <!-- Features Section (AI, Resume, Portfolio) -->
    <section class="py-5 bg-dark text-white position-relative overflow-hidden my-5">
        <div class="position-absolute w-100 h-100 top-0 start-0 opacity-25" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 32px 32px;"></div>
        <div class="container py-5 position-relative z-index-1">
            <div class="row text-center mb-5" data-aos="fade-up">
                <div class="col-lg-8 mx-auto">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Enterprise Tools</span>
                    <h2 class="display-5 fw-bold mb-3">Build Your Professional Identity</h2>
                    <p class="lead text-light opacity-75">NextCampus provides integrated AI tools and builders to ensure your portfolio and resume stand out in a competitive market.</p>
                </div>
            </div>
            
            <div class="row g-5 align-items-center">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-light border-opacity-25 h-100">
                        <div class="card-icon-wrapper bg-white bg-opacity-25 text-white mb-4">
                            <i class="bi bi-magic"></i>
                        </div>
                        <h4 class="fw-bold mb-3">AI Assistant</h4>
                        <ul class="list-unstyled text-light opacity-75 d-flex flex-column gap-3 mb-0">
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i> ATS Resume Analysis</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Skill Gap Identification</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Interview Practice</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Personalized Career Roadmap</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-light border-opacity-25 h-100 shadow-lg" style="transform: scale(1.05); z-index:2; position:relative; background: linear-gradient(145deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));">
                        <div class="card-icon-wrapper bg-primary text-white mb-4">
                            <i class="bi bi-file-earmark-person-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Resume Builder</h4>
                        <p class="text-light opacity-75 mb-4">Generate ATS-friendly professional resumes using modern templates. Export to PDF with one click.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100">Build Resume Free</a>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-light border-opacity-25 h-100">
                        <div class="card-icon-wrapper bg-white bg-opacity-25 text-white mb-4">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Portfolio Builder</h4>
                        <p class="text-light opacity-75 mb-0">Automatically aggregate your projects, certificates, GitHub stats, and hackathon victories into a public portfolio page.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events & Competitions Split -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div>
                            <h3 class="fw-bold text-navy mb-0">Upcoming Events</h3>
                        </div>
                        <a href="{{ route('guest.events') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        @foreach($latestEvents as $event)
                        <div class="premium-card p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle text-primary rounded-3 p-3 text-center" style="min-width: 70px;">
                                    <span class="d-block fw-bold fs-5 lh-1">{{ $event->event_date->format('d') }}</span>
                                    <span class="d-block small text-uppercase fw-semibold">{{ $event->event_date->format('M') }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-navy mb-1">{{ $event->title }}</h6>
                                    <p class="text-secondary small mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('guest.event.detail', $event->id) }}" class="btn btn-sm btn-light border rounded-circle"><i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div>
                            <h3 class="fw-bold text-navy mb-0">Hackathons & Challenges</h3>
                        </div>
                        <a href="{{ route('guest.competitions') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                    </div>
                    
                    <div class="row g-3">
                        @foreach($latestCompetitions as $comp)
                        <div class="col-12">
                            <div class="premium-card p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-bold text-navy mb-0">{{ $comp->title }}</h5>
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                </div>
                                <p class="text-secondary small mb-3">{{ Str::limit($comp->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="text-danger small fw-semibold"><i class="bi bi-clock-history me-1"></i>Reg Closes: {{ $comp->registration_deadline->format('M d') }}</div>
                                    <a href="{{ route('guest.competition.detail', $comp->id) }}" class="btn btn-sm btn-primary">Join Challenge</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Study Notes & Scholarships -->
    <section class="py-5 bg-light my-5">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="mb-4">
                        <span class="text-primary fw-bold text-uppercase small">Academics</span>
                        <h3 class="fw-bold text-navy mt-1 mb-0">Trending Study Notes</h3>
                    </div>
                    <div class="row g-3">
                        @foreach($latestNotes as $note)
                        <div class="col-sm-6">
                            <div class="premium-card p-4 h-100">
                                <div class="card-icon-wrapper bg-danger-subtle text-danger mb-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>
                                <h6 class="fw-bold text-navy">{{ $note->subject }}</h6>
                                <p class="text-secondary small mb-3">{{ $note->semester }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="text-muted small"><i class="bi bi-download me-1"></i>{{ $note->downloads_count }}</span>
                                    <a href="#" class="btn btn-sm btn-light border">Preview</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-4">
                        <span class="text-primary fw-bold text-uppercase small">Funding</span>
                        <h3 class="fw-bold text-navy mt-1 mb-0">Latest Scholarships</h3>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @foreach($latestScholarships as $scholarship)
                        <div class="premium-card p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-navy mb-0">{{ $scholarship->title }}</h5>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="bi bi-cash me-1"></i>Funded</span>
                            </div>
                            <p class="text-secondary small mb-3">Institutional / Government</p>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="text-danger small fw-semibold"><i class="bi bi-calendar-x me-1"></i>Deadline: {{ $scholarship->deadline->format('M d, Y') }}</span>
                                <a href="{{ route('guest.scholarship.detail', $scholarship->id) }}" class="btn btn-sm btn-primary">Details</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Companies -->
    <section class="py-5 my-5">
        <div class="container text-center">
            <span class="text-primary fw-bold text-uppercase small">Partners</span>
            <h2 class="fw-bold text-navy mt-2 mb-5">Hiring Top Talent on NextCampus</h2>
            
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 align-items-center justify-content-center opacity-75" data-aos="fade-up">
                @foreach($featuredCompanies as $company)
                    <div class="col">
                        <div class="p-3 grayscale hover-color transition-all">
                            <h5 class="fw-bold text-secondary mb-0">{{ $company->companyProfile?->company_name ?? $company->name }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel -->
    <section class="py-5 bg-dark text-white my-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Success Stories</span>
                    <h2 class="display-6 fw-bold mb-4">Trusted by Ambitious Students.</h2>
                    <p class="lead text-light opacity-75 mb-4">See how NextCampus is helping students secure internships, win hackathons, and build their professional identity.</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light rounded-circle" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev"><i class="bi bi-arrow-left"></i></button>
                        <button class="btn btn-outline-light rounded-circle" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next"><i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
                <div class="col-lg-8" data-aos="fade-left">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="bg-white bg-opacity-10 p-5 rounded-4 border border-light border-opacity-25">
                                    <div class="text-warning mb-4 fs-5">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                    <h4 class="fw-light lh-base mb-4 fst-italic">"The Resume Builder and ATS Analyzer completely changed my job hunt. I applied for an internship via NextCampus and got hired at a top tech firm within two weeks!"</h4>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=Ali+Hassan&background=4F46E5&color=fff" class="rounded-circle" width="50" alt="Avatar">
                                        <div>
                                            <h6 class="fw-bold mb-0">Ali Hassan</h6>
                                            <span class="text-light opacity-75 small">Software Engineering Student</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="bg-white bg-opacity-10 p-5 rounded-4 border border-light border-opacity-25">
                                    <div class="text-warning mb-4 fs-5">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                    <h4 class="fw-light lh-base mb-4 fst-italic">"Having all verified notes from my professors in one vault saves me hours during exam season. No more begging for PDFs in WhatsApp groups."</h4>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=Sara+Ahmed&background=10B981&color=fff" class="rounded-circle" width="50" alt="Avatar">
                                        <div>
                                            <h6 class="fw-bold mb-0">Sara Ahmed</h6>
                                            <span class="text-light opacity-75 small">Data Science Student</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5" data-aos="fade-up">
                    <span class="text-primary fw-bold text-uppercase small">Support</span>
                    <h2 class="fw-bold text-navy mt-2">Frequently Asked Questions</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="accordion accordion-flush bg-white rounded-4 border shadow-sm" id="faqAccordion">
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-bold py-4 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Is NextCampus completely free for students?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary pb-4">
                                    Yes! Core features including the Resume Builder, Internship Applications, Note Downloads, and Event Registrations are 100% free for verified students.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-bold py-4 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    How do Companies post internships?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary pb-4">
                                    Companies can register for an employer account. Once vetted and approved by our administrators, they gain access to a dashboard to post opportunities, review ATS-scored resumes, and hire candidates.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed fw-bold py-4 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    Can I upload my own class notes?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary pb-4">
                                    Yes, students and verified faculty can upload notes. However, to maintain high academic standards, all community-uploaded materials undergo a review process before being published to the Vault.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action / Newsletter -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="bg-primary text-white rounded-4 p-5 position-relative overflow-hidden shadow-lg" data-aos="zoom-in">
                <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, #fff 1px, transparent 0); background-size: 24px 24px;"></div>
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-lg-7 mb-4 mb-lg-0 text-center text-lg-start">
                        <h2 class="fw-bold mb-3">Ready to upgrade your student experience?</h2>
                        <p class="lead opacity-75 mb-0">Join thousands of students building their careers on NextCampus today.</p>
                    </div>
                    <div class="col-lg-5 text-center text-lg-end">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-bold px-5 py-3 shadow">Create Free Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->

    <!-- Back to top button -->
    <a href="#" class="back-to-top" id="backToTop"><i class="bi bi-arrow-up fs-5"></i></a>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animations
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-in-out-cubic',
        });

        // Navbar Scroll Effect
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Back to top button
        const backToTopBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200; 

        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.getAttribute('data-target');
                const data = +counter.innerText;
                const time = value / speed;
                if(data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = value;
                }
            }
            // Trigger counter on scroll using IntersectionObserver
            const observer = new IntersectionObserver((entries) => {
                if(entries[0].isIntersecting) {
                    animate();
                    observer.disconnect();
                }
            });
            observer.observe(counter);
        });
    });
</script>
<style>
    .hover-primary:hover { color: var(--primary-color) !important; }
    .grayscale { filter: grayscale(100%); opacity: 0.6; }
    .hover-color:hover { filter: grayscale(0%); opacity: 1; }
    .transition-all { transition: all 0.3s ease; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush
