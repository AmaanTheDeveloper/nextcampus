@extends('layouts.guest-bootstrap')

@section('title', 'Browse Internships - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4 mb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">Internships</li>
                </ol>
            </nav>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-briefcase fs-2 text-primary"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-navy mb-1">Explore Internships</h2>
                        <p class="text-secondary mb-0">Discover active internship opportunities posted by verified companies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <!-- Search & Filter -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card card-premium p-3">
                    <form action="{{ route('guest.internships') }}" method="GET" class="row g-2">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0 py-2 ps-0" placeholder="Search internships..." value="{{ $search }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-select bg-light border-light py-2">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}" @selected(($categoryId ?? '') == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-premium w-100 py-2">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listings -->
        <div class="row g-4">
            @forelse($internships as $internship)
                <div class="col-md-4">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2 bg-primary-subtle text-primary rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'C') }}&background=random" class="rounded-3 w-100 h-100" alt="Logo">
                                </div>
                                <div>
                                    <h5 class="fw-bold text-navy mb-0">{{ Str::limit($internship->title, 25) }}</h5>
                                    <span class="text-secondary small">{{ $internship->company?->companyProfile?->company_name ?? $internship->company?->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <p class="text-secondary small line-clamp-3 mb-4" style="line-height: 1.6;">
                                {{ Str::limit($internship->description, 120) }}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-secondary border fw-medium px-2 py-1"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($internship->location, 15) }}</span>
                                <span class="badge bg-light text-secondary border fw-medium px-2 py-1"><i class="bi bi-cash me-1"></i>{{ Str::limit($internship->salary ?: 'Unpaid', 15) }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>{{ $internship->deadline->diffForHumans() }}</span>
                            <a href="{{ route('guest.internship.detail', $internship->id) }}" class="btn btn-premium-outline btn-sm rounded-pill px-3">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 my-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 80px; height: 80px;">
                        <i class="bi bi-briefcase fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">No Internships Found</h5>
                    <p class="text-secondary">No active internship opportunities found matching your query.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5 pt-3 border-top">
            {{ $internships->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
