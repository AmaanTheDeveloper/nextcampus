@extends('layouts.dashboard-layout')

@section('page-title', 'Bookmarked Scholarships')

@section('content')
<div class="card card-premium p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy mb-0"><i class="bi bi-bookmark-star text-primary me-2"></i>Bookmarked Scholarships</h5>
        <a href="{{ route('guest.scholarships') }}" class="btn btn-premium btn-sm"><i class="bi bi-search me-1"></i>Browse Scholarships</a>
    </div>

    @if($bookmarks->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-secondary"><i class="bi bi-bookmark-star"></i></div>
            <p class="text-secondary mt-2">You haven't bookmarked any scholarships yet.</p>
            <a href="{{ route('guest.scholarships') }}" class="btn btn-premium mt-3">Explore Scholarships</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatables table-hover align-middle">
                <thead class="table-light small text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Scholarship Title</th>
                        <th>Provider</th>
                        <th>Amount</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="small text-navy">
                    @foreach($bookmarks as $bookmark)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('guest.scholarship.detail', $bookmark->scholarship->id) }}" class="fw-bold text-decoration-none text-navy">
                                    {{ $bookmark->scholarship->title }}
                                </a>
                            </td>
                            <td>{{ $bookmark->scholarship->provider }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success">
                                    {{ $bookmark->scholarship->amount ?: 'Varies' }}
                                </span>
                            </td>
                            <td class="text-danger">{{ $bookmark->scholarship->deadline->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('student.scholarship.unbookmark', $bookmark->scholarship->id) }}" method="POST" onsubmit="return confirm('Remove bookmark?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-bookmark-x-fill me-1"></i>Unbookmark
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
