@extends('layouts.dashboard-layout')

@section('page-title', 'Forum Thread')

@section('content')

{{-- Success/Error Alert --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- ===== LEFT: Thread + Answers ===== --}}
    <div class="col-12 col-lg-8">

        {{-- Back Button --}}
        <a href="{{ route('student.forum') }}" class="btn btn-premium-outline btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Forum
        </a>

        {{-- Question Card --}}
        <div class="card card-premium p-4 mb-4">
            <h4 class="fw-bold text-navy mb-2">{{ $question->title }}</h4>
            <div class="d-flex flex-wrap align-items-center gap-2 text-muted small border-bottom pb-3 mb-3">
                <span class="fw-bold text-primary">
                    <i class="bi bi-person-circle me-1"></i>{{ $question->student->name ?? 'Unknown' }}
                </span>
                <span>&bull;</span>
                <span>{{ $question->created_at->diffForHumans() }}</span>
                <span>&bull;</span>
                <span><i class="bi bi-eye me-1"></i>{{ $question->views }} views</span>
                <span>&bull;</span>
                <span><i class="bi bi-chat-left me-1"></i>{{ $question->answers->count() }} answers</span>
            </div>
            <p class="text-navy mb-0" style="white-space:pre-wrap;line-height:1.7;">{{ $question->content }}</p>
        </div>

        {{-- Answers Section --}}
        <div class="card card-premium p-4 mb-4">
            <h5 class="fw-bold text-navy mb-4">
                <i class="bi bi-chat-left-dots text-primary me-2"></i>
                {{ $question->answers->count() }} {{ Str::plural('Answer', $question->answers->count()) }}
            </h5>

            @if($question->answers->isEmpty())
                <div class="text-center py-4">
                    <div class="fs-2 text-secondary mb-2"><i class="bi bi-chat-square-dots"></i></div>
                    <p class="text-secondary">No answers yet. Be the first to help!</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($question->answers as $ans)
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                <span class="fw-bold text-navy small">
                                    <i class="bi bi-person-circle me-1 text-primary"></i>
                                    {{ $ans->user->name ?? 'Anonymous' }}
                                </span>
                                <span class="text-muted small">{{ $ans->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-navy small mb-0" style="white-space:pre-wrap;line-height:1.6;">{{ $ans->content }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Post Answer Form --}}
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-3">
                <i class="bi bi-reply text-primary me-2"></i>Your Answer
            </h5>
            <form action="{{ route('student.forum.answer.store', $question->id) }}" method="POST" id="answerForm">
                @csrf
                <div class="mb-3">
                    <textarea name="content"
                              class="form-control @error('content') is-invalid @enderror"
                              rows="6"
                              placeholder="Write a clear and helpful answer..."
                              required>{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-premium px-5" id="postAnswerBtn">
                    <i class="bi bi-send me-1"></i>Post Answer
                </button>
            </form>
        </div>
    </div>

    {{-- ===== RIGHT: Guidelines ===== --}}
    <div class="col-12 col-lg-4">
        <div class="card card-premium p-4 sticky-top" style="top:80px;">
            <h5 class="fw-bold text-navy mb-3">
                <i class="bi bi-shield-exclamation text-warning me-2"></i>Forum Guidelines
            </h5>
            <ul class="list-unstyled d-flex flex-column gap-2 text-secondary small">
                <li><i class="bi bi-check-circle text-success me-2"></i>Be polite and respectful to everyone</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Provide detailed and constructive answers</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Do not post spam or irrelevant content</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Search before asking to avoid duplicates</li>
            </ul>

            <hr>

            <h6 class="fw-bold text-navy mb-2"><i class="bi bi-info-circle text-primary me-1"></i>About this thread</h6>
            <div class="small text-secondary">
                <div class="mb-1"><i class="bi bi-calendar me-1"></i>Posted: {{ $question->created_at->format('M d, Y') }}</div>
                <div class="mb-1"><i class="bi bi-eye me-1"></i>Views: {{ $question->views }}</div>
                <div><i class="bi bi-chat me-1"></i>Answers: {{ $question->answers->count() }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('answerForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('postAnswerBtn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Posting...';
    }
});
</script>
@endsection
