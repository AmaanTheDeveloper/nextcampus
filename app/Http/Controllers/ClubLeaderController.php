<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventGallery;
use App\Models\Category;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubLeaderController extends Controller
{
    use NotifiesUsers;
    /**
     * Display club leader dashboard.
     */
    public function dashboard()
    {
        $leaderId = auth()->id();
        $eventsCount = Event::where('created_by', $leaderId)->count();
        
        $totalRegistrations = EventRegistration::whereHas('event', function($q) use ($leaderId) {
            $q->where('created_by', $leaderId);
        })->count();

        $recentEvents = Event::where('created_by', $leaderId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('student.club_leader.dashboard', compact('eventsCount', 'totalRegistrations', 'recentEvents'));
    }

    /**
     * List events.
     */
    public function index()
    {
        $events = Event::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.club_leader.events.index', compact('events'));
    }

    /**
     * Create event form.
     */
    public function create()
    {
        $categories = Category::where('type', 'event')->orderBy('name')->get();

        return view('student.club_leader.events.create', compact('categories'));
    }

    /**
     * Store new event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:100', // Seminar, Workshop, Bootcamp, etc.
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'registration_deadline' => 'required|date|before_or_equal:event_date',
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
            'approval_status' => 'pending',
            'is_published' => false,
        ]);

        $this->notifyAdmins(
            'New Event Pending Review',
            auth()->user()->name . ' created event: ' . $request->title,
            route('admin.events')
        );

        return redirect()->route('club_leader.events.index')
            ->with('success', 'Event created and sent for admin approval!');
    }

    /**
     * Edit event form.
     */
    public function edit($id)
    {
        $event = Event::where('created_by', auth()->id())->findOrFail($id);
        return view('student.club_leader.events.edit', compact('event'));
    }

    /**
     * Update event details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date|before_or_equal:event_date'
        ]);

        $event = Event::where('created_by', auth()->id())->findOrFail($id);
        $event->update($request->all());

        return redirect()->route('club_leader.events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Delete event.
     */
    public function destroy($id)
    {
        $event = Event::where('created_by', auth()->id())->findOrFail($id);
        $event->delete();

        return redirect()->route('club_leader.events.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * View event registrations.
     */
    public function registrations($id)
    {
        $event = Event::where('created_by', auth()->id())->findOrFail($id);
        $registrations = EventRegistration::with('student')
            ->where('event_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.club_leader.events.registrations', compact('event', 'registrations'));
    }

    /**
     * Event Gallery management.
     */
    public function gallery($id)
    {
        $event = Event::with('gallery')->where('created_by', auth()->id())->findOrFail($id);
        return view('student.club_leader.events.gallery', compact('event'));
    }

    public function uploadGallery(Request $request, $id)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|file|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $event = Event::where('created_by', auth()->id())->findOrFail($id);

        foreach ($request->file('images') as $file) {
            $path = $file->store('event_galleries', 'public');
            EventGallery::create([
                'event_id' => $event->id,
                'image_path' => $path
            ]);
        }

        return redirect()->back()->with('success', 'Gallery images uploaded successfully!');
    }

    public function deleteGalleryImage($id)
    {
        $img = EventGallery::whereHas('event', function($q) {
            $q->where('created_by', auth()->id());
        })->findOrFail($id);

        Storage::disk('public')->delete($img->image_path);
        $img->delete();

        return redirect()->back()->with('success', 'Gallery image deleted.');
    }
}
