<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Internship;
use App\Models\Competition;
use App\Models\Scholarship;
use App\Models\Event;
use App\Models\Note;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the dynamic landing page.
     */
    public function index()
    {
        $stats = Cache::remember('homepage_stats', 3600, function () {
            return [
                'students' => User::where('role', 'student')->count(),
                'teachers' => User::where('role', 'teacher')->count(),
                'companies' => User::where('role', 'company')->count(),
                'internships' => Internship::where('status', 'active')->where('approval_status', 'approved')->where('is_published', true)->count(),
                'scholarships' => Scholarship::where('is_published', true)->count(),
                'competitions' => Competition::where('is_published', true)->count(),
                'events' => Event::where('is_published', true)->where('approval_status', 'approved')->count(),
                'certificates' => Certificate::count(),
            ];
        });

        $latestInternships = Internship::with(['company.companyProfile'])
            ->where('status', 'active')
            ->where('approval_status', 'approved')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $latestCompetitions = Competition::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $latestScholarships = Scholarship::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $latestEvents = Event::where('is_published', true)
            ->where('approval_status', 'approved')
            ->orderBy('event_date', 'asc')
            ->where('event_date', '>=', now())
            ->take(4)
            ->get();

        $latestNotes = Note::with('uploader')
            ->where('is_published', true)
            ->where('approval_status', 'approved')
            ->orderBy('downloads_count', 'desc')
            ->take(4)
            ->get();
            
        $featuredCompanies = User::where('role', 'company')
            ->where('status', 'active')
            ->with('companyProfile')
            ->take(8)
            ->get();

        return view('welcome', compact(
            'stats', 
            'latestInternships', 
            'latestCompetitions', 
            'latestScholarships', 
            'latestEvents', 
            'latestNotes',
            'featuredCompanies'
        ));
    }
}
