@extends('layouts.dashboard-layout')
@section('page-title', 'All Scholarships')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-award text-primary me-2"></i>All Scholarships</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scholarships as $item)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold text-navy">{{ $item->title }}</td>
                    <td>{{ $item->amount ?: 'Varies' }}</td>
                    <td class="text-danger">{{ $item->deadline->format('M d, Y') }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.scholarships.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.scholarships.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
