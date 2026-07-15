@extends('layouts.guest-bootstrap')

@section('title', 'Competitions & Hackathons - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-navy"><i class="bi bi-trophy text-primary me-2"></i>Competitions & Challenges</h1>
            <p class="text-secondary">Participate in campus activities, win exciting prizes, and showcase your skills.</p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <form action="{{ route('guest.competitions') }}" method="GET" class="d-flex shadow-sm rounded-3">
                    <input type="text" name="search" class="form-control border-end-0 rounded-start-3 py-3" placeholder="Search competitions..." value="{{ $search }}">
                    <button type="submit" class="btn btn-premium rounded-end-3 px-4"><i class="bi bi-search"></i> Search</button>
                </form>
            </div>
        </div>

        <!-- Competitions Grid -->
        <div class="row g-4">
            @forelse($competitions as $comp)
                <div class="col-md-4">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-3">{{ $comp->category->name ?? 'Contest' }}</span>
                            <h5 class="fw-bold text-navy mb-2">{{ $comp->title }}</h5>
                            <p class="text-secondary small line-clamp-3">{{ Str::limit($comp->description, 130) }}</p>
                        </div>
                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-danger small fw-semibold"><i class="bi bi-clock me-1"></i>Register by: {{ $comp->registration_deadline->format('M d, Y') }}</span>
                            <a href="{{ route('guest.competition.detail', $comp->id) }}" class="btn btn-premium btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="fs-1 text-secondary"><i class="bi bi-inbox"></i></div>
                    <p class="text-secondary mt-2">No active competitions found at this time.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $competitions->appends(['search' => $search])->links() }}
        </div>
    </div>
@endsection
