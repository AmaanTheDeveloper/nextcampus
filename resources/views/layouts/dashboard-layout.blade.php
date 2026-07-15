@extends('layouts.bootstrap')

@section('body')
<div class="dashboard-wrapper">

    {{-- ===================== MOBILE TOPBAR ===================== --}}
    <div class="mobile-topbar d-flex d-md-none justify-content-between align-items-center px-3 py-2">
        <h5 class="text-white mb-0 small fw-bold"><i class="bi bi-mortarboard-fill me-1"></i>NextCampus</h5>
        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list fs-5"></i>
        </button>
    </div>

    {{-- ===================== DESKTOP SIDEBAR ===================== --}}
    <nav class="sidebar d-none d-md-flex flex-column position-fixed" id="desktopSidebar">
        @include('layouts.partials.dashboard-sidebar')
    </nav>

    {{-- ===================== MOBILE OFFCANVAS SIDEBAR ===================== --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" style="background-color:#0f172a;width:280px;">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title text-white fw-bold"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>NextCampus</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('layouts.partials.dashboard-sidebar')
        </div>
    </div>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <main class="dashboard-main">

        {{-- TOP HEADER BAR --}}
        <div class="dashboard-topbar d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white">
            <h1 class="h5 text-navy fw-bold mb-0 text-truncate me-3">
                @yield('page-title', 'Dashboard')
            </h1>
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                {{-- Notification Bell --}}
                <div class="dropdown">
                    <button class="btn btn-light position-relative rounded-pill p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill text-secondary fs-5"></i>
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2" style="width:min(320px,90vw);max-height:400px;overflow-y:auto;">
                        <li class="dropdown-header fw-bold text-navy py-2">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <li class="p-2 border-bottom">
                                <div class="small fw-semibold text-navy">{{ $notification->data['title'] ?? 'New Notification' }}</div>
                                <div class="small text-secondary">{{ $notification->data['message'] ?? '' }}</div>
                                <div class="text-muted" style="font-size:0.7rem;">{{ $notification->created_at->diffForHumans() }}</div>
                            </li>
                        @empty
                            <li class="text-center text-secondary small py-3">No new notifications.</li>
                        @endforelse
                        @if($unreadCount > 0)
                            <li>
                                <form action="{{ route('notifications.read') }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm w-100">Mark all as read</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Profile & Site Buttons --}}
                <a href="{{ route('profile.settings') }}" class="btn btn-sm btn-premium-outline d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="bi bi-gear"></i><span class="d-none d-lg-inline">Profile</span>
                </a>
                <a href="{{ url('/') }}" class="btn btn-sm btn-premium-outline d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="bi bi-house"></i><span class="d-none d-lg-inline">Site</span>
                </a>

                {{-- Avatar + Name --}}
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ auth()->user()->profile_photo_url }}" class="rounded-circle border" width="36" height="36" alt="avatar" style="object-fit:cover;">
                    <span class="fw-semibold small d-none d-md-inline text-navy">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>

        {{-- PAGE CONTENT --}}
        <div class="dashboard-content p-3 p-md-4">
            @yield('content')
        </div>

    </main>
</div>
@endsection

@push('styles')
<style>
/* ============================================
   DASHBOARD LAYOUT – RESPONSIVE
   ============================================ */
:root {
    --sidebar-w: 260px;
}

/* Wrapper fills the viewport */
.dashboard-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ---- Sidebar ---- */
.sidebar {
    top: 0;
    left: 0;
    width: var(--sidebar-w);
    height: 100vh;
    z-index: 1030;
    overflow-y: auto;
    background: #0f172a;
    scrollbar-width: thin;
}

/* ---- Mobile topbar ---- */
.mobile-topbar {
    background: #0f172a;
    position: sticky;
    top: 0;
    z-index: 1020;
}

/* ---- Main content area ---- */
.dashboard-main {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: var(--light-gray, #f8fafc);
    width: 100%;
}

/* ---- Top header bar ---- */
.dashboard-topbar {
    position: sticky;
    top: 0;
    z-index: 1010;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

/* ============ DESKTOP (md+) ============ */
@media (min-width: 768px) {
    .dashboard-wrapper {
        flex-direction: row;
    }

    .dashboard-main {
        margin-left: var(--sidebar-w);
        width: calc(100% - var(--sidebar-w));
        min-height: 100vh;
    }

    .mobile-topbar {
        display: none !important;
    }
}

/* ============ MOBILE (< 768px) ============ */
@media (max-width: 767.98px) {
    .dashboard-main {
        margin-left: 0;
        width: 100%;
    }

    .dashboard-content {
        padding: 1rem !important;
    }

    .card {
        margin-bottom: 1rem;
    }

    .table-responsive {
        font-size: 0.82rem;
    }

    .btn {
        font-size: 0.82rem;
    }

    h1, .h1 {
        font-size: 1.25rem;
    }

    .dropdown-menu {
        width: 95vw !important;
    }
}

/* ============ SMALL MOBILE (< 576px) ============ */
@media (max-width: 575.98px) {
    .dashboard-content {
        padding: 0.75rem !important;
    }

    .dashboard-topbar {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
}

img {
    max-width: 100%;
    height: auto;
}
</style>
@endpush
