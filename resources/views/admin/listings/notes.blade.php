@extends('layouts.dashboard-layout')
@section('page-title', 'Study Notes')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-file-earmark-pdf text-primary me-2"></i>All Study Notes</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light"><tr><th>#</th><th>Title</th><th>Teacher</th><th>Category</th><th>Status</th><th>Published</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->uploader?->name ?? 'N/A' }}</td>
                        <td>{{ $note->category->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $note->approval_status === 'approved' ? 'success' : ($note->approval_status === 'pending' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($note->approval_status) }}</span></td>
                        <td>{{ $note->is_published ? 'Yes' : 'No' }}</td>
                        <td class="text-nowrap">
                            @if($note->approval_status === 'pending')
                                <form action="{{ route('admin.notes.approve', $note->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
                                <form action="{{ route('admin.notes.reject', $note->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-warning btn-sm">Reject</button></form>
                            @endif
                            <form action="{{ route('admin.notes.delete', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
