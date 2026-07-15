@extends('layouts.dashboard-layout')
@section('page-title', 'Teacher Dashboard')
@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card p-3 card-premium border-start border-4 border-primary h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Notes Uploaded</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $notesUploadedCount }}</h3>
                </div>
                <div class="fs-2 text-primary opacity-75"><i class="bi bi-cloud-upload"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card p-3 card-premium border-start border-4 border-success h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Total Downloads</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $totalDownloads }}</h3>
                </div>
                <div class="fs-2 text-success opacity-75"><i class="bi bi-download"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card p-3 card-premium border-start border-4 border-info h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small mb-1 fw-medium">Active Assignments</p>
                    <h3 class="fw-bold text-navy mb-0 fs-4">{{ $assignmentsCount ?? 0 }}</h3>
                </div>
                <div class="fs-2 text-info opacity-75"><i class="bi bi-journal-check"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions Row --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <a href="{{ route('teacher.notes.create') }}" class="card card-premium p-3 d-flex flex-row align-items-center gap-3 text-decoration-none">
            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                <i class="bi bi-cloud-upload fs-4 text-primary"></i>
            </div>
            <div>
                <div class="fw-bold text-navy">Upload Notes</div>
                <div class="text-muted small">Share study material with students</div>
            </div>
            <i class="bi bi-chevron-right text-muted ms-auto"></i>
        </a>
    </div>
    <div class="col-12 col-md-6">
        <a href="{{ route('teacher.assignments.create') }}" class="card card-premium p-3 d-flex flex-row align-items-center gap-3 text-decoration-none">
            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                <i class="bi bi-plus-circle fs-4 text-success"></i>
            </div>
            <div>
                <div class="fw-bold text-navy">Create Assignment / Test</div>
                <div class="text-muted small">Assign tasks or tests to students</div>
            </div>
            <i class="bi bi-chevron-right text-muted ms-auto"></i>
        </a>
    </div>
</div>

{{-- Recent Notes --}}
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold text-navy mb-0">
            <i class="bi bi-file-earmark-pdf text-primary me-2"></i>Recent Notes
        </h5>
        <a href="{{ route('teacher.notes.index') }}" class="btn btn-premium-outline btn-sm">
            View All
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Downloads</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentNotes as $note)
                    <tr>
                        <td class="fw-bold text-navy">{{ $note->title }}</td>
                        <td>{{ $note->subject }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $note->semester }}</span></td>
                        <td>{{ $note->downloads_count }}</td>
                        <td>
                            @if($note->approval_status === 'approved')
                                <span class="badge bg-success">Published</span>
                            @elseif($note->approval_status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No notes uploaded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection