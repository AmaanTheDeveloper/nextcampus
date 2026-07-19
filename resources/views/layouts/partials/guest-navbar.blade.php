<nav class="navbar navbar-expand-lg sticky-top navbar-premium transition-all" id="mainNav" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease;">
    <div class="container-fluid px-4 px-lg-5">
        
        <!-- Logo (Far Left) -->
        <a class="navbar-brand fw-bold fs-4 text-navy d-flex align-items-center me-lg-4" href="{{ url('/') }}">
            <div class="bg-primary text-white rounded p-1 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-mortarboard-fill fs-5"></i>
            </div>
            NextCampus
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <i class="bi bi-list fs-2 text-navy"></i>
        </button>

        <!-- Desktop Menu -->
        <div class="collapse navbar-collapse d-none d-lg-flex" id="desktopNavbar">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2" style="font-size: 0.95rem;">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('/') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="{{ url('/') }}">Home</a>
                </li>
                
                <!-- Opportunities Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 py-2 rounded-3 {{ Request::is('guest/internships*') || Request::is('guest/scholarships*') || Request::is('guest/competitions*') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="#" id="opportunitiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opportunities
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm mt-2" aria-labelledby="opportunitiesDropdown" style="border-radius: 12px; min-width: 220px;">
                        <li><a class="dropdown-item py-2 {{ Request::is('guest/internships*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ route('guest.internships') }}"><i class="bi bi-briefcase me-2"></i>Internships</a></li>
                        <li><a class="dropdown-item py-2 {{ Request::is('guest/scholarships*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ route('guest.scholarships') }}"><i class="bi bi-cash-stack me-2"></i>Scholarships</a></li>
                        <li><a class="dropdown-item py-2 {{ Request::is('guest/competitions*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ route('guest.competitions') }}"><i class="bi bi-trophy me-2"></i>Competitions</a></li>
                    </ul>
                </li>

                <!-- Resources Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 py-2 rounded-3 {{ Request::is('guest/notes*') || Request::is('student/forum*') || Request::is('guest/events*') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="#" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Resources
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm mt-2" aria-labelledby="resourcesDropdown" style="border-radius: 12px; min-width: 220px;">
                        <li><a class="dropdown-item py-2 {{ Request::is('guest/notes*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ route('guest.notes') }}"><i class="bi bi-journal-text me-2"></i>Notes</a></li>
                        <li><a class="dropdown-item py-2 {{ Request::is('student/forum*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ url('/student/forum') }}"><i class="bi bi-chat-square-text me-2"></i>Discussion Forum</a></li>
                        <li><a class="dropdown-item py-2 {{ Request::is('guest/events*') ? 'text-primary fw-bold bg-light' : 'text-secondary' }}" href="{{ route('guest.events') }}"><i class="bi bi-calendar-event me-2"></i>Events</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('company*') || Request::is('companies*') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="#">Company</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('about*') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('contact*') ? 'active bg-light text-primary fw-semibold' : 'text-secondary hover-bg-light' }}" href="#">Contact</a>
                </li>
            </ul>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                <!-- Global Search Trigger -->
                <button class="btn btn-link text-secondary p-2 text-decoration-none hover-bg-light rounded-circle me-2" title="Search">
                    <i class="bi bi-search fs-5"></i>
                </button>

                @auth
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="btn btn-link text-secondary p-2 text-decoration-none hover-bg-light rounded-circle position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="width: 300px; border-radius: 12px;">
                            <li><h6 class="dropdown-header fw-bold text-navy">Notifications</h6></li>
                            @forelse(auth()->user()->unreadNotifications->take(3) as $notification)
                                <li><a class="dropdown-item py-2 small" href="#">{{ $notification->data['message'] ?? 'New Notification' }}</a></li>
                            @empty
                                <li><span class="dropdown-item py-3 text-center text-muted small">No new notifications.</span></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center text-primary small fw-semibold" href="#">View All</a></li>
                        </ul>
                    </div>

                    <!-- Dashboard Button -->
                    <a href="{{ route('dashboard') }}" class="btn btn-premium-outline btn-sm fw-semibold px-3 rounded-pill">Dashboard</a>

                    <!-- User Avatar Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle border rounded-pill p-1 pe-3 hover-bg-light transition-all" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f1f5f9&color=0f172a" alt="User" width="32" height="32" class="rounded-circle me-2">
                            <span class="text-navy fw-medium small">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 12px; min-width: 200px;">
                            <li>
                                <div class="px-3 py-2">
                                    <span class="d-block fw-bold text-navy">{{ auth()->user()->name }}</span>
                                    <span class="d-block small text-muted text-capitalize">{{ auth()->user()->role }} Account</span>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider opacity-10"></li>
                            <li><a class="dropdown-item rounded-2 py-2 text-secondary" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item rounded-2 py-2 text-secondary" href="{{ route('profile.settings') }}"><i class="bi bi-person-circle me-2"></i> Profile Settings</a></li>
                            <li><hr class="dropdown-divider opacity-10"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-2 py-2 text-danger fw-semibold"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-decoration-none fw-semibold text-secondary px-3 hover-text-navy">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-premium rounded-pill px-4 fw-semibold shadow-sm">Sign up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Offcanvas Navbar -->
<div class="offcanvas offcanvas-start border-0 shadow d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 320px;">
    <div class="offcanvas-header bg-light border-bottom">
        <a class="navbar-brand fw-bold fs-4 text-navy d-flex align-items-center" href="{{ url('/') }}">
            <div class="bg-primary text-white rounded p-1 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-mortarboard-fill fs-5"></i>
            </div>
            NextCampus
        </a>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column py-4">
        
        <!-- Mobile Search -->
        <div class="mb-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-start-0 ps-0" placeholder="Search NextCampus...">
            </div>
        </div>

        <ul class="navbar-nav flex-grow-1 pe-3 gap-2">
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('/') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ url('/') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            </li>
            
            <!-- Mobile Opportunities Section -->
            <li class="nav-item mt-2">
                <span class="px-3 text-muted small fw-bold text-uppercase tracking-wide">Opportunities</span>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('guest/internships*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ route('guest.internships') }}"><i class="bi bi-briefcase me-2"></i>Internships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('guest/scholarships*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ route('guest.scholarships') }}"><i class="bi bi-cash-stack me-2"></i>Scholarships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('guest/competitions*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ route('guest.competitions') }}"><i class="bi bi-trophy me-2"></i>Competitions</a>
            </li>

            <!-- Mobile Resources Section -->
            <li class="nav-item mt-2">
                <span class="px-3 text-muted small fw-bold text-uppercase tracking-wide">Resources</span>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('guest/notes*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ route('guest.notes') }}"><i class="bi bi-journal-text me-2"></i>Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('student/forum*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ url('/student/forum') }}"><i class="bi bi-chat-square-text me-2"></i>Discussion Forum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 ms-2 {{ Request::is('guest/events*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="{{ route('guest.events') }}"><i class="bi bi-calendar-event me-2"></i>Events</a>
            </li>

            <li><hr class="dropdown-divider my-2 opacity-10"></li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('company*') || Request::is('companies*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="#"><i class="bi bi-buildings me-2"></i>Company</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('about*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="#"><i class="bi bi-info-circle me-2"></i>About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('contact*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-navy fw-medium' }}" href="#"><i class="bi bi-envelope me-2"></i>Contact</a>
            </li>
        </ul>

        <div class="mt-4 pt-4 border-top">
            @auth
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f1f5f9&color=0f172a" alt="User" width="48" height="48" class="rounded-circle me-3">
                    <div>
                        <h6 class="mb-0 fw-bold text-navy">{{ auth()->user()->name }}</h6>
                        <small class="text-secondary text-capitalize">{{ auth()->user()->role }}</small>
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-premium w-100"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-light border w-100 text-danger fw-semibold"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                    </form>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-premium w-100 fw-semibold">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-premium w-100 fw-semibold shadow-sm">Sign up for free</a>
                </div>
            @endauth
        </div>
    </div>
</div>

<style>
    /* Removed padding-top to fix white space above navbar */
    body {
        /* No padding top for sticky-top */
    }

    /* Navbar Premium Enhancements */
    .hover-bg-light:hover {
        background-color: #f8fafc;
        color: var(--primary-color) !important;
    }
    
    .hover-text-navy:hover {
        color: var(--dark-navy) !important;
    }

    .navbar-premium {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .navbar-premium.scrolled {
        background-color: rgba(255, 255, 255, 0.95) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Dropdown hover behavior for desktop */
    @media (min-width: 992px) {
        .navbar-premium .dropdown:hover .dropdown-menu {
            display: block;
            animation: fadeIn 0.2s ease-in;
        }
        .navbar-premium .dropdown-menu {
            display: none;
            margin-top: 0;
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991.98px) {
        body { /* No padding top */ }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sticky Navbar Effect
        const mainNav = document.getElementById('mainNav');
        if(mainNav && !mainNav.dataset.scrollHandled) {
            mainNav.dataset.scrollHandled = 'true';
            window.addEventListener('scroll', function() {
                if (window.scrollY > 10) {
                    mainNav.classList.add('scrolled');
                } else {
                    mainNav.classList.remove('scrolled');
                }
            });
        }
    });
</script>
