@extends('layouts.dashboard-layout')
@section('page-title', 'Upload Notes')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Study Notes</h5>
            <form action="{{ route('teacher.notes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Chapter 5: OOP Concepts" required value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Brief description of what these notes cover...">{{ old('description') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control" placeholder="e.g. Data Structures" required value="{{ old('subject') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Semester <span class="text-danger">*</span></label>
                        <select name="semester" class="form-select" required>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="Semester {{ $i }}">Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label text-secondary small fw-bold">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">PDF File <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control" accept="application/pdf" required>
                    <div class="form-text">Maximum file size: 10MB. PDF format only.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Upload Notes</button>
                    <a href="{{ route('teacher.notes.index') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
