@extends('layouts.guest-bootstrap')

@section('title', 'Browse Internships - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-navy">Explore Internships</h1>
            <p class="text-secondary">Discover active internship opportunities posted by verified companies.</p>
        </div>

        <!-- Search & Filter -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="{{ route('guest.internships') }}" method="GET" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control py-2" placeholder="Search..." value="{{ $search }}">
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-select py-2">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" @selected(($categoryId ?? '') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-premium w-100"><i class="bi bi-search"></i> Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listings -->
        <div class="row g-4">
            @forelse($internships as $internship)
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
                                {{ Str::limit($internship->description, 150) }}
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
                    <p class="text-secondary mt-2">No active internship opportunities found matching your query.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $internships->appends(['search' => $search])->links() }}
        </div>
    </div>
@endsection
