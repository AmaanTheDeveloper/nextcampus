<?php

namespace App\Http\Controllers;

use App\Models\ForumQuestion;
use App\Models\ForumAnswer;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of questions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ForumQuestion::with(['student', 'answers']);

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('student.forum.index', compact('questions', 'search'));
    }

    /**
     * Store a new question.
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        ForumQuestion::create([
            'student_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'views' => 0
        ]);

        return redirect()->route('student.forum')->with('success', 'Question posted successfully!');
    }

    /**
     * Show question thread and answer list.
     */
    public function questionDetail($id)
    {
        $question = ForumQuestion::with(['student', 'answers.user'])->findOrFail($id);
        $question->increment('views');

        return view('student.forum.show', compact('question'));
    }

    /**
     * Store answer for a question.
     */
    public function storeAnswer(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        ForumAnswer::create([
            'question_id' => $id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Answer posted successfully!');
    }
}
