@extends('layouts.dashboard-layout')

@section('page-title', 'Teacher Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, #0d9488, #0f766e); color: white;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="z-index-1 position-relative">
                    <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 📚</h2>
                    <p class="mb-4 opacity-75">Ready to inspire? Manage your classes, upload study materials, and engage with your students.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('teacher.notes.create') }}" class="btn btn-light text-success fw-bold px-4"><i class="bi bi-cloud-upload-fill me-2"></i>Upload Notes</a>
                        <a href="{{ route('teacher.assignments.create') }}" class="btn btn-outline-light"><i class="bi bi-journal-plus me-2"></i>Create Assignment</a>
                    </div>
                </div>
                <!-- Abstract Design Background -->
                <div class="position-absolute" style="right: 5%; top: -20%; opacity: 0.1;">
                    <i class="bi bi-book-half" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Notes Uploaded</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $notesUploadedCount ?? 0 }}</h3>
                <span class="badge bg-primary-subtle text-primary mt-2"><i class="bi bi-file-earmark-pdf me-1"></i>Materials</span>
            </div>
            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-cloud-upload fs-4 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Total Downloads</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $totalDownloads ?? 0 }}</h3>
                <span class="badge bg-success-subtle text-success mt-2"><i class="bi bi-graph-up-arrow me-1"></i>Engagement</span>
            </div>
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-download fs-4 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card card-premium p-4 h-100 border-0 shadow-sm d-flex flex-row align-items-center justify-content-between">
            <div>
                <h6 class="text-secondary small fw-semibold text-uppercase mb-1">Active Assignments</h6>
                <h3 class="fw-bold text-navy mb-0 fs-3">{{ $assignmentsCount ?? 0 }}</h3>
                <span class="badge bg-info-subtle text-info mt-2"><i class="bi bi-clock-history me-1"></i>Ongoing</span>
            </div>
            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-journal-check fs-4 text-info"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        {{-- Recent Notes --}}
        <div class="card card-premium p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="bi bi-file-earmark-pdf text-primary me-2"></i>Recent Notes
                </h5>
                <a href="{{ route('teacher.notes.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top border-bottom small">
                    <thead class="table-light text-secondary text-uppercase">
                        <tr>
                            <th>Title</th>
                            <th>Subject</th>
                            <th>Semester</th>
                            <th>Downloads</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-navy">
                        @forelse($recentNotes ?? [] as $note)
                            <tr>
                                <td class="fw-bold">{{ $note->title }}</td>
                                <td>{{ $note->subject }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $note->semester }}</span></td>
                                <td><span class="badge bg-success-subtle text-success rounded-pill px-2"><i class="bi bi-download me-1"></i>{{ $note->downloads_count }}</span></td>
                                <td>
                                    @if($note->approval_status === 'approved')
                                        <span class="badge bg-success-subtle text-success px-2 py-1 border"><i class="bi bi-check-circle me-1"></i>Published</span>
                                    @elseif($note->approval_status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning px-2 py-1 border text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1 border"><i class="bi bi-x-circle me-1"></i>Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>
                                    No notes uploaded yet.<br>
                                    <a href="{{ route('teacher.notes.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">Upload First Note</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <!-- Quick Actions Row -->
        <div class="card card-premium p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Tasks</h5>
            
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('teacher.notes.create') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-primary-subtle')" onmouseout="this.classList.remove('bg-primary-subtle')">
                    <div class="bg-primary rounded p-2 text-white">
                        <i class="bi bi-cloud-upload fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Upload Notes</div>
                        <div class="text-muted small">Share study material</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>

                <a href="{{ route('teacher.assignments.create') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-success-subtle')" onmouseout="this.classList.remove('bg-success-subtle')">
                    <div class="bg-success rounded p-2 text-white">
                        <i class="bi bi-plus-circle fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Create Assignment</div>
                        <div class="text-muted small">Assign tasks to students</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>
                
                <a href="{{ route('teacher.assignments.index') }}" class="p-3 border rounded-3 bg-light text-decoration-none d-flex align-items-center gap-3 transition hover-shadow" style="transition: all 0.3s;" onmouseover="this.classList.add('bg-info-subtle')" onmouseout="this.classList.remove('bg-info-subtle')">
                    <div class="bg-info rounded p-2 text-white">
                        <i class="bi bi-journal-check fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy">Grade Submissions</div>
                        <div class="text-muted small">Review student work</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted ms-auto"></i>
                </a>
            </div>
        </div>

        <!-- Student Interaction Stats -->
        <div class="card card-premium p-4 border-0 shadow-sm" style="background-color: var(--primary-navy); color: white;">
            <h5 class="fw-bold text-white mb-4"><i class="bi bi-stars text-warning me-2"></i>Engagement</h5>
            
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-eye me-2"></i>Profile Views</span>
                <span class="fw-bold fs-5">124</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                <span class="text-white-50"><i class="bi bi-bookmark-heart me-2"></i>Saved Notes</span>
                <span class="fw-bold fs-5">86</span>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-white-50"><i class="bi bi-chat-dots me-2"></i>Forum Answers</span>
                <span class="fw-bold fs-5">15</span>
            </div>
        </div>

    </div>
</div>

@endsection