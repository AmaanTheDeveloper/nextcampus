@extends('layouts.dashboard-layout')

@section('page-title', 'Edit Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium p-5">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-pencil text-primary me-2"></i>Edit Event Details</h5>
            <form action="{{ route('club_leader.events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Event Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Annual Web Development Hackathon" required value="{{ old('title', $event->title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Detail description..." required>{{ old('description', $event->description) }}</textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Event Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="Seminar" {{ $event->type === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Workshop" {{ $event->type === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="Bootcamp" {{ $event->type === 'Bootcamp' ? 'selected' : '' }}>Bootcamp</option>
                            <option value="Hackathon" {{ $event->type === 'Hackathon' ? 'selected' : '' }}>Hackathon</option>
                            <option value="Guest Lecture" {{ $event->type === 'Guest Lecture' ? 'selected' : '' }}>Guest Lecture</option>
                            <option value="Social Event" {{ $event->type === 'Social Event' ? 'selected' : '' }}>Social Event</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Auditorium 2" required value="{{ old('location', $event->location) }}">
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Event Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="event_date" class="form-control" required value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Registration Deadline <span class="text-danger">*</span></label>
                        <input type="date" name="registration_deadline" class="form-control" required value="{{ old('registration_deadline', $event->registration_deadline->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-premium px-5">Save Changes</button>
                    <a href="{{ route('club_leader.events.index') }}" class="btn btn-premium-outline px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
