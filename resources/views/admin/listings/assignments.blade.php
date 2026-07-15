@extends('layouts.dashboard-layout')
@section('page-title', 'Teacher Assignments & Tests')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-journal-check text-primary me-2"></i>All Assignments & Tests</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light"><tr><th>#</th><th>Title</th><th>Teacher</th><th>Type</th><th>Due Date</th><th>Submissions</th></tr></thead>
            <tbody>
                @foreach($assignments as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->teacher->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($item->type) }}</span></td>
                        <td>{{ $item->due_date?->format('M d, Y') ?? 'N/A' }}</td>
                        <td>{{ $item->submissions_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
