@extends('layouts.guest-bootstrap')

@section('title', 'Study Notes - NextCampus')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <div class="bg-light border-bottom py-4 mb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">Study Notes</li>
                </ol>
            </nav>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-white rounded-circle shadow-sm border d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-journal-text fs-2 text-danger"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-navy mb-1">Academic Notes Vault</h2>
                        <p class="text-secondary mb-0">Access semester-wise study materials and PDF notes.</p>
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
                    <form action="{{ route('guest.notes') }}" method="GET" class="row g-2">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0 py-2 ps-0" placeholder="Search subject or title..." value="{{ $search }}">
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
                            <button type="submit" class="btn btn-premium w-100 py-2">Search Notes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notes Grid -->
        <div class="row g-4">
            @forelse($notes as $note)
                <div class="col-md-4 col-sm-6">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1"><i class="bi bi-bookmark me-1"></i>{{ $note->semester }}</span>
                                <span class="badge bg-light text-secondary border"><i class="bi bi-download me-1"></i>{{ $note->downloads_count }}</span>
                            </div>
                            <h5 class="fw-bold text-navy mb-1">{{ $note->title }}</h5>
                            <span class="text-secondary small d-block mb-3"><i class="bi bi-tag text-primary me-1"></i>Subject: <strong>{{ $note->subject }}</strong></span>
                            <p class="text-secondary small line-clamp-3 mb-0" style="line-height: 1.6;">{{ $note->description ?: 'No additional description provided.' }}</p>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($note->uploader?->name ?? 'Unknown') }}&background=random" class="rounded-circle" width="30" alt="Avatar">
                                <span class="text-muted small fw-medium">{{ Str::limit($note->uploader?->name ?? 'Unknown', 15) }}</span>
                            </div>
                            @auth
                                @if(auth()->user()->role === 'student' || auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                    <a href="{{ route('notes.download', $note->id) }}" class="btn btn-premium btn-sm rounded-pill px-3 d-flex align-items-center gap-1 shadow-sm">
                                        <i class="bi bi-download"></i> PDF
                                    </a>
                                @else
                                    <span class="text-danger small"><i class="bi bi-lock-fill"></i> Students Only</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center gap-1">
                                    <i class="bi bi-lock-fill"></i> Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 my-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary" style="width: 80px; height: 80px;">
                        <i class="bi bi-inbox fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">No Notes Found</h5>
                    <p class="text-secondary">No academic notes found matching your search criteria. Try adjusting your filters.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pt-3 border-top">
            {{ $notes->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
