@extends('layouts.dashboard-layout')

@section('page-title', 'My Registered Competitions')

@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-trophy text-primary me-2"></i>My Registered Competitions</h5>
        <a href="{{ route('guest.competitions') }}" class="btn btn-premium btn-sm"><i class="bi bi-search me-1"></i>Browse Competitions</a>
    </div>

    @if($registrations->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-secondary"><i class="bi bi-trophy"></i></div>
            <p class="text-secondary mt-2">You haven't registered for any competitions yet.</p>
            <a href="{{ route('guest.competitions') }}" class="btn btn-premium mt-3">Explore Competitions</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatables table-hover align-middle">
                <thead class="table-light small text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Competition Title</th>
                        <th>Category</th>
                        <th>Registration Date</th>
                        <th>Start Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="small text-navy">
                    @foreach($registrations as $reg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('guest.competition.detail', $reg->competition->id) }}" class="fw-bold text-decoration-none text-navy">
                                    {{ $reg->competition->title }}
                                </a>
                            </td>
                            <td>{{ $reg->competition->category->name ?? 'General' }}</td>
                            <td class="text-muted">{{ $reg->created_at->format('M d, Y') }}</td>
                            <td>{{ $reg->competition->start_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-success">Registered</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
