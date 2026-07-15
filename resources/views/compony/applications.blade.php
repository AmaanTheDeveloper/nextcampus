@extends('layouts.dashboard-layout')
@section('page-title', 'Applicants')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-people text-primary me-2"></i>Internship Applicants</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr><th>#</th><th>Applicant</th><th>Internship</th><th>Applied On</th><th>Status</th><th>Resume</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-navy">{{ $app->student?->name ?? 'N/A' }}<br><small class="text-muted">{{ $app->student?->email ?? '' }}</small></td>
                        <td>{{ $app->internship->title }}</td>
                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($app->status === 'applied') <span class="badge bg-secondary">Applied</span>
                            @elseif($app->status === 'shortlisted') <span class="badge bg-success">Shortlisted</span>
                            @else <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('company.applications.resume', $app->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-pdf me-1"></i>CV</a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($app->status !== 'shortlisted')
                                    <form action="{{ route('company.applications.shortlist', $app->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Shortlist"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                @endif
                                @if($app->status !== 'rejected')
                                    <form action="{{ route('company.applications.reject', $app->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Reject"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary py-4">No applications received yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
