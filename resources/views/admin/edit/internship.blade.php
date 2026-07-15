@extends('layouts.dashboard-layout')
@section('page-title', 'Edit Internship')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <form action="{{ route('admin.internships.update', $internship->id) }}" method="POST">
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
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $internship->location) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $internship->deadline->format('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected($internship->status === 'active')>Active</option>
                            <option value="closed" @selected($internship->status === 'closed')>Closed</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="pub" @checked($internship->is_published)>
                            <label class="form-check-label" for="pub">Published</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium">Save Changes</button>
                    <a href="{{ route('admin.internships') }}" class="btn btn-premium-outline">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
