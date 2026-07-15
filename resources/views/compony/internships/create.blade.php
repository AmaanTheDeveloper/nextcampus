@extends('layouts.dashboard-layout')
@section('page-title', 'Post Internship')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-plus-circle text-primary me-2"></i>Post New Internship</h5>
            <form action="{{ route('company.internships.store') }}" method="POST">
                @csrf
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
                    <label class="form-label text-secondary small fw-bold">Internship Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Frontend Developer Intern" required value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Describe the role, responsibilities, and what the intern will learn..." required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="3" placeholder="Academic or experience requirements...">{{ old('requirements') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Skills Required <span class="text-muted fw-normal">(comma separated)</span></label>
                    <input type="text" name="skills" class="form-control" placeholder="e.g. Laravel, Vue.js, MySQL" value="{{ old('skills') }}">
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Remote / Karachi" required value="{{ old('location') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Stipend/Salary</label>
                        <input type="text" name="salary" class="form-control" placeholder="e.g. Rs. 15,000/month or Unpaid" value="{{ old('salary') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Application Deadline <span class="text-danger">*</span></label>
                        <input type="date" name="deadline" class="form-control" required value="{{ old('deadline') }}">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Post Internship</button>
                    <a href="{{ route('company.internships.index') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
