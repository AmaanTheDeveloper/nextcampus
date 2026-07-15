@extends('layouts.dashboard-layout')
@section('page-title', 'Review Submissions')
@section('content')

{{-- Assignment Info Card --}}
<div class="card card-premium p-4 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h5 class="fw-bold text-navy mb-1">
                {{ $assignment->title }}
                <span class="badge bg-primary ms-2">{{ ucfirst($assignment->type) }}</span>
            </h5>
            <p class="text-secondary small mb-0">{{ $assignment->description }}</p>
        </div>
        <div class="text-end">
            @if($assignment->total_marks)
                <span class="badge bg-success-subtle text-success">Total Marks: {{ $assignment->total_marks }}</span>
            @endif
            <div class="text-muted small mt-1">Due: {{ $assignment->due_date?->format('M d, Y') }}</div>
        </div>
    </div>
</div>

{{-- Submissions Table --}}
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold text-navy mb-0">
            <i class="bi bi-people text-primary me-2"></i>Student Submissions
            <span class="badge bg-secondary ms-2">{{ $assignment->submissions->count() }}</span>
        </h5>
        <a href="{{ route('teacher.assignments.index') }}" class="btn btn-premium-outline btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Assignments
        </a>
    </div>

    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignment->submissions as $sub)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $sub->student->name ?? 'N/A' }}</td>
                        <td>
                            @if($sub->status === 'graded')
                                <span class="badge bg-success">Graded</span>
                            @elseif($sub->status === 'submitted')
                                <span class="badge bg-info text-dark">Submitted</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                        <td>{{ $sub->submitted_at?->format('M d, Y H:i') ?? '—' }}</td>
                        <td>
                            @if($sub->marks !== null)
                                <span class="fw-bold text-success">{{ $sub->marks }}</span>
                                @if($assignment->total_marks)
                                    <span class="text-muted">/ {{ $assignment->total_marks }}</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $sub->grade ?? '—' }}</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#gradeModal{{ $sub->id }}">
                                <i class="bi bi-pencil-square me-1"></i>Grade
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if($assignment->submissions->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No submissions yet.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- =====================================================
     GRADING MODALS — placed OUTSIDE the table (critical!)
     ===================================================== --}}
@foreach($assignment->submissions as $sub)
<div class="modal fade" id="gradeModal{{ $sub->id }}" tabindex="-1"
     aria-labelledby="gradeModalLabel{{ $sub->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('teacher.submissions.grade', $sub->id) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold text-navy" id="gradeModalLabel{{ $sub->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Grade: {{ $sub->student->name ?? 'Student' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- Student's Submission --}}
                    @if($sub->answer_text)
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Written Answer</label>
                            <div class="p-3 bg-light rounded border" style="max-height:200px;overflow-y:auto;white-space:pre-wrap;font-size:0.9rem;">{{ $sub->answer_text }}</div>
                        </div>
                    @endif

                    @if($sub->submission_path)
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Uploaded File</label>
                            <div>
                                <a href="{{ asset('storage/' . $sub->submission_path) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-download me-1"></i>Download / View Submission
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(!$sub->answer_text && !$sub->submission_path)
                        <div class="alert alert-warning py-2">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            This student has not submitted any content yet.
                        </div>
                    @endif

                    <hr>

                    {{-- Grading Fields --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">
                                Marks
                                @if($assignment->total_marks)
                                    <span class="text-muted fw-normal">(out of {{ $assignment->total_marks }})</span>
                                @endif
                            </label>
                            <input type="number"
                                   name="marks"
                                   class="form-control"
                                   min="0"
                                   max="{{ $assignment->total_marks ?? 100 }}"
                                   value="{{ $sub->marks }}"
                                   placeholder="Enter marks">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Grade</label>
                            <select name="grade" class="form-select">
                                <option value="">— Select Grade —</option>
                                @foreach(['A+','A','A-','B+','B','B-','C+','C','C-','D','F'] as $g)
                                    <option value="{{ $g }}" {{ $sub->grade === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Feedback / Comments</label>
                            <textarea name="feedback"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Provide detailed feedback for the student...">{{ $sub->feedback }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-premium btn-sm">
                        <i class="bi bi-check-lg me-1"></i>Save Grade
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
