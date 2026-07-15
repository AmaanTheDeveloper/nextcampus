@extends('layouts.dashboard-layout')

@section('page-title', 'Activity Logs')

@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-activity text-primary me-2"></i>System Activity Logs</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>#</th>
                    <th>Admin</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $log->causer->name ?? 'System' }}</td>
                        <td>{{ $log->description }}</td>
                        <td class="text-muted">{{ $log->created_at->format('M d, Y @ h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">No activity logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
