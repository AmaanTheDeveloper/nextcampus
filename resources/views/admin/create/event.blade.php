@extends('layouts.dashboard-layout')
@section('page-title', 'Create Event')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-calendar-plus text-primary me-2"></i>Create New Event</h5>
            <form action="{{ route('admin.events.store') }}" method="POST">
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
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">Event Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="event_date" class="form-control" required value="{{ old('event_date') }}">
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label text-secondary small fw-bold">Registration Deadline <span class="text-danger">*</span></label>
                    <input type="date" name="registration_deadline" class="form-control" required value="{{ old('registration_deadline') }}">
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Create Event</button>
                    <a href="{{ route('admin.events') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
