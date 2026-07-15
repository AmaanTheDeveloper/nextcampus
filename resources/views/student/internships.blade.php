@extends('layouts.dashboard-layout')

@section('page-title', 'My Applied Internships')

@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-briefcase text-primary me-2"></i>My Applied Internships</h5>
        <a href="{{ route('guest.internships') }}" class="btn btn-premium btn-sm"><i class="bi bi-search me-1"></i>Browse Internships</a>
    </div>

    @if($applications->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-secondary"><i class="bi bi-briefcase"></i></div>
            <p class="text-secondary mt-2">You haven't applied for any internships yet.</p>
            <a href="{{ route('guest.internships') }}" class="btn btn-premium mt-3">Explore Opportunities</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatables table-hover align-middle">
                <thead class="table-light small text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Role / Position</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Uploaded CV</th>
                    </tr>
                </thead>
                <tbody class="small text-navy">
                    @foreach($applications as $app)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('guest.internship.detail', $app->internship->id) }}" class="fw-bold text-decoration-none text-navy">
                                    {{ $app->internship->title }}
                                </a>
                            </td>
                            <td>{{ $app->internship?->company?->companyProfile?->company_name ?? $app->internship?->company?->name ?? 'N/A' }}</td>
                            <td>{{ $app->internship->location }}</td>
                            <td class="text-muted">{{ $app->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($app->status === 'applied')
                                    <span class="badge bg-secondary">Applied</span>
                                @elseif($app->status === 'shortlisted')
                                    <span class="badge bg-success">Shortlisted</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm py-0">
                                    <i class="bi bi-file-pdf text-danger me-1"></i>View CV
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
