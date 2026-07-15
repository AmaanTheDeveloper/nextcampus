@extends('layouts.dashboard-layout')

@section('page-title', 'Event Gallery')

@section('content')
<div class="row g-4">
    <!-- Upload Gallery Image Form -->
    <div class="col-lg-4">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-upload text-primary me-2"></i>Upload Gallery Images</h5>
            <form action="{{ route('club_leader.events.gallery.upload', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">Select Images <span class="text-danger">*</span></label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <div class="form-text">You can select multiple files. Max size 5MB per image.</div>
                </div>
                <button type="submit" class="btn btn-premium w-100"><i class="bi bi-cloud-upload me-1"></i>Upload Images</button>
            </form>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="col-lg-8">
        <div class="card card-premium p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-images text-primary me-2"></i>Event Gallery</h5>
                    <p class="text-secondary small mb-0">Event: <strong>{{ $event->title }}</strong></p>
                </div>
                <a href="{{ route('club_leader.events.index') }}" class="btn btn-premium-outline btn-sm"><i class="bi bi-arrow-left me-1"></i>Back to Events</a>
            </div>

            @if($event->gallery->isEmpty())
                <div class="text-center py-5">
                    <div class="fs-1 text-secondary"><i class="bi bi-images"></i></div>
                    <p class="text-secondary mt-2">No images uploaded for this event's gallery yet.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($event->gallery as $img)
                        <div class="col-md-4 col-sm-6">
                            <div class="position-relative border rounded-3 overflow-hidden group">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Event Gallery Image" class="w-100 object-fit-cover" style="height: 150px;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <form action="{{ route('club_leader.events.gallery.delete', $img->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm p-1 rounded-circle line-height-1" title="Delete Image">
                                            <i class="bi bi-trash-fill fs-6"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
