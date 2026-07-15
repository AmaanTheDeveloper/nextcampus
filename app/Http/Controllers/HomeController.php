<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Internship;
use App\Models\Competition;
use App\Models\Scholarship;
use App\Models\Event;
use App\Models\Note;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the dynamic landing page.
     */
    public function index()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'internships' => Internship::where('status', 'active')->where('approval_status', 'approved')->where('is_published', true)->count(),
            'notes' => Note::where('is_published', true)->where('approval_status', 'approved')->count(),
            'competitions' => Competition::where('is_published', true)->count(),
        ];

        $latestInternships = Internship::with(['company.companyProfile'])
            ->where('status', 'active')
            ->where('approval_status', 'approved')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
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
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('stats', 'latestInternships', 'latestCompetitions', 'latestScholarships', 'latestEvents'));
    }
}
