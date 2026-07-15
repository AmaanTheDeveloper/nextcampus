@extends('layouts.dashboard-layout')

@section('page-title', 'Student Q&A Forum')

@section('content')

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <strong>Error:</strong> {{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- ===== LEFT: Search + Thread List ===== --}}
    <div class="col-12 col-lg-8">

        {{-- Search Bar --}}
        <div class="card card-premium p-3 mb-4">
            <form action="{{ route('student.forum') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control"
                       placeholder="Search questions by title or content..."
                       value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-premium flex-shrink-0">
                    <i class="bi bi-search me-1"></i>Search
                </button>
                @if(!empty($search))
                    <a href="{{ route('student.forum') }}" class="btn btn-outline-secondary flex-shrink-0">Clear</a>
                @endif
            </form>
        </div>

        {{-- Thread List --}}
        <div class="card card-premium p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="bi bi-chat-left-text text-primary me-2"></i>Recent Discussion Threads
                </h5>
                @if(!empty($search))
                    <span class="badge bg-primary-subtle text-primary">
                        Results for: "{{ $search }}"
                    </span>
                @endif
            </div>

            @if($questions->isEmpty())
                <div class="text-center py-5">
                    <div class="fs-1 text-secondary mb-2"><i class="bi bi-chat-square-dots"></i></div>
                    <p class="text-secondary">
                        @if(!empty($search))
                            No results found for "{{ $search }}". Try different keywords.
                        @else
                            No discussions yet. Be the first to start a conversation!
                        @endif
                    </p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($questions as $q)
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-1 gap-2">
                                <h6 class="fw-bold mb-0 flex-grow-1">
                                    <a href="{{ route('student.forum.question.show', $q->id) }}"
                                       class="text-navy text-decoration-none">
                                        {{ $q->title }}
                                    </a>
                                </h6>
                                <span class="badge bg-primary-subtle text-primary flex-shrink-0">
                                    {{ $q->answers->count() }} {{ Str::plural('answer', $q->answers->count()) }}
                                </span>
                            </div>
                            <p class="text-secondary small mb-2 text-truncate">{{ strip_tags($q->content) }}</p>
                            <div class="d-flex justify-content-between align-items-center text-muted small flex-wrap gap-1">
                                <div>
                                    <i class="bi bi-person me-1"></i>{{ $q->student->name ?? 'Unknown' }}
                                    &bull;
                                    <span class="ms-1">{{ $q->created_at->diffForHumans() }}</span>
                                </div>
                                <span><i class="bi bi-eye me-1"></i>{{ $q->views }} views</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $questions->appends(['search' => $search ?? ''])->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ===== RIGHT: Ask a Question ===== --}}
    <div class="col-12 col-lg-4">
        <div class="card card-premium p-4 sticky-top" style="top:80px;">
            <h5 class="fw-bold text-navy mb-4">
                <i class="bi bi-plus-circle text-primary me-2"></i>Ask a Question
            </h5>
            <form action="{{ route('student.forum.question.store') }}" method="POST" id="askQuestionForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">
                        Question Title <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="e.g. How to get started with React hooks?"
                           value="{{ old('title') }}"
                           required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">
                        Describe your question <span class="text-danger">*</span>
                    </label>
                    <textarea name="content"
                              class="form-control @error('content') is-invalid @enderror"
                              rows="6"
                              placeholder="Explain your question in detail so others can help..."
                              required>{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-premium w-100" id="postQuestionBtn">
                    <i class="bi bi-send me-1"></i>Post Question
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Prevent double-submit
document.getElementById('askQuestionForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('postQuestionBtn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Posting...';
    }
});
</script>
@endsection
