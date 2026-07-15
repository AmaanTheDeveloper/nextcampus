<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClubLeaderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// GUEST / PUBLIC LANDING PAGES
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/guest/internships', [GuestController::class, 'internships'])->name('guest.internships');
Route::get('/guest/internships/{id}', [GuestController::class, 'internshipDetail'])->name('guest.internship.detail');

Route::get('/guest/competitions', [GuestController::class, 'competitions'])->name('guest.competitions');
Route::get('/guest/competitions/{id}', [GuestController::class, 'competitionDetail'])->name('guest.competition.detail');

Route::get('/guest/scholarships', [GuestController::class, 'scholarships'])->name('guest.scholarships');
Route::get('/guest/scholarships/{id}', [GuestController::class, 'scholarshipDetail'])->name('guest.scholarship.detail');

Route::get('/guest/notes', [GuestController::class, 'notes'])->name('guest.notes');

Route::get('/guest/events', [GuestController::class, 'events'])->name('guest.events');
Route::get('/guest/events/{id}', [GuestController::class, 'eventDetail'])->name('guest.event.detail');


// PENDING & REJECTED NOTICE PAGES
Route::get('/pending-approval', function () {
    if (auth()->check() && auth()->user()->status === 'active') {
        return redirect()->route('dashboard');
    }
    return view('auth.pending-approval');
})->middleware('auth')->name('pending.approval');

Route::get('/rejected', function () {
    return view('auth.rejected');
})->middleware('auth')->name('rejected');
Route::get('/blocked', function () { return view('auth.blocked'); })->middleware('auth')->name('blocked');

// CORE POST-LOGIN ROUTING
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // Redirect if pending/rejected
    if ($user->status === 'pending') {
        return redirect()->route('pending.approval');
    }
    if ($user->status === 'rejected') {
        return redirect()->route('rejected');
    }
    
    // Redirect based on role
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'company':
            return redirect()->route('company.dashboard');
        case 'club_leader':
            return redirect()->route('club_leader.dashboard');
        default:
            abort(403, 'Unauthorized role.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// NOTIFICATIONS READ ROUTE
Route::post('/notifications/read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back()->with('success', 'Notifications cleared!');
})->middleware('auth')->name('notifications.read');


// PROFILE SETTINGS (all authenticated roles)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.settings');
    Route::put('/profile/settings', [ProfileController::class, 'update'])->name('profile.settings.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/notes/{id}/download', [StudentController::class, 'downloadNote'])
        ->middleware('role:student,teacher,admin')
        ->name('notes.download');
});


// GOOGLE SOCIALITE LOGIN ROUTES
Route::get("/auth/google", function() {
    return Socialite::driver('google')->redirect();
})->name('googlelogin');

Route::get("/auth/google/callback", function() {
    try {
        $googleuser = Socialite::driver('google')->stateless()->user();

        $user = \App\Models\User::firstOrCreate([
            'email' => $googleuser->email,
        ], [
            'name' => $googleuser->name,
            'password' => bcrypt(Str::random(16)),
            'role' => 'student', // Default to student
            'status' => 'active',
        ]);

        if ($user->wasRecentlyCreated) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
            $user->assignRole('student');
            \App\Models\StudentProfile::create([
                'user_id' => $user->id,
                'institute' => 'Google Connected Account',
            ]);
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    } catch (\Exception $e) {
        return redirect('/')->with('error', 'Google login failed.');
    }
});


// ROLE-SPECIFIC SECURED ROUTE GROUPS

// 1. STUDENT ROUTES
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function() {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/internships', [StudentController::class, 'internships'])->name('internships');
    Route::post('/internships/{id}/apply', [StudentController::class, 'applyInternship'])->name('internship.apply');
    
    Route::get('/competitions', [StudentController::class, 'competitions'])->name('competitions');
    Route::post('/competitions/{id}/register', [StudentController::class, 'registerCompetition'])->name('competition.register');
    
    Route::get('/bookmarks', [StudentController::class, 'bookmarks'])->name('bookmarks');
    Route::post('/scholarships/{id}/bookmark', [StudentController::class, 'bookmarkScholarship'])->name('scholarship.bookmark');
    Route::delete('/scholarships/{id}/bookmark', [StudentController::class, 'unbookmarkScholarship'])->name('scholarship.unbookmark');

    Route::get('/vault', [StudentController::class, 'vault'])->name('vault');
    Route::post('/vault/upload', [StudentController::class, 'uploadCertificate'])->name('vault.upload');
    Route::delete('/vault/{id}', [StudentController::class, 'deleteCertificate'])->name('vault.delete');

    Route::get('/notes', [GuestController::class, 'notes'])->name('notes'); // Shared search notes view
    Route::get('/notes/{id}/download', [StudentController::class, 'downloadNote'])->name('note.download');

    Route::post('/events/{id}/register', [StudentController::class, 'registerEvent'])->name('event.register');

    // Resume Builder
    Route::get('/resume', [ResumeController::class, 'index'])->name('resume');
    Route::post('/resume/update', [ResumeController::class, 'update'])->name('resume.update');
    Route::get('/resume/download', [ResumeController::class, 'download'])->name('resume.download');

    // Forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum');
    Route::post('/forum/question', [ForumController::class, 'storeQuestion'])->name('forum.question.store');
    Route::get('/forum/question/{id}', [ForumController::class, 'questionDetail'])->name('forum.question.show');
    Route::post('/forum/question/{id}/answer', [ForumController::class, 'storeAnswer'])->name('forum.answer.store');

    Route::get('/assignments', [AssignmentController::class, 'studentIndex'])->name('assignments.index');
    Route::post('/assignments/submissions/{id}/submit', [AssignmentController::class, 'studentSubmit'])->name('assignments.submit');
});

// 2. TEACHER ROUTES
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function() {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/notes', [TeacherController::class, 'index'])->name('notes.index');
    Route::get('/notes/upload', [TeacherController::class, 'create'])->name('notes.create');
    Route::post('/notes', [TeacherController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{id}', [TeacherController::class, 'destroy'])->name('notes.destroy');

    Route::get('/assignments', [AssignmentController::class, 'teacherIndex'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class, 'teacherCreate'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'teacherStore'])->name('assignments.store');
    Route::get('/assignments/{id}/submissions', [AssignmentController::class, 'teacherSubmissions'])->name('assignments.submissions');
    Route::post('/submissions/{id}/grade', [AssignmentController::class, 'gradeSubmission'])->name('submissions.grade');
});

// 3. COMPANY ROUTES
Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function() {
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/internships', [CompanyController::class, 'index'])->name('internships.index');
    Route::get('/internships/create', [CompanyController::class, 'create'])->name('internships.create');
    Route::post('/internships', [CompanyController::class, 'store'])->name('internships.store');
    Route::get('/internships/{id}/edit', [CompanyController::class, 'edit'])->name('internships.edit');
    Route::put('/internships/{id}', [CompanyController::class, 'update'])->name('internships.update');
    Route::delete('/internships/{id}', [CompanyController::class, 'destroy'])->name('internships.destroy');

    Route::get('/applications', [CompanyController::class, 'applications'])->name('applications');
    Route::get('/applications/{id}/resume', [CompanyController::class, 'downloadResume'])->name('applications.resume');
    Route::post('/applications/{id}/shortlist', [CompanyController::class, 'shortlist'])->name('applications.shortlist');
    Route::post('/applications/{id}/reject', [CompanyController::class, 'reject'])->name('applications.reject');
});

// 4. CLUB LEADER ROUTES
Route::middleware(['auth', 'role:club_leader'])->prefix('club-leader')->name('club_leader.')->group(function() {
    Route::get('/dashboard', [ClubLeaderController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/events', [ClubLeaderController::class, 'index'])->name('events.index');
    Route::get('/events/create', [ClubLeaderController::class, 'create'])->name('events.create');
    Route::post('/events', [ClubLeaderController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [ClubLeaderController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [ClubLeaderController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [ClubLeaderController::class, 'destroy'])->name('events.destroy');

    Route::get('/events/{id}/registrations', [ClubLeaderController::class, 'registrations'])->name('events.registrations');
    Route::get('/events/{id}/gallery', [ClubLeaderController::class, 'gallery'])->name('events.gallery');
    Route::post('/events/{id}/gallery', [ClubLeaderController::class, 'uploadGallery'])->name('events.gallery.upload');
    Route::delete('/gallery/image/{id}', [ClubLeaderController::class, 'deleteGalleryImage'])->name('events.gallery.delete');
});

// 5. ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/approvals', [AdminController::class, 'approvals'])->name('approvals');
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{id}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::post('/users/{id}/unblock', [AdminController::class, 'unblockUser'])->name('users.unblock');

    // Admin category management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Admin direct logs view
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');

    // Admin direct report center
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/pdf', [AdminController::class, 'exportPDF'])->name('reports.pdf');
    Route::post('/reports/excel', [AdminController::class, 'exportExcel'])->name('reports.excel');

    // Admin views for viewing all listings
    Route::get('/internships', [AdminController::class, 'internships'])->name('internships');
    Route::get('/internships/{id}/edit', [AdminController::class, 'editInternship'])->name('internships.edit');
    Route::put('/internships/{id}', [AdminController::class, 'updateInternship'])->name('internships.update');
    Route::post('/internships/{id}/approve', [AdminController::class, 'approveInternship'])->name('internships.approve');
    Route::post('/internships/{id}/reject', [AdminController::class, 'rejectInternship'])->name('internships.reject');
    Route::delete('/internships/{id}', [AdminController::class, 'deleteInternship'])->name('internships.delete');

    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::get('/notes', [AdminController::class, 'notes'])->name('notes');
    Route::post('/notes/{id}/approve', [AdminController::class, 'approveNote'])->name('notes.approve');
    Route::post('/notes/{id}/reject', [AdminController::class, 'rejectNote'])->name('notes.reject');
    Route::delete('/notes/{id}', [AdminController::class, 'deleteNote'])->name('notes.delete');

    Route::get('/assignments', [AdminController::class, 'assignments'])->name('assignments');

    Route::get('/competitions', function() {
        $competitions = \App\Models\Competition::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.listings.competitions', compact('competitions'));
    })->name('competitions');
    Route::get('/scholarships', function() {
        $scholarships = \App\Models\Scholarship::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.listings.scholarships', compact('scholarships'));
    })->name('scholarships');
    Route::get('/events', function() {
        $events = \App\Models\Event::with(['creator', 'category'])->orderBy('created_at', 'desc')->get();
        return view('admin.listings.events', compact('events'));
    })->name('events');
    Route::post('/events/{id}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
    Route::post('/events/{id}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');
    // Event CRUD routes
    Route::get('/events/create', [AdminController::class, 'createEvent'])->name('events.create');
    Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}/edit', [AdminController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{id}', [AdminController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('events.delete');
    // Competition CRUD routes
    Route::get('/competitions/create', [AdminController::class, 'createCompetition'])->name('competitions.create');
    Route::post('/competitions', [AdminController::class, 'storeCompetition'])->name('competitions.store');
    Route::get('/competitions/{id}/edit', [AdminController::class, 'editCompetition'])->name('competitions.edit');
    Route::put('/competitions/{id}', [AdminController::class, 'updateCompetition'])->name('competitions.update');
    Route::delete('/competitions/{id}', [AdminController::class, 'deleteCompetition'])->name('competitions.delete');
    // Scholarship CRUD routes
    Route::get('/scholarships/create', [AdminController::class, 'createScholarship'])->name('scholarships.create');
    Route::post('/scholarships', [AdminController::class, 'storeScholarship'])->name('scholarships.store');
    Route::get('/scholarships/{id}/edit', [AdminController::class, 'editScholarship'])->name('scholarships.edit');
    Route::put('/scholarships/{id}', [AdminController::class, 'updateScholarship'])->name('scholarships.update');
    Route::delete('/scholarships/{id}', [AdminController::class, 'deleteScholarship'])->name('scholarships.delete');
});
