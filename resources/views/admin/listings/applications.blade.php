@extends('layouts.dashboard-layout')
@section('page-title', 'Internship Applications')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-people text-primary me-2"></i>All Internship Applications</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light"><tr><th>#</th><th>Student</th><th>Internship</th><th>Company</th><th>Status</th><th>Applied</th></tr></thead>
            <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $app->student->name ?? 'N/A' }}</td>
                        <td>{{ $app->internship->title ?? 'N/A' }}</td>
                        <td>{{ $app->internship?->company?->companyProfile?->company_name ?? $app->internship?->company?->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($app->status) }}</span></td>
                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
