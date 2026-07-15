@extends('layouts.dashboard-layout')
@section('page-title', 'Create Assignment / Test')
@section('content')

<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">
        <div class="card card-premium p-4">

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('teacher.assignments.store') }}" method="POST" id="assignmentForm">
                @csrf

                {{-- ---- Basic Info ---- --}}
                <h6 class="fw-bold text-navy mb-3"><i class="bi bi-journal-text text-primary me-2"></i>Assignment / Test Details</h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               required placeholder="e.g. Mid-term Test Chapter 3"
                               value="{{ old('title') }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                            <option value="test"       {{ old('type') == 'test'       ? 'selected' : '' }}>Test</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description / Instructions <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" required placeholder="Describe the task or test instructions...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               required
                               min="{{ now()->toDateString() }}"
                               value="{{ old('due_date') }}">
                        @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Total Marks <span class="text-muted fw-normal">(for tests)</span></label>
                        <input type="number" name="total_marks" min="1" max="1000"
                               class="form-control @error('total_marks') is-invalid @enderror"
                               placeholder="e.g. 100"
                               value="{{ old('total_marks') }}">
                        @error('total_marks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- ---- Assign By Class/Dept/Semester ---- --}}
                <h6 class="fw-bold text-navy mb-1"><i class="bi bi-people text-primary me-2"></i>Assign To — Class / Department / Semester</h6>
                <p class="small text-muted mb-3">Fill any combination below OR select individual students below.</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Class Name</label>
                        <input type="text" name="class_name"
                               class="form-control @error('class_name') is-invalid @enderror"
                               placeholder="e.g. CS-A"
                               value="{{ old('class_name') }}">
                        @error('class_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Department</label>
                        <input type="text" name="department"
                               class="form-control @error('department') is-invalid @enderror"
                               placeholder="e.g. Computer Science"
                               value="{{ old('department') }}">
                        @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Semester</label>
                        <input type="text" name="semester"
                               class="form-control @error('semester') is-invalid @enderror"
                               placeholder="e.g. 3rd"
                               value="{{ old('semester') }}">
                        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- ---- Individual Students ---- --}}
                <h6 class="fw-bold text-navy mb-1"><i class="bi bi-person-check text-primary me-2"></i>Or Select Individual Students</h6>
                <p class="small text-muted mb-2">Hold <kbd>Ctrl</kbd> / <kbd>Cmd</kbd> to select multiple students.</p>
                <select name="student_ids[]" class="form-select @error('student_ids') is-invalid @enderror" multiple size="8">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}"
                            {{ in_array($student->id, (array) old('student_ids', [])) ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->email }})
                        </option>
                    @endforeach
                </select>
                @error('student_ids')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                {{-- ---- Action Buttons ---- --}}
                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-premium">
                        <i class="bi bi-send me-1"></i>Assign
                    </button>
                    <a href="{{ route('teacher.assignments.index') }}" class="btn btn-premium-outline">
                        <i class="bi bi-arrow-left me-1"></i>Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
