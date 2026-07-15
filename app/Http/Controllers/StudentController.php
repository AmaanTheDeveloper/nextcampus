<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Competition;
use App\Models\CompetitionRegistration;
use App\Models\Scholarship;
use App\Models\ScholarshipBookmark;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Note;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use NotifiesUsers;
    /**
     * Display student dashboard landing summary.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $appliedInternshipsCount = InternshipApplication::where('student_id', $user->id)->count();
        $registeredCompetitionsCount = CompetitionRegistration::where('student_id', $user->id)->count();
        $registeredEventsCount = EventRegistration::where('student_id', $user->id)->count();
        $certificatesCount = Certificate::where('student_id', $user->id)->count();

        $recentApplications = InternshipApplication::with(['internship.company.companyProfile'])
            ->where('student_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $upcomingEvents = Event::whereHas('registrations', function($q) use ($user) {
                $q->where('student_id', $user->id);
            })
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        $latestNotes = Note::with('uploader')
            ->where('is_published', true)
            ->where('approval_status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('student.dashboard', compact(
            'appliedInternshipsCount', 'registeredCompetitionsCount', 'registeredEventsCount', 'certificatesCount',
            'recentApplications', 'upcomingEvents', 'latestNotes'
        ));
    }

    /**
     * List all applied internships.
     */
    public function internships()
    {
        $applications = InternshipApplication::with(['internship.company.companyProfile'])
            ->where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.internships', compact('applications'));
    }

    /**
     * Apply for an internship (process file upload and create record).
     */
    public function applyInternship(Request $request, $id)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120',
            'cover_letter' => 'nullable|string'
        ]);

        $internship = Internship::where('approval_status', 'approved')
            ->where('is_published', true)
            ->findOrFail($id);

        // Check if already applied
        $existing = InternshipApplication::where('internship_id', $id)
            ->where('student_id', auth()->id())
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already applied for this internship.');
        }

        // Store Resume File
        $path = $request->file('resume')->store('resumes', 'public');

        InternshipApplication::create([
            'internship_id' => $id,
            'student_id' => auth()->id(),
            'resume_path' => $path,
            'cover_letter' => $request->cover_letter,
            'status' => 'applied'
        ]);

        $this->notifyAdmins(
            'New Internship Application',
            auth()->user()->name . ' applied for ' . $internship->title,
            route('admin.applications')
        );

        return redirect()->route('student.internships')->with('success', 'Applied successfully!');
    }

    /**
     * List registered competitions.
     */
    public function competitions()
    {
        $registrations = CompetitionRegistration::with('competition')
            ->where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.competitions', compact('registrations'));
    }

    /**
     * Register student for a competition.
     */
    public function registerCompetition($id)
    {
        $competition = Competition::findOrFail($id);

        if ($competition->registration_deadline && $competition->registration_deadline->isPast()) {
            return redirect()->back()->with('error', 'Registration for this competition has closed.');
        }

        $existing = CompetitionRegistration::where('competition_id', $id)
            ->where('student_id', auth()->id())
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You are already registered.');
        }

        CompetitionRegistration::create([
            'competition_id' => $id,
            'student_id' => auth()->id(),
            'status' => 'registered'
        ]);

        $this->notifyAdmins(
            'Competition Registration',
            auth()->user()->name . ' registered for ' . $competition->title,
            route('admin.competitions')
        );

        return redirect()->route('student.competitions')->with('success', 'Registered successfully!');
    }

    /**
     * Bookmark a scholarship.
     */
    public function bookmarkScholarship($id)
    {
        ScholarshipBookmark::firstOrCreate([
            'scholarship_id' => $id,
            'student_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Scholarship bookmarked!');
    }

    /**
     * Unbookmark a scholarship.
     */
    public function unbookmarkScholarship($id)
    {
        ScholarshipBookmark::where('scholarship_id', $id)
            ->where('student_id', auth()->id())
            ->delete();

        return redirect()->back()->with('success', 'Bookmark removed!');
    }

    /**
     * List bookmarked scholarships.
     */
    public function bookmarks()
    {
        $bookmarks = ScholarshipBookmark::with('scholarship')
            ->where('student_id', auth()->id())
            ->get();

        return view('student.bookmarks', compact('bookmarks'));
    }

    /**
     * Certificate Vault management.
     */
    public function vault()
    {
        $certificates = Certificate::where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.vault', compact('certificates'));
    }

    public function uploadCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Academic,Extracurricular,Work,Professional',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'issue_date' => 'nullable|date'
        ]);

        $path = $request->file('file')->store('certificates', 'public');

        Certificate::create([
            'student_id' => auth()->id(),
            'title' => $request->title,
            'category' => $request->category,
            'file_path' => $path,
            'issue_date' => $request->issue_date
        ]);

        $this->notifyUser(
            auth()->user(),
            'Certificate Uploaded',
            'Your certificate "' . $request->title . '" was saved to your vault.',
            route('student.vault')
        );

        return redirect()->back()->with('success', 'Certificate uploaded successfully!');
    }

    public function deleteCertificate($id)
    {
        $cert = Certificate::where('student_id', auth()->id())->findOrFail($id);
        Storage::disk('public')->delete($cert->file_path);
        $cert->delete();

        return redirect()->back()->with('success', 'Certificate deleted successfully!');
    }

    /**
     * Register student for a campus event.
     */
    public function registerEvent($id)
    {
        $event = Event::findOrFail($id);

        if ($event->registration_deadline && $event->registration_deadline->isPast()) {
            return redirect()->back()->with('error', 'Registration has closed for this event.');
        }

        EventRegistration::firstOrCreate([
            'event_id' => $id,
            'student_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Registered for the event successfully!');
    }

    /**
     * Download Note and increment downloads count.
     */
    public function downloadNote($id)
    {
        if (! in_array(auth()->user()->role, ['student', 'teacher', 'admin'])) {
            abort(403, 'You are not allowed to download notes.');
        }

        $note = Note::where('is_published', true)
            ->where('approval_status', 'approved')
            ->findOrFail($id);
        $note->increment('downloads_count');

        $path = storage_path('app/public/' . $note->file_path);
        if (!file_exists($path)) {
            abort(404, 'File not found on system.');
        }

        return response()->download($path);
    }
}
