@extends('layouts.dashboard-layout')
@section('page-title', 'Assignments & Tests')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h5 class="fw-bold text-navy mb-0">Manage Assignments & Tests</h5>
    <a href="{{ route('teacher.assignments.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-circle me-1"></i>Create New</a>
</div>
<div class="card card-premium p-4">
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light"><tr><th>#</th><th>Title</th><th>Type</th><th>Due Date</th><th>Submissions</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($assignments as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $item->title }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($item->type) }}</span></td>
                        <td>{{ $item->due_date?->format('M d, Y') }}</td>
                        <td>{{ $item->submissions_count }}</td>
                        <td><a href="{{ route('teacher.assignments.submissions', $item->id) }}" class="btn btn-outline-primary btn-sm">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
