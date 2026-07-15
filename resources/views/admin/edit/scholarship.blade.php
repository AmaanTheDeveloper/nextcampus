@extends('layouts.dashboard-layout')
@section('page-title', 'Edit Scholarship')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold mb-4">Edit Scholarship</h5>
            <form action="{{ route('admin.scholarships.update', $scholarship->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $scholarship->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $scholarship->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $scholarship->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Eligibility</label>
                    <textarea name="eligibility" class="form-control" rows="3">{{ old('eligibility', $scholarship->eligibility) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="text" name="amount" class="form-control" value="{{ old('amount', $scholarship->amount) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Official Apply Link</label>
                    <input type="url" name="official_apply_link" class="form-control" required value="{{ old('official_apply_link', $scholarship->official_apply_link) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $scholarship->deadline?->format('Y-m-d')) }}" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" id="pub" @checked($scholarship->is_published)>
                    <label class="form-check-label" for="pub">Published on website</label>
                </div>
                <button type="submit" class="btn btn-primary">Update Scholarship</button>
                <a href="{{ route('admin.scholarships') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
