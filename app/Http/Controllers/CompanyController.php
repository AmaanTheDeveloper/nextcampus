<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Category;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    use NotifiesUsers;
    /**
     * Display company dashboard.
     */
    public function dashboard()
    {
        $companyId = auth()->id();
        $internshipsCount = Internship::where('company_id', $companyId)->count();
        $applicationsCount = InternshipApplication::whereHas('internship', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->count();

        $shortlistedCount = InternshipApplication::where('status', 'shortlisted')
            ->whereHas('internship', function($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->count();

        $recentPostings = Internship::where('company_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('compony.dashboard', compact(
            'internshipsCount', 'applicationsCount', 'shortlistedCount', 'recentPostings'
        ));
    }

    /**
     * List company internships.
     */
    public function index()
    {
        $internships = Internship::withCount('applications')
            ->where('company_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compony.internships.index', compact('internships'));
    }

    /**
     * Form to post internship.
     */
    public function create()
    {
        $categories = Category::where('type', 'internship')->orderBy('name')->get();

        return view('compony.internships.create', compact('categories'));
    }

    /**
     * Store new internship.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'skills' => 'nullable|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'deadline' => 'required|date|after_or_equal:today',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Internship::create([
            'company_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'skills' => $request->skills,
            'location' => $request->location,
            'salary' => $request->salary,
            'deadline' => $request->deadline,
            'category_id' => $request->category_id,
            'status' => 'active',
            'approval_status' => 'pending',
            'is_published' => false,
        ]);

        $this->notifyAdmins(
            'New Internship Pending Review',
            auth()->user()->name . ' posted a new internship: ' . $request->title,
            route('admin.internships')
        );

        return redirect()->route('company.internships.index')
            ->with('success', 'Internship submitted for admin approval!');
    }

    /**
     * Edit internship form.
     */
    public function edit($id)
    {
        $internship = Internship::where('company_id', auth()->id())->findOrFail($id);
        $categories = Category::where('type', 'internship')->orderBy('name')->get();

        return view('compony.internships.edit', compact('internship', 'categories'));
    }

    /**
     * Update internship details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'skills' => 'nullable|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $internship = Internship::where('company_id', auth()->id())->findOrFail($id);
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
            'approval_status' => 'pending',
            'is_published' => false,
        ]);

        $this->notifyAdmins(
            'Internship Updated — Pending Review',
            auth()->user()->name . ' updated internship: ' . $request->title,
            route('admin.internships')
        );

        return redirect()->route('company.internships.index')
            ->with('success', 'Internship updated and sent for admin review.');
    }

    /**
     * Delete internship.
     */
    public function destroy($id)
    {
        $internship = Internship::where('company_id', auth()->id())->findOrFail($id);
        $internship->delete();

        return redirect()->route('company.internships.index')->with('success', 'Internship deleted successfully!');
    }

    /**
     * List applicants for posted roles.
     */
    public function applications()
    {
        $applications = InternshipApplication::with(['internship', 'student'])
            ->whereHas('internship', function($q) {
                $q->where('company_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compony.applications', compact('applications'));
    }

    /**
     * Shortlist candidate.
     */
    public function shortlist($id)
    {
        $app = InternshipApplication::with('student', 'internship')->whereHas('internship', function($q) {
            $q->where('company_id', auth()->id());
        })->findOrFail($id);

        $app->update(['status' => 'shortlisted']);

        $this->notifyUser(
            $app->student,
            'Company Acceptance',
            'You have been shortlisted for ' . $app->internship->title,
            route('student.internships')
        );

        return redirect()->back()->with('success', 'Applicant shortlisted successfully!');
    }

    /**
     * Reject candidate.
     */
    public function reject($id)
    {
        $app = InternshipApplication::with('student', 'internship')->whereHas('internship', function($q) {
            $q->where('company_id', auth()->id());
        })->findOrFail($id);

        $app->update(['status' => 'rejected']);

        $this->notifyUser(
            $app->student,
            'Company Rejection',
            'Your application for ' . $app->internship->title . ' was not selected.',
            route('student.internships')
        );

        return redirect()->back()->with('success', 'Applicant rejected.');
    }

    /**
     * Download applicant resume securely.
     */
    public function downloadResume($id)
    {
        $app = InternshipApplication::whereHas('internship', function ($q) {
            $q->where('company_id', auth()->id());
        })->findOrFail($id);

        $path = storage_path('app/public/' . $app->resume_path);

        if (! file_exists($path)) {
            abort(404, 'Resume file not found.');
        }

        return response()->download($path, basename($app->resume_path));
    }
}
