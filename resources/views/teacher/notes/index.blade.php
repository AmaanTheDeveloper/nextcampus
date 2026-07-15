@extends('layouts.dashboard-layout')
@section('page-title', 'Manage Notes')
@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-file-earmark-pdf text-primary me-2"></i>Uploaded Study Notes</h5>
        <a href="{{ route('teacher.notes.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-lg me-1"></i>Upload New Notes</a>
    </div>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr><th>#</th><th>Title</th><th>Subject</th><th>Semester</th><th>Downloads</th><th>Uploaded</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $note->title }}</td>
                        <td>{{ $note->subject }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $note->semester }}</span></td>
                        <td>{{ $note->downloads_count }}</td>
                        <td class="text-muted">{{ $note->created_at->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('teacher.notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Delete these notes?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary py-4">No notes uploaded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
