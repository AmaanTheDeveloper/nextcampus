<div class="position-sticky pt-3">
    <div class="px-4 py-3 border-bottom border-secondary mb-3 d-none d-md-block">
        <h4 class="text-white fw-bold mb-1"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>NextCampus</h4>
        <span class="badge bg-primary small text-uppercase">{{ auth()->user()->role }}</span>
    </div>

    @php
        $dashboardRoute = match(auth()->user()->role) {
            'admin' => 'admin.dashboard',
            'student' => 'student.dashboard',
            'teacher' => 'teacher.dashboard',
            'company' => 'company.dashboard',
            'club_leader' => 'club_leader.dashboard',
            default => 'dashboard',
        };
        $dashboardPath = match(auth()->user()->role) {
            'admin' => 'admin/dashboard*',
            'student' => 'student/dashboard*',
            'teacher' => 'teacher/dashboard*',
            'company' => 'company/dashboard*',
            'club_leader' => 'club-leader/dashboard*',
            default => 'dashboard',
        };
    @endphp

    <ul class="nav flex-column gap-1 pb-3">
        <li class="nav-item">
            <a class="nav-link {{ Request::is($dashboardPath) ? 'active' : '' }}" href="{{ route($dashboardRoute) }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        @if(auth()->user()->role === 'student')
            <li class="nav-item"><a class="nav-link {{ Request::is('student/internships*') ? 'active' : '' }}" href="{{ route('student.internships') }}"><i class="bi bi-briefcase"></i> Applied Internships</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/competitions*') ? 'active' : '' }}" href="{{ route('student.competitions') }}"><i class="bi bi-trophy"></i> My Competitions</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/assignments*') ? 'active' : '' }}" href="{{ route('student.assignments.index') }}"><i class="bi bi-journal-check"></i> Assignments & Tests</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/bookmarks*') ? 'active' : '' }}" href="{{ route('student.bookmarks') }}"><i class="bi bi-bookmark-fill"></i> Bookmarks</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/resume*') ? 'active' : '' }}" href="{{ route('student.resume') }}"><i class="bi bi-file-earmark-person"></i> Resume Builder</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/vault*') ? 'active' : '' }}" href="{{ route('student.vault') }}"><i class="bi bi-shield-lock"></i> Certificate Vault</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/notes*') ? 'active' : '' }}" href="{{ route('student.notes') }}"><i class="bi bi-file-earmark-pdf"></i> Download Notes</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('student/forum*') ? 'active' : '' }}" href="{{ route('student.forum') }}"><i class="bi bi-chat-square-text"></i> Discussion Forum</a></li>
        @endif

        @if(auth()->user()->role === 'teacher')
            <li class="nav-item"><a class="nav-link {{ Request::is('teacher/notes/upload') ? 'active' : '' }}" href="{{ route('teacher.notes.create') }}"><i class="bi bi-cloud-upload"></i> Upload Notes</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('teacher/notes') && !Request::is('teacher/notes/upload') ? 'active' : '' }}" href="{{ route('teacher.notes.index') }}"><i class="bi bi-file-earmark-pdf"></i> Manage Notes</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('teacher/assignments*') ? 'active' : '' }}" href="{{ route('teacher.assignments.index') }}"><i class="bi bi-journal-check"></i> Assignments & Tests</a></li>
        @endif

        @if(auth()->user()->role === 'company')
            <li class="nav-item"><a class="nav-link {{ Request::is('company/internships/create') ? 'active' : '' }}" href="{{ route('company.internships.create') }}"><i class="bi bi-plus-circle"></i> Post Internship</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('company/internships') && !Request::is('company/internships/create') ? 'active' : '' }}" href="{{ route('company.internships.index') }}"><i class="bi bi-briefcase"></i> My Internships</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('company/applications*') ? 'active' : '' }}" href="{{ route('company.applications') }}"><i class="bi bi-people"></i> Applicants</a></li>
        @endif

        @if(auth()->user()->role === 'club_leader')
            <li class="nav-item"><a class="nav-link {{ Request::is('club-leader/events/create') ? 'active' : '' }}" href="{{ route('club_leader.events.create') }}"><i class="bi bi-calendar-plus"></i> Create Event</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('club-leader/events*') && !Request::is('club-leader/events/create') ? 'active' : '' }}" href="{{ route('club_leader.events.index') }}"><i class="bi bi-calendar-event"></i> Manage Events</a></li>
        @endif

        @if(auth()->user()->role === 'admin')
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/approvals*') ? 'active' : '' }}" href="{{ route('admin.approvals') }}"><i class="bi bi-person-check"></i> Pending Approvals</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}"><i class="bi bi-people"></i> Manage Users</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/internships*') ? 'active' : '' }}" href="{{ route('admin.internships') }}"><i class="bi bi-briefcase"></i> Internships</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/applications*') ? 'active' : '' }}" href="{{ route('admin.applications') }}"><i class="bi bi-file-person"></i> Applications</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/competitions*') ? 'active' : '' }}" href="{{ route('admin.competitions') }}"><i class="bi bi-trophy"></i> Competitions</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/scholarships*') ? 'active' : '' }}" href="{{ route('admin.scholarships') }}"><i class="bi bi-award"></i> Scholarships</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/events*') ? 'active' : '' }}" href="{{ route('admin.events') }}"><i class="bi bi-calendar-event"></i> Events</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/notes*') ? 'active' : '' }}" href="{{ route('admin.notes') }}"><i class="bi bi-file-earmark-pdf"></i> Notes</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/assignments*') ? 'active' : '' }}" href="{{ route('admin.assignments') }}"><i class="bi bi-journal-check"></i> Assignments</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories') }}"><i class="bi bi-tags"></i> Categories</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.logs') }}"><i class="bi bi-activity"></i> Activity Logs</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-bar-graph"></i> Reports</a></li>
        @endif

        <li class="nav-item"><a class="nav-link {{ Request::is('profile/settings*') ? 'active' : '' }}" href="{{ route('profile.settings') }}"><i class="bi bi-gear"></i> Profile Settings</a></li>
    </ul>

    <div class="px-3 mt-3 mb-4">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-danger btn-sm w-100 py-2"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form>
    </div>
</div>
