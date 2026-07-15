@extends('layouts.dashboard-layout')

@section('page-title', 'Resume Builder')

@section('content')
<div class="row g-4">
    <!-- Resume Form -->
    <div class="col-lg-8">
        <form action="{{ route('student.resume.update') }}" method="POST" id="resumeForm">
            @csrf

            <!-- Personal Info -->
            <div class="card card-premium p-4 mb-4">
                <h5 class="fw-bold text-navy mb-4"><i class="bi bi-person-circle text-primary me-2"></i>Personal Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Full Name</label>
                        <input type="text" name="personal_info[name]" class="form-control" value="{{ $resume->personal_info['name'] ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Email Address</label>
                        <input type="email" name="personal_info[email]" class="form-control" value="{{ $resume->personal_info['email'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">Phone Number</label>
                        <input type="text" name="personal_info[phone]" class="form-control" value="{{ $resume->personal_info['phone'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">City / Address</label>
                        <input type="text" name="personal_info[address]" class="form-control" value="{{ $resume->personal_info['address'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">LinkedIn / Portfolio Website</label>
                        <input type="text" name="personal_info[website]" class="form-control" placeholder="https://linkedin.com/in/yourname" value="{{ $resume->personal_info['website'] ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label text-secondary small fw-bold">Professional Summary</label>
                        <textarea name="personal_info[summary]" class="form-control" rows="3" placeholder="A brief overview of your skills, experience, and career goals...">{{ $resume->personal_info['summary'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Education -->
            <div class="card card-premium p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-navy mb-0"><i class="bi bi-mortarboard text-primary me-2"></i>Education</h5>
                    <button type="button" class="btn btn-sm btn-premium-outline" onclick="addEducation()"><i class="bi bi-plus-lg me-1"></i>Add</button>
                </div>
                <div id="education-list">
                    @if(!empty($resume->education))
                        @foreach($resume->education as $i => $edu)
                        <div class="p-3 border rounded-3 mb-3 bg-light edu-item">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Degree / Program</label>
                                    <input type="text" name="education[{{ $i }}][degree]" class="form-control" value="{{ $edu['degree'] ?? '' }}" placeholder="e.g. Bachelor of CS">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Institution</label>
                                    <input type="text" name="education[{{ $i }}][school]" class="form-control" value="{{ $edu['school'] ?? '' }}" placeholder="e.g. COMSATS University">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-secondary fw-bold">Start Year</label>
                                    <input type="text" name="education[{{ $i }}][start]" class="form-control" value="{{ $edu['start'] ?? '' }}" placeholder="2021">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-secondary fw-bold">End Year</label>
                                    <input type="text" name="education[{{ $i }}][end]" class="form-control" value="{{ $edu['end'] ?? '' }}" placeholder="2025 or Present">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-secondary fw-bold">Grade / CGPA</label>
                                    <input type="text" name="education[{{ $i }}][grade]" class="form-control" value="{{ $edu['grade'] ?? '' }}" placeholder="3.5 / 4.0">
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.closest('.edu-item').remove()"><i class="bi bi-trash3 me-1"></i>Remove</button>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Skills -->
            <div class="card card-premium p-4 mb-4">
                <h5 class="fw-bold text-navy mb-4"><i class="bi bi-tools text-primary me-2"></i>Technical Skills</h5>
                <div id="skills-list" class="d-flex flex-wrap gap-2 mb-3">
                    @if(!empty($resume->skills))
                        @foreach($resume->skills as $i => $skill)
                            <div class="d-flex align-items-center gap-1 border rounded-pill px-3 py-1 bg-light">
                                <input type="text" name="skills[{{ $i }}]" class="border-0 bg-transparent small fw-bold text-navy" value="{{ $skill }}" style="width: 100px;">
                                <button type="button" class="btn-close btn-close-sm" onclick="this.closest('div').remove()" style="font-size: 0.5rem;"></button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <input type="text" id="newSkill" class="form-control" placeholder="Type a skill and press Add..." style="max-width: 250px;">
                    <button type="button" class="btn btn-premium-outline btn-sm" onclick="addSkill()"><i class="bi bi-plus-lg"></i> Add Skill</button>
                </div>
            </div>

            <!-- Experience -->
            <div class="card card-premium p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-navy mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Work Experience</h5>
                    <button type="button" class="btn btn-sm btn-premium-outline" onclick="addExperience()"><i class="bi bi-plus-lg me-1"></i>Add</button>
                </div>
                <div id="experience-list">
                    @if(!empty($resume->experience))
                        @foreach($resume->experience as $i => $exp)
                        <div class="p-3 border rounded-3 mb-3 bg-light exp-item">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Job Role</label>
                                    <input type="text" name="experience[{{ $i }}][role]" class="form-control" value="{{ $exp['role'] ?? '' }}" placeholder="e.g. Junior Developer">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Company Name</label>
                                    <input type="text" name="experience[{{ $i }}][company]" class="form-control" value="{{ $exp['company'] ?? '' }}" placeholder="e.g. TechCorp Pvt Ltd">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-secondary fw-bold">Start</label>
                                    <input type="text" name="experience[{{ $i }}][start]" class="form-control" value="{{ $exp['start'] ?? '' }}" placeholder="Jan 2023">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-secondary fw-bold">End</label>
                                    <input type="text" name="experience[{{ $i }}][end]" class="form-control" value="{{ $exp['end'] ?? '' }}" placeholder="Dec 2023 or Present">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-secondary fw-bold">Description</label>
                                    <textarea name="experience[{{ $i }}][description]" class="form-control" rows="2" placeholder="Describe your key responsibilities...">{{ $exp['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.closest('.exp-item').remove()"><i class="bi bi-trash3 me-1"></i>Remove</button>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Save Button -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-premium px-5 py-2"><i class="bi bi-floppy2 me-2"></i>Save Resume</button>
                <a href="{{ route('student.resume.download') }}" class="btn btn-danger px-5 py-2"><i class="bi bi-file-earmark-pdf me-2"></i>Download PDF</a>
            </div>

            <input type="hidden" name="title" value="{{ $resume->title ?? 'My Main Resume' }}">
        </form>
    </div>

    <!-- Preview Tips -->
    <div class="col-lg-4">
        <div class="card card-premium p-4 sticky-top" style="top: 80px;">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>Resume Tips</h5>
            <ul class="list-unstyled d-flex flex-column gap-2">
                <li class="small text-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Keep your professional summary under 3 lines</li>
                <li class="small text-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>List skills relevant to the job you're applying for</li>
                <li class="small text-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Use action verbs (Built, Developed, Led) in experience</li>
                <li class="small text-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Add your GitHub, LinkedIn, or Portfolio link</li>
                <li class="small text-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Keep education and experience in reverse chronological order</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let eduCount = {{ count($resume->education ?? []) }};
let expCount = {{ count($resume->experience ?? []) }};
let skillCount = {{ count($resume->skills ?? []) }};

function addEducation() {
    const list = document.getElementById('education-list');
    const div = document.createElement('div');
    div.className = 'p-3 border rounded-3 mb-3 bg-light edu-item';
    div.innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small text-secondary fw-bold">Degree / Program</label>
                <input type="text" name="education[${eduCount}][degree]" class="form-control" placeholder="e.g. Bachelor of CS">
            </div>
            <div class="col-md-6">
                <label class="form-label small text-secondary fw-bold">Institution</label>
                <input type="text" name="education[${eduCount}][school]" class="form-control" placeholder="e.g. COMSATS University">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-secondary fw-bold">Start Year</label>
                <input type="text" name="education[${eduCount}][start]" class="form-control" placeholder="2021">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-secondary fw-bold">End Year</label>
                <input type="text" name="education[${eduCount}][end]" class="form-control" placeholder="2025 or Present">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-secondary fw-bold">Grade / CGPA</label>
                <input type="text" name="education[${eduCount}][grade]" class="form-control" placeholder="3.5 / 4.0">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.closest('.edu-item').remove()"><i class="bi bi-trash3 me-1"></i>Remove</button>
    `;
    list.appendChild(div);
    eduCount++;
}

function addExperience() {
    const list = document.getElementById('experience-list');
    const div = document.createElement('div');
    div.className = 'p-3 border rounded-3 mb-3 bg-light exp-item';
    div.innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small text-secondary fw-bold">Job Role</label>
                <input type="text" name="experience[${expCount}][role]" class="form-control" placeholder="e.g. Junior Developer">
            </div>
            <div class="col-md-6">
                <label class="form-label small text-secondary fw-bold">Company Name</label>
                <input type="text" name="experience[${expCount}][company]" class="form-control" placeholder="e.g. TechCorp Pvt Ltd">
            </div>
            <div class="col-md-5">
                <label class="form-label small text-secondary fw-bold">Start</label>
                <input type="text" name="experience[${expCount}][start]" class="form-control" placeholder="Jan 2023">
            </div>
            <div class="col-md-5">
                <label class="form-label small text-secondary fw-bold">End</label>
                <input type="text" name="experience[${expCount}][end]" class="form-control" placeholder="Dec 2023 or Present">
            </div>
            <div class="col-12">
                <label class="form-label small text-secondary fw-bold">Description</label>
                <textarea name="experience[${expCount}][description]" class="form-control" rows="2" placeholder="Describe your key responsibilities..."></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.closest('.exp-item').remove()"><i class="bi bi-trash3 me-1"></i>Remove</button>
    `;
    list.appendChild(div);
    expCount++;
}

function addSkill() {
    const input = document.getElementById('newSkill');
    const val = input.value.trim();
    if (!val) return;
    const list = document.getElementById('skills-list');
    const div = document.createElement('div');
    div.className = 'd-flex align-items-center gap-1 border rounded-pill px-3 py-1 bg-light';
    div.innerHTML = `
        <input type="text" name="skills[${skillCount}]" class="border-0 bg-transparent small fw-bold text-navy" value="${val}" style="width: 100px;">
        <button type="button" class="btn-close" onclick="this.closest('div').remove()" style="font-size: 0.5rem;"></button>
    `;
    list.appendChild(div);
    skillCount++;
    input.value = '';
    input.focus();
}

document.getElementById('newSkill').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); addSkill(); }
});
</script>
@endsection
