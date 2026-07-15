@extends('layouts.dashboard-layout')

@section('page-title', 'Certificate Vault')

@section('content')
<div class="row g-4">
    <!-- Upload Form -->
    <div class="col-lg-4">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Certificate</h5>
            <form action="{{ route('student.vault.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Certificate Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. React.js Certification" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="Academic">Academic</option>
                        <option value="Extracurricular">Extracurricular</option>
                        <option value="Work">Work Experience</option>
                        <option value="Professional">Professional / Online Course</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Issue Date</label>
                    <input type="date" name="issue_date" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">Upload File <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control" accept="application/pdf,image/*" required>
                    <div class="form-text">Accepted: PDF, JPG, PNG. Max 5MB.</div>
                </div>
                <button type="submit" class="btn btn-premium w-100">Upload Certificate</button>
            </form>
        </div>
    </div>

    <!-- Certificates Grid -->
    <div class="col-lg-8">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-shield-lock text-primary me-2"></i>My Certificates ({{ $certificates->count() }})</h5>
            @if($certificates->isEmpty())
                <div class="text-center py-5">
                    <div class="fs-1 text-secondary"><i class="bi bi-shield-lock"></i></div>
                    <p class="text-secondary mt-2">No certificates uploaded yet. Add your first one!</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($certificates as $cert)
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="badge bg-primary-subtle text-primary mb-2">{{ $cert->category }}</span>
                                    <h6 class="fw-bold text-navy mb-1">{{ $cert->title }}</h6>
                                    @if($cert->issue_date)
                                        <span class="text-muted small"><i class="bi bi-calendar me-1"></i>{{ $cert->issue_date->format('M d, Y') }}</span>
                                    @endif
                                </div>
                                <div class="mt-3 d-flex gap-2">
                                    <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank" class="btn btn-sm btn-premium flex-grow-1"><i class="bi bi-eye me-1"></i>View</a>
                                    <form action="{{ route('student.vault.delete', $cert->id) }}" method="POST" onsubmit="return confirm('Delete this certificate?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
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
