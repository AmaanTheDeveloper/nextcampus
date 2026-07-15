<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Internship;
use App\Models\Competition;
use App\Models\Scholarship;
use App\Models\Event;
use App\Models\Category;
use App\Models\Note;
use App\Models\Assignment;
use App\Models\InternshipApplication;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    use NotifiesUsers;

    /**
     * Admin dashboard with analytics.
     */
    public function dashboard()
    {
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $companiesCount = User::where('role', 'company')->count();
        $activeInternships = Internship::where('status', 'active')->count();

        // Chart Data: Registrations over last 6 months
        $months = [];
        $registrations = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $registrations[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'studentsCount', 'teachersCount', 'companiesCount', 'activeInternships',
            'months', 'registrations'
        ));
    }

    /**
     * Show pending approvals for teachers and companies.
     */
    public function approvals()
    {
        $pendingUsers = User::with(['teacherProfile', 'companyProfile'])
            ->whereIn('role', ['teacher', 'company'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.approvals', compact('pendingUsers'));
    }

    /**
     * Approve user status.
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log("Approved {$user->role} account: {$user->email}");

        $this->notifyUser($user, 'Account Approved', 'Your account has been approved by admin.', route('dashboard'));

        return redirect()->back()->with('success', 'User account approved successfully!');
    }

    /**
     * Reject user status.
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log("Rejected {$user->role} account: {$user->email}");

        $this->notifyUser($user, 'Account Rejected', 'Your account registration was rejected by admin.', route('rejected'));

        return redirect()->back()->with('success', 'User account rejected.');
    }

    /**
     * Manage registered users.
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // Block a user with optional reason
    public function blockUser(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'is_blocked' => true,
            'block_message' => $request->reason ?? 'Blocked by admin.',
        ]);
        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    // Unblock a user
    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_blocked' => false,
            'block_message' => null,
        ]);
        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
// Duplicate deleteUser block removed



    /**
     * Category management.
     */
    public function categories()
    {
        $categories = Category::orderBy('type')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:competition,scholarship,note,internship,event'
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function deleteCategory($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect()->back()->with('success', 'Category deleted.');
    }

    /**
     * Activity Log view.
     */
    public function logs()
    {
        $logs = Activity::with('causer')->orderBy('created_at', 'desc')->take(200)->get();
        return view('admin.logs', compact('logs'));
    }

    /**
     * Export reports page.
     */
    public function reports()
    {
        return view('admin.reports');
    }

    /**
     * Export PDF report.
     */
    public function exportPDF(Request $request)
    {
        $type = $request->input('type'); // students, internships, competitions, events
        $data = [];
        $title = '';

        if ($type === 'students') {
            $data = User::where('role', 'student')->with('studentProfile')->get();
            $title = 'Registered Students Report';
        } elseif ($type === 'internships') {
            $data = Internship::with('company')->get();
            $title = 'Internships Opportunities Report';
        } elseif ($type === 'competitions') {
            $data = Competition::with('category')->get();
            $title = 'Competitions Listing Report';
        } elseif ($type === 'events') {
            $data = Event::get();
            $title = 'Campus Events Report';
        } else {
            return redirect()->back()->with('error', 'Invalid report type selected.');
        }

        $pdf = Pdf::loadView('admin.reports-pdf', compact('data', 'type', 'title'));
        return $pdf->download(str_replace(' ', '_', $title) . '.pdf');
    }
    

    /**
     * Export Excel report.
     */
    public function exportExcel(Request $request)
    {
        $type = $request->input('type');
        $filename = "NextCampus_{$type}_Report_" . date('Ymd_His') . ".csv";
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');

            if ($type === 'students') {
                fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Institute', 'Registered At']);
                $records = User::where('role', 'student')->with('studentProfile')->get();
                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->name,
                        $row->email,
                        $row->phone,
                        $row->studentProfile->institute ?? 'N/A',
                        $row->created_at->format('Y-m-d H:i:s')
                    ]);
                }
            } elseif ($type === 'internships') {
                fputcsv($file, ['ID', 'Title', 'Company Name', 'Location', 'Salary', 'Deadline', 'Status']);
                $records = Internship::with('company.companyProfile')->get();
                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->title,
                        $row->company->companyProfile->company_name ?? $row->company->name,
                        $row->location,
                        $row->salary ?: 'Unpaid',
                        $row->deadline->format('Y-m-d'),
                        $row->status
                    ]);
                }
            } elseif ($type === 'competitions') {
                fputcsv($file, ['ID', 'Title', 'Category', 'Deadline', 'Start Date', 'End Date']);
                $records = Competition::with('category')->get();
                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->title,
                        $row->category->name ?? 'N/A',
                        $row->registration_deadline->format('Y-m-d'),
                        $row->start_date->format('Y-m-d'),
                        $row->end_date->format('Y-m-d')
                    ]);
                }
            } elseif ($type === 'events') {
                fputcsv($file, ['ID', 'Title', 'Type', 'Location', 'Event Date', 'Deadline']);
                $records = Event::get();
                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->title,
                        $row->type,
                        $row->location,
                        $row->event_date->format('Y-m-d H:i:s'),
                        $row->registration_deadline->format('Y-m-d')
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    /**
     * Show form to create a new Event.
     */
    public function createEvent()
    {
        $categories = Category::where('type', 'event')->orderBy('name')->get();

        return view('admin.create.event', compact('categories'));
    }

    /**
     * Store a newly created Event.
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:online,offline',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'registration_deadline' => $request->registration_deadline,
            'category_id' => $request->category_id,
            'created_by' => auth()->id(),
            'approval_status' => 'approved',
            'is_published' => true,
        ]);

        return redirect()->route('admin.events')->with('success', 'Event created successfully.');
    }

    /**
     * Show form to edit an Event.
     */
    public function editEvent($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::where('type', 'event')->orderBy('name')->get();

        return view('admin.edit.event', compact('event', 'categories'));
    }

    /**
     * Update an existing Event.
     */
    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:online,offline',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'registration_deadline' => $request->registration_deadline,
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.events')->with('success', 'Event updated successfully.');
    }

    /**
     * Delete an Event.
     */
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
    }

    /**
     * Show form to create a new Competition.
     */
    public function createCompetition()
    {
        $categories = Category::where('type', 'competition')->get();
        return view('admin.create.competition', compact('categories'));
    }

    /**
     * Store a newly created Competition.
     */
    public function storeCompetition(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'registration_deadline' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Competition::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'registration_deadline' => $request->registration_deadline,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->id(),
            'is_published' => true,
        ]);

        return redirect()->route('admin.competitions')->with('success', 'Competition created successfully.');
    }

    /**
     * Show form to edit a Competition.
     */
    public function editCompetition($id)
    {
        $competition = Competition::findOrFail($id);
        $categories = Category::where('type', 'competition')->get();
        return view('admin.edit.competition', compact('competition', 'categories'));
    }

    /**
     * Update an existing Competition.
     */
    public function updateCompetition(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'registration_deadline' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $competition->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'registration_deadline' => $request->registration_deadline,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.competitions')->with('success', 'Competition updated successfully.');
    }

    /**
     * Delete a Competition.
     */
    public function deleteCompetition($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();
        return redirect()->route('admin.competitions')->with('success', 'Competition deleted successfully.');
    }

    /**
     * Show form to create a new Scholarship.
     */
    public function createScholarship()
    {
        $categories = Category::where('type', 'scholarship')->orderBy('name')->get();

        return view('admin.create.scholarship', compact('categories'));
    }

    /**
     * Store a newly created Scholarship.
     */
    public function storeScholarship(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'amount' => 'nullable|string',
            'deadline' => 'required|date',
            'official_apply_link' => 'required|url|max:500',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Scholarship::create([
            'title' => $request->title,
            'description' => $request->description,
            'eligibility' => $request->eligibility,
            'amount' => $request->amount,
            'deadline' => $request->deadline,
            'official_apply_link' => $request->official_apply_link,
            'category_id' => $request->category_id,
            'is_published' => true,
        ]);

        return redirect()->route('admin.scholarships')->with('success', 'Scholarship created successfully.');
    }

    /**
     * Show form to edit a Scholarship.
     */
    public function editScholarship($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $categories = Category::where('type', 'scholarship')->orderBy('name')->get();

        return view('admin.edit.scholarship', compact('scholarship', 'categories'));
    }

    /**
     * Update an existing Scholarship.
     */
    public function updateScholarship(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'amount' => 'nullable|string',
            'deadline' => 'required|date',
            'official_apply_link' => 'required|url|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);

        $scholarship->update([
            'title' => $request->title,
            'description' => $request->description,
            'eligibility' => $request->eligibility,
            'amount' => $request->amount,
            'deadline' => $request->deadline,
            'official_apply_link' => $request->official_apply_link,
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.scholarships')->with('success', 'Scholarship updated successfully.');
    }

    /**
     * Delete a Scholarship.
     */
    public function deleteScholarship($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();
        return redirect()->route('admin.scholarships')->with('success', 'Scholarship deleted successfully.');
    }

    public function internships()
    {
        $internships = Internship::with(['company.companyProfile', 'category'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.listings.internships', compact('internships'));
    }

    public function editInternship($id)
    {
        $internship = Internship::findOrFail($id);
        $categories = Category::where('type', 'internship')->orderBy('name')->get();

        return view('admin.edit.internship', compact('internship', 'categories'));
    }

    public function updateInternship(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'skills' => 'nullable|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);

        $internship->update([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'skills' => $request->skills,
            'location' => $request->location,
            'salary' => $request->salary,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.internships')->with('success', 'Internship updated successfully.');
    }

    public function approveInternship($id)
    {
        $internship = Internship::with('company')->findOrFail($id);
        $internship->update(['approval_status' => 'approved', 'is_published' => true]);

        if ($internship->company) {
            $this->notifyUser(
                $internship->company,
                'Internship Approved',
                "Your internship \"{$internship->title}\" has been approved.",
                route('company.internships.index')
            );
        }

        return redirect()->back()->with('success', 'Internship approved and published.');
    }

    public function rejectInternship($id)
    {
        $internship = Internship::with('company')->findOrFail($id);
        $internship->update(['approval_status' => 'rejected', 'is_published' => false]);

        if ($internship->company) {
            $this->notifyUser(
                $internship->company,
                'Internship Rejected',
                "Your internship \"{$internship->title}\" was rejected by admin.",
                route('company.internships.index')
            );
        }

        return redirect()->back()->with('success', 'Internship rejected.');
    }

    public function deleteInternship($id)
    {
        Internship::findOrFail($id)->delete();

        return redirect()->route('admin.internships')->with('success', 'Internship deleted.');
    }

    public function notes()
    {
        $notes = Note::with(['uploader', 'category'])->orderByDesc('created_at')->get();

        return view('admin.listings.notes', compact('notes'));
    }

    public function approveNote($id)
    {
        $note = Note::with('uploader')->findOrFail($id);
        $note->update(['approval_status' => 'approved', 'is_published' => true]);

        if ($note->uploader) {
            $this->notifyUser(
                $note->uploader,
                'Note Approved',
                "Your note \"{$note->title}\" has been approved.",
                route('teacher.notes.index')
            );
        }

        return redirect()->back()->with('success', 'Note approved and published.');
    }

    public function rejectNote($id)
    {
        $note = Note::with('uploader')->findOrFail($id);
        $note->update(['approval_status' => 'rejected', 'is_published' => false]);

        if ($note->uploader) {
            $this->notifyUser(
                $note->uploader,
                'Note Rejected',
                "Your note \"{$note->title}\" was rejected by admin.",
                route('teacher.notes.index')
            );
        }

        return redirect()->back()->with('success', 'Note rejected.');
    }

    public function deleteNote($id)
    {
        Note::findOrFail($id)->delete();

        return redirect()->route('admin.notes')->with('success', 'Note deleted.');
    }

    public function approveEvent($id)
    {
        $event = Event::with('creator')->findOrFail($id);
        $event->update(['approval_status' => 'approved', 'is_published' => true]);

        if ($event->creator) {
            $this->notifyUser(
                $event->creator,
                'Event Approved',
                "Your event \"{$event->title}\" has been approved.",
                route('club_leader.events.index')
            );
        }

        return redirect()->back()->with('success', 'Event approved.');
    }

    public function rejectEvent($id)
    {
        $event = Event::with('creator')->findOrFail($id);
        $event->update(['approval_status' => 'rejected', 'is_published' => false]);

        if ($event->creator) {
            $this->notifyUser(
                $event->creator,
                'Event Rejected',
                "Your event \"{$event->title}\" was rejected by admin.",
                route('club_leader.events.index')
            );
        }

        return redirect()->back()->with('success', 'Event rejected.');
    }

    public function applications()
    {
        $applications = InternshipApplication::with(['internship.company', 'student'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.listings.applications', compact('applications'));
    }

    public function assignments()
    {
        $assignments = Assignment::with('teacher')->withCount('submissions')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.listings.assignments', compact('assignments'));
    }
}