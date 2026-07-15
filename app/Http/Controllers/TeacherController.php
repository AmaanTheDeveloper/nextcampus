<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    use NotifiesUsers;
    /**
     * Display teacher dashboard.
     */
    public function dashboard()
    {
        $teacherId = auth()->id();
        $notesUploadedCount = Note::where('uploaded_by', $teacherId)->count();
        $totalDownloads = Note::where('uploaded_by', $teacherId)->sum('downloads_count');

        $recentNotes = Note::where('uploaded_by', $teacherId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $assignmentsCount = \App\Models\Assignment::where('teacher_id', $teacherId)->count();

        return view('teacher.dashboard', compact('notesUploadedCount', 'totalDownloads', 'recentNotes', 'assignmentsCount'));
    }

    /**
     * List teacher uploaded notes.
     */
    public function index()
    {
        $notes = Note::with('category')
            ->where('uploaded_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.notes.index', compact('notes'));
    }

    /**
     * Form to create note.
     */
    public function create()
    {
        $categories = Category::where('type', 'note')->get();
        return view('teacher.notes.create', compact('categories'));
    }

    /**
     * Store new note.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'category_id' => 'nullable|exists:categories,id',
            'file' => 'required|file|mimes:pdf|max:10240' // 10MB limit
        ]);

        $path = $request->file('file')->store('notes', 'public');

        Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
            'semester' => $request->semester,
            'category_id' => $request->category_id,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
            'downloads_count' => 0,
            'approval_status' => 'pending',
            'is_published' => false,
        ]);

        $this->notifyAdmins(
            'New Note Pending Review',
            auth()->user()->name . ' uploaded a note: ' . $request->title,
            route('admin.notes')
        );

        return redirect()->route('teacher.notes.index')
            ->with('success', 'Study notes uploaded and sent for admin approval!');
    }

    /**
     * Delete notes.
     */
    public function destroy($id)
    {
        $note = Note::where('uploaded_by', auth()->id())->findOrFail($id);
        Storage::disk('public')->delete($note->file_path);
        $note->delete();

        return redirect()->route('teacher.notes.index')->with('success', 'Study notes deleted successfully.');
    }
}
