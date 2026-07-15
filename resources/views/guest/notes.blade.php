@extends('layouts.guest-bootstrap')

@section('title', 'Study Notes - NextCampus')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-navy"><i class="bi bi-file-earmark-pdf text-primary me-2"></i>Academic Notes Vault</h1>
            <p class="text-secondary">Access semester-wise study materials and PDF notes uploaded by our verified faculty.</p>
        </div>

        <!-- Search & Filter -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="{{ route('guest.notes') }}" method="GET" class="row g-2">
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

        <!-- Notes Grid -->
        <div class="row g-4">
            @forelse($notes as $note)
                <div class="col-md-4 col-sm-6">
                    <div class="card card-premium p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-primary-subtle text-primary">{{ $note->semester }}</span>
                                <span class="text-muted small"><i class="bi bi-download me-1"></i>{{ $note->downloads_count }}</span>
                            </div>
                            <h5 class="fw-bold text-navy mb-1">{{ $note->title }}</h5>
                            <span class="text-secondary small d-block mb-3"><i class="bi bi-tag me-1"></i>Subject: <strong>{{ $note->subject }}</strong></span>
                            <p class="text-secondary small line-clamp-3 mb-0">{{ $note->description ?: 'No additional description provided.' }}</p>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-muted small">By: {{ $note->uploader?->name ?? 'Unknown' }}</span>
                            @auth
                                @if(auth()->user()->role === 'student' || auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                    <a href="{{ route('notes.download', $note->id) }}" class="btn btn-premium btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-download"></i> Download PDF
                                    </a>
                                @else
                                    <span class="text-danger small"><i class="bi bi-lock-fill"></i> Students Only</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-premium-outline btn-sm d-flex align-items-center gap-1">
                                    <i class="bi bi-lock-fill"></i> Login to Download
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="fs-1 text-secondary"><i class="bi bi-inbox"></i></div>
                    <p class="text-secondary mt-2">No academic notes found matching your search.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $notes->appends(['search' => $search, 'category_id' => $categoryId ?? ''])->links() }}
        </div>
    </div>
@endsection
