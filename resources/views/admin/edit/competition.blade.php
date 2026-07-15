@extends('layouts.dashboard-layout')
@section('page-title', 'Edit Competition')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-trophy text-primary me-2"></i>Edit Competition</h5>
            <form action="{{ route('admin.competitions.update', $competition->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $competition->title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $competition->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $competition->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Reg. Deadline <span class="text-danger">*</span></label>
                        <input type="date" name="registration_deadline" class="form-control" required value="{{ old('registration_deadline', $competition->registration_deadline->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" required value="{{ old('start_date', $competition->start_date->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" required value="{{ old('end_date', $competition->end_date->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Update Competition</button>
                    <a href="{{ route('admin.competitions') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
