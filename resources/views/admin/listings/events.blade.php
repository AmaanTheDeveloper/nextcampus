@extends('layouts.dashboard-layout')
@section('page-title', 'All Events')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h5 class="fw-bold text-navy mb-0"><i class="bi bi-calendar-event text-primary me-2"></i>All Events</h5>
    <a href="{{ route('admin.events.create') }}" class="btn btn-premium btn-sm">Create Event</a>
</div>
<div class="card card-premium p-4">
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr><th>#</th><th>Title</th><th>Creator</th><th>Type</th><th>Approval</th><th>Published</th><th>Event Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($events as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $item->title }}</td>
                        <td>{{ $item->creator->name ?? 'Admin' }}</td>
                        <td><span class="badge bg-primary">{{ $item->type }}</span></td>
                        <td><span class="badge bg-{{ $item->approval_status === 'approved' ? 'success' : ($item->approval_status === 'pending' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($item->approval_status) }}</span></td>
                        <td>{{ $item->is_published ? 'Yes' : 'No' }}</td>
                        <td>{{ $item->event_date->format('M d, Y') }}</td>
                        <td class="text-nowrap">
                            @if($item->approval_status === 'pending')
                                <form action="{{ route('admin.events.approve', $item->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
                                <form action="{{ route('admin.events.reject', $item->id) }}" method="POST" class="d-inline">@csrf<button class="btn btn-warning btn-sm">Reject</button></form>
                            @endif
                            <a href="{{ route('admin.events.edit', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.events.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
