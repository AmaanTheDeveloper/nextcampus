@extends('layouts.dashboard-layout')

@section('page-title', 'Reports & Exports')

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Export PDF Reports</h5>
            <form action="{{ route('admin.reports.pdf') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">Select Report Type</label>
                    <select name="type" class="form-select" required>
                        <option value="students">Students Report</option>
                        <option value="internships">Internships Report</option>
                        <option value="competitions">Competitions Report</option>
                        <option value="events">Events Report</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-file-pdf fs-5"></i> Download PDF Report
                </button>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>Export Excel/CSV Reports</h5>
            <form action="{{ route('admin.reports.excel') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">Select Report Type</label>
                    <select name="type" class="form-select" required>
                        <option value="students">Students Report</option>
                        <option value="internships">Internships Report</option>
                        <option value="competitions">Competitions Report</option>
                        <option value="events">Events Report</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-file-earmark-spreadsheet fs-5"></i> Download CSV Report
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
