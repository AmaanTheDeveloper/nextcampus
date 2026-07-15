@extends('layouts.dashboard-layout')
@section('page-title', 'All Competitions')
@section('content')
<div class="card card-premium p-4">
    <h5 class="fw-bold text-navy mb-4"><i class="bi bi-trophy text-primary me-2"></i>All Competitions</h5>
    <div class="table-responsive">
        <table class="table datatables table-hover align-middle small">
            <thead class="table-light text-secondary">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Category</th>
        <th>Reg. Deadline</th>
        <th>Start Date</th>
        <th>Actions</th>
    </tr>
</thead>
            <tbody>
                @foreach($competitions as $item)
                    <tr>
    <td>{{ $loop->iteration }}</td>
    <td class="fw-bold text-navy">{{ $item->title }}</td>
    <td>{{ $item->category->name ?? 'N/A' }}</td>
    <td class="text-danger">{{ $item->registration_deadline->format('M d, Y') }}</td>
    <td>{{ $item->start_date->format('M d, Y') }}</td>
    <td class="d-flex gap-2">
        <a href="{{ route('admin.competitions.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('admin.competitions.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this competition?');">
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
