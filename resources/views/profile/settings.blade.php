@extends('layouts.dashboard-layout')
@section('page-title', 'Profile Settings')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-premium p-4 mb-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-person-circle text-primary me-2"></i>Profile Information</h5>
            <form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-3 text-center">
                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle border mb-3" style="width:100px;height:100px;object-fit:cover;" alt="Photo">
                        <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Bio</label>
                                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Facebook</label>
                                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $user->facebook) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Twitter</label>
                                <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $user->twitter) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">LinkedIn</label>
                                <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $user->linkedin) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">GitHub</label>
                                <input type="url" name="github" class="form-control" value="{{ old('github', $user->github) }}">
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->role === 'student')
                    <hr class="my-4">
                    <h6 class="fw-bold text-navy mb-3">Student Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Institute</label>
                            <input type="text" name="institute" class="form-control" value="{{ old('institute', $user->studentProfile?->institute ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Class</label>
                            <input type="text" name="class_name" class="form-control" value="{{ old('class_name', $user->studentProfile?->class_name ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Department</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $user->studentProfile?->department ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Semester</label>
                            <input type="text" name="semester" class="form-control" value="{{ old('semester', $user->studentProfile?->semester ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Skills</label>
                            <input type="text" name="skills" class="form-control" value="{{ old('skills', $user->studentProfile?->skills ?? '') }}">
                        </div>
                    </div>
                @elseif($user->role === 'company')
                    <hr class="my-4">
                    <h6 class="fw-bold text-navy mb-3">Company Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $user->companyProfile?->company_name ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Website</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website', $user->companyProfile?->website ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->companyProfile?->address ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $user->companyProfile?->description ?? '') }}</textarea>
                        </div>
                    </div>
                @elseif($user->role === 'teacher')
                    <hr class="my-4">
                    <h6 class="fw-bold text-navy mb-3">Teacher Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Department</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $user->teacherProfile?->department ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Designation</label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation', $user->teacherProfile?->designation ?? '') }}">
                        </div>
                    </div>
                @elseif($user->role === 'club_leader')
                    <hr class="my-4">
                    <h6 class="fw-bold text-navy mb-3">Club Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Club Name</label>
                            <input type="text" name="club_name" class="form-control" value="{{ old('club_name', $user->clubLeaderProfile?->club_name ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Club Description</label>
                            <textarea name="club_description" class="form-control" rows="3">{{ old('club_description', $user->clubLeaderProfile?->club_description ?? '') }}</textarea>
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <button type="submit" class="btn btn-premium px-4">Save Profile</button>
                </div>
            </form>
        </div>

        <div class="card card-premium p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="bi bi-shield-lock text-primary me-2"></i>Change Password</h5>
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">New Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-premium-outline px-4">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
