@extends('layouts.dashboard-layout')
@section('page-title', 'Edit Internship')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4">Edit Internship</h5>
            <form action="{{ route('company.internships.update', $internship->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label small fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $internship->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $internship->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $internship->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="3">{{ old('requirements', $internship->requirements) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Skills</label>
                    <input type="text" name="skills" class="form-control" value="{{ old('skills', $internship->skills) }}">
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $internship->location) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Salary</label>
                        <input type="text" name="salary" class="form-control" value="{{ old('salary', $internship->salary) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $internship->deadline->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" @selected($internship->status === 'active')>Active</option>
                            <option value="closed" @selected($internship->status === 'closed')>Closed</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-{{ $internship->approval_status === 'approved' ? 'success' : ($internship->approval_status === 'pending' ? 'warning text-dark' : 'danger') }}">
                        Approval: {{ ucfirst($internship->approval_status) }}
                    </span>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium">Update Internship</button>
                    <a href="{{ route('company.internships.index') }}" class="btn btn-premium-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
