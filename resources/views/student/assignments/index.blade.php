@extends('layouts.dashboard-layout')
@section('page-title', 'My Assignments & Tests')
@section('content')

<div class="card card-premium p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Teacher</th>
                    <th>Type</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $sub)
                    <tr>
                        <td class="fw-bold">{{ $sub->assignment->title }}</td>
                        <td>{{ $sub->assignment->teacher->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($sub->assignment->type) }}</span></td>
                        <td>{{ $sub->assignment->due_date?->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $sub->status === 'graded' ? 'success' : ($sub->status === 'submitted' ? 'info' : 'secondary') }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td>{{ $sub->marks ?? '—' }} @if($sub->grade)/ {{ $sub->grade }}@endif</td>
                        <td>
                            @if($sub->status === 'pending' || $sub->status === 'submitted')
                                <button class="btn btn-premium btn-sm" data-bs-toggle="modal" data-bs-target="#submitModal{{ $sub->id }}">
                                    <i class="bi bi-upload me-1"></i>Submit
                                </button>
                            @elseif($sub->feedback)
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $sub->id }}">
                                    <i class="bi bi-chat-text me-1"></i>Feedback
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No assignments assigned yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ============================================================
     MODALS — placed OUTSIDE the table (correct HTML structure)
     ============================================================ --}}
@foreach($submissions as $sub)

    {{-- Submit Modal --}}
    @if($sub->status === 'pending' || $sub->status === 'submitted')
    <div class="modal fade" id="submitModal{{ $sub->id }}" tabindex="-1" aria-labelledby="submitModalLabel{{ $sub->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('student.assignments.submit', $sub->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom">
                        <h6 class="modal-title fw-bold text-navy" id="submitModalLabel{{ $sub->id }}">
                            <i class="bi bi-upload me-2 text-primary"></i>Submit: {{ $sub->assignment->title }}
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($sub->assignment->description)
                            <p class="small text-secondary mb-3 p-2 bg-light rounded">{{ $sub->assignment->description }}</p>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Written Answer</label>
                            <textarea name="answer_text" class="form-control" rows="5" placeholder="Type your answer here...">{{ old('answer_text', $sub->answer_text) }}</textarea>
                        </div>

                        <div>
                            <label class="form-label small fw-bold">Upload File <span class="text-muted fw-normal">(PDF / DOC / DOCX — max 10MB)</span></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                            @if($sub->submission_path)
                                <small class="text-success mt-1 d-block"><i class="bi bi-check-circle me-1"></i>File already uploaded. Uploading a new one will replace it.</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium btn-sm"><i class="bi bi-send me-1"></i>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Feedback Modal --}}
    @if($sub->feedback)
    <div class="modal fade" id="feedbackModal{{ $sub->id }}" tabindex="-1" aria-labelledby="feedbackModalLabel{{ $sub->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold text-navy" id="feedbackModalLabel{{ $sub->id }}">
                        <i class="bi bi-chat-text me-2 text-primary"></i>Feedback — {{ $sub->assignment->title }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 bg-light rounded mb-3">
                        <p class="mb-0 text-navy">{{ $sub->feedback }}</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded flex-fill">
                            <div class="small text-muted">Marks</div>
                            <div class="fw-bold text-success fs-5">{{ $sub->marks ?? 'N/A' }}</div>
                        </div>
                        <div class="text-center p-3 bg-primary bg-opacity-10 rounded flex-fill">
                            <div class="small text-muted">Grade</div>
                            <div class="fw-bold text-primary fs-5">{{ $sub->grade ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif

@endforeach

@endsection
