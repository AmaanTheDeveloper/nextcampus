@extends('layouts.dashboard-layout')

@section('page-title', 'Categories')

@section('content')
<div class="row g-4">
    <!-- Add Category -->
    <div class="col-lg-4">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-plus-circle text-primary me-2"></i>Add New Category</h5>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Hackathon" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Category Type</label>
                    <select name="type" class="form-select" required>
                        <option value="competition">Competition</option>
                        <option value="scholarship">Scholarship</option>
                        <option value="note">Study Note</option>
                        <option value="internship">Internship</option>
                        <option value="event">Event</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-premium w-100">Add Category</button>
            </form>
        </div>
    </div>

    <!-- Category List -->
    <div class="col-lg-8">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-tags text-primary me-2"></i>Existing Categories</h5>
            <div class="table-responsive">
                <table class="table datatables table-hover align-middle small">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold text-navy">{{ $cat->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($cat->type) }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
