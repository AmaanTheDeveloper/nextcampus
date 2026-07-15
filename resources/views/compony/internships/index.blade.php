@extends('layouts.dashboard-layout')
@section('page-title', 'My Internships')
@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-briefcase text-primary me-2"></i>My Posted Internships</h5>
        <a href="{{ route('company.internships.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-lg me-1"></i>Post New Internship</a>
    </div>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr><th>#</th><th>Title</th><th>Location</th><th>Deadline</th><th>Status</th><th>Approval</th><th>Applications</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($internships as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $item->title }}</td>
                        <td>{{ $item->location }}</td>
                        <td class="text-danger">{{ $item->deadline->format('M d, Y') }}</td>
                        <td><span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                        <td>
                            <span class="badge bg-{{ ($item->approval_status ?? 'approved') === 'approved' ? 'success' : (($item->approval_status ?? '') === 'pending' ? 'warning text-dark' : 'danger') }}">
                                {{ ucfirst($item->approval_status ?? 'approved') }}
                            </span>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $item->applications_count }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('company.internships.edit', $item->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('company.internships.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this internship?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-secondary py-4">No internships posted yet. <a href="{{ route('company.internships.create') }}">Post your first internship!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
