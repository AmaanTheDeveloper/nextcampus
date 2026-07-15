<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Competition;
use App\Models\Scholarship;
use App\Models\Event;
use App\Models\Note;
use App\Models\Category;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function internships(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $query = Internship::with(['company.companyProfile', 'category'])
            ->where('status', 'active')
            ->where('approval_status', 'approved')
            ->where('is_published', true);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $internships = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Category::where('type', 'internship')->orderBy('name')->get();

        return view('guest.internships', compact('internships', 'search', 'categories', 'categoryId'));
    }

    public function internshipDetail($id)
    {
        $internship = Internship::with(['company.companyProfile', 'category'])->findOrFail($id);
        return view('guest.internship-detail', compact('internship'));
    }

    public function competitions(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $query = Competition::with('category')->where('is_published', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $competitions = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Category::where('type', 'competition')->orderBy('name')->get();

        return view('guest.competitions', compact('competitions', 'search', 'categories', 'categoryId'));
    }

    public function competitionDetail($id)
    {
        $competition = Competition::with('category')->findOrFail($id);
        return view('guest.competition-detail', compact('competition'));
    }

    public function scholarships(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $query = Scholarship::with('category')->where('is_published', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $scholarships = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Category::where('type', 'scholarship')->orderBy('name')->get();

        return view('guest.scholarships', compact('scholarships', 'search', 'categories', 'categoryId'));
    }

    public function scholarshipDetail($id)
    {
        $scholarship = Scholarship::with('category')->findOrFail($id);
        return view('guest.scholarship-detail', compact('scholarship'));
    }

    public function events(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $query = Event::with('category')
            ->where('is_published', true)
            ->where('approval_status', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Category::where('type', 'event')->orderBy('name')->get();

        return view('guest.events', compact('events', 'search', 'categories', 'categoryId'));
    }

    public function eventDetail($id)
    {
        $event = Event::with('gallery')->findOrFail($id);
        return view('guest.event-detail', compact('event'));
    }

    public function notes(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $query = Note::with(['uploader', 'category'])
            ->where('is_published', true)
            ->where('approval_status', 'approved');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('semester', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $notes = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::where('type', 'note')->orderBy('name')->get();

        return view('guest.notes', compact('notes', 'search', 'categories', 'categoryId'));
    }
}
