@extends('layouts.dashboard-layout')
@section('page-title', 'All Internships')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-briefcase text-primary me-2"></i>All Posted Internships</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>#</th><th>Title</th><th>Company</th><th>Category</th><th>Deadline</th>
                    <th>Status</th><th>Approval</th><th>Published</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $item->title }}</td>
                        <td>{{ $item->company?->companyProfile?->company_name ?? $item->company?->name ?? 'N/A' }}</td>
                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                        <td>{{ $item->deadline->format('M d, Y') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($item->status) }}</span></td>
                        <td>
                            <span class="badge bg-{{ $item->approval_status === 'approved' ? 'success' : ($item->approval_status === 'pending' ? 'warning text-dark' : 'danger') }}">
                                {{ ucfirst($item->approval_status) }}
                            </span>
                        </td>
                        <td>{{ $item->is_published ? 'Yes' : 'No' }}</td>
                        <td class="text-nowrap">
                            @if($item->approval_status === 'pending')
                                <form action="{{ route('admin.internships.approve', $item->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
                                <form action="{{ route('admin.internships.reject', $item->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-warning btn-sm">Reject</button></form>
                            @endif
                            <a href="{{ route('admin.internships.edit', $item->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.internships.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
