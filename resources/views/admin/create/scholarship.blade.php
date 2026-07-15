@extends('layouts.dashboard-layout')
@section('page-title', 'Create Scholarship')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-award text-primary me-2"></i>Create Scholarship</h5>
            <form action="{{ route('admin.scholarships.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Eligibility</label>
                    <textarea name="eligibility" class="form-control" rows="3">{{ old('eligibility') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Amount (optional)</label>
                    <input type="text" name="amount" class="form-control" value="{{ old('amount') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Official Apply Link <span class="text-danger">*</span></label>
                    <input type="url" name="official_apply_link" class="form-control" required value="{{ old('official_apply_link') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Deadline <span class="text-danger">*</span></label>
                    <input type="date" name="deadline" class="form-control" required value="{{ old('deadline') }}">
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Create Scholarship</button>
                    <a href="{{ route('admin.scholarships') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
