@extends('layouts.dashboard-layout')
@section('page-title', 'Company Dashboard')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4 card-premium border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Posted Internships</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $internshipsCount }}</h3>
                </div>
                <div class="fs-2 text-primary"><i class="bi bi-briefcase"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 card-premium border-start border-4 border-info">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Total Applications</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $applicationsCount }}</h3>
                </div>
                <div class="fs-2 text-info"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 card-premium border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small mb-1">Shortlisted</h6>
                    <h3 class="fw-bold text-navy mb-0">{{ $shortlistedCount }}</h3>
                </div>
                <div class="fs-2 text-success"><i class="bi bi-person-check"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Recent Internship Postings</h5>
        <a href="{{ route('company.internships.create') }}" class="btn btn-premium btn-sm"><i class="bi bi-plus-lg me-1"></i>Post New</a>
    </div>
    <table class="table table-hover align-middle small">
        <thead class="table-light text-secondary">
            <tr><th>Title</th><th>Location</th><th>Deadline</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($recentPostings as $item)
                <tr>
                    <td class="fw-bold text-navy">{{ $item->title }}</td>
                    <td>{{ $item->location }}</td>
                    <td class="text-danger">{{ $item->deadline->format('M d, Y') }}</td>
                    <td><span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <a href="{{ route('company.internships.edit', $item->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-secondary py-4">No internships posted yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection