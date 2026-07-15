@extends('layouts.bootstrap')

@section('body')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-premium sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <span class="fs-4 fw-extrabold text-navy"><i class="bi bi-mortarboard-fill text-primary me-2"></i>Next<span class="text-primary">Campus</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active text-primary' : '' }}" href="{{ url('/') }}"><i class="bi bi-house-door me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('internships*') ? 'active text-primary' : '' }}" href="{{ route('guest.internships') }}"><i class="bi bi-briefcase me-1"></i>Internships</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('competitions*') ? 'active text-primary' : '' }}" href="{{ route('guest.competitions') }}"><i class="bi bi-trophy me-1"></i>Competitions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('scholarships*') ? 'active text-primary' : '' }}" href="{{ route('guest.scholarships') }}"><i class="bi bi-award me-1"></i>Scholarships</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('notes*') ? 'active text-primary' : '' }}" href="{{ route('guest.notes') }}"><i class="bi bi-file-earmark-pdf me-1"></i>Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('events*') ? 'active text-primary' : '' }}" href="{{ route('guest.events') }}"><i class="bi bi-calendar-event me-1"></i>Events</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-premium btn-sm"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-premium-outline btn-sm"><i class="bi bi-box-arrow-right"></i></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-premium-outline btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                        <a href="{{ route('register') }}" class="btn btn-premium btn-sm"><i class="bi bi-person-plus me-1"></i>Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container text-md-left">
            <div class="row text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary"><i class="bi bi-mortarboard-fill me-2"></i>NextCampus</h5>
                    <p class="text-secondary small">
                        One Platform for Learning, Opportunities & Student Growth. Simplify your academic journey and launch your career.
                    </p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Quick Links</h5>
                    <p><a href="{{ route('guest.internships') }}" class="text-secondary text-decoration-none small">Internships</a></p>
                    <p><a href="{{ route('guest.competitions') }}" class="text-secondary text-decoration-none small">Competitions</a></p>
                    <p><a href="{{ route('guest.scholarships') }}" class="text-secondary text-decoration-none small">Scholarships</a></p>
                    <p><a href="{{ route('guest.notes') }}" class="text-secondary text-decoration-none small">Study Notes</a></p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Support</h5>
                    <p><a href="{{ url('/') }}#faq" class="text-secondary text-decoration-none small">FAQs</a></p>
                    <p><a href="{{ url('/privacy-policy') }}" class="text-secondary text-decoration-none small">Privacy Policy</a></p>
                    <p><a href="{{ url('/terms-of-service') }}" class="text-secondary text-decoration-none small">Terms of Service</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Contact</h5>
                    <p class="small text-secondary"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Aptech ADSE Campus, Pakistan</p>
                    <p class="small text-secondary"><i class="bi bi-envelope-fill text-primary me-2"></i>info@nextcampus.com</p>
                    <p class="small text-secondary"><i class="bi bi-telephone-fill text-primary me-2"></i>+92 300 1234567</p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p class="small text-secondary">© {{ date('Y') }} NextCampus. All rights reserved.</p>
                </div>
                <div class="col-md-5 col-lg-4 text-end">
                    <ul class="list-unstyled list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-secondary"><i class="bi bi-facebook fs-5"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-secondary"><i class="bi bi-twitter-x fs-5"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-secondary"><i class="bi bi-linkedin fs-5"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection
