<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\User;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use NotifiesUsers;

    public function teacherIndex()
    {
        $assignments = Assignment::withCount('submissions')
            ->where('teacher_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('teacher.assignments.index', compact('assignments'));
    }

    public function teacherCreate()
    {
        $students = User::where('role', 'student')->where('status', 'active')->orderBy('name')->get();

        return view('teacher.assignments.create', compact('students'));
    }

    public function teacherStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:assignment,test',
            'due_date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'total_marks' => 'nullable|integer|min:1|max:1000',
            'class_name' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'semester' => 'nullable|string|max:50',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $assignment = Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => auth()->id(),
            'type' => $request->type,
            'class_name' => $request->class_name,
            'department' => $request->department,
            'semester' => $request->semester,
            'due_date' => $request->due_date,
            'total_marks' => $request->total_marks,
            'is_published' => true,
        ]);

        $students = $this->resolveTargetStudents($request);

        if ($students->isEmpty()) {
            $assignment->delete();

            return redirect()->back()->withInput()
                ->with('error', 'No students matched your selection. Please choose class, department, semester, or individual students.');
        }

        foreach ($students as $student) {
            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $student->id,
                'status' => 'pending',
            ]);

            $this->notifyUser(
                $student,
                $request->type === 'test' ? 'New Test Assigned' : 'New Assignment',
                "You have a new {$request->type}: {$assignment->title}",
                route('student.assignments.index')
            );
        }

        $this->notifyAdmins(
            'Teacher Activity',
            auth()->user()->name . " created a new {$request->type}: {$assignment->title}",
            route('admin.assignments')
        );

        return redirect()->route('teacher.assignments.index')
            ->with('success', ucfirst($request->type) . ' assigned successfully!');
    }

    public function teacherSubmissions($id)
    {
        $assignment = Assignment::where('teacher_id', auth()->id())
            ->with(['submissions.student'])
            ->findOrFail($id);

        return view('teacher.assignments.submissions', compact('assignment'));
    }

    public function gradeSubmission(Request $request, $id)
    {
        $submission = AssignmentSubmission::whereHas('assignment', function ($q) {
            $q->where('teacher_id', auth()->id());
        })->with('assignment', 'student')->findOrFail($id);

        $request->validate([
            'marks' => 'nullable|integer|min:0|max:' . ($submission->assignment->total_marks ?? 100),
            'grade' => 'nullable|string|max:10',
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'marks' => $request->marks,
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        $this->notifyUser(
            $submission->student,
            'Marks Published',
            "Your {$submission->assignment->type} \"{$submission->assignment->title}\" has been graded.",
            route('student.assignments.index')
        );

        return redirect()->back()->with('success', 'Submission graded successfully!');
    }

    public function studentIndex()
    {
        $submissions = AssignmentSubmission::with('assignment.teacher')
            ->where('student_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('student.assignments.index', compact('submissions'));
    }

    public function studentSubmit(Request $request, $id)
    {
        $submission = AssignmentSubmission::where('student_id', auth()->id())
            ->with('assignment')
            ->findOrFail($id);

        if ($submission->assignment->due_date->isPast()) {
            return redirect()->back()->with('error', 'Submission deadline has passed.');
        }

        $request->validate([
            'answer_text' => 'nullable|string|max:10000',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'answer_text' => $request->answer_text,
            'status' => 'submitted',
            'submitted_at' => now(),
        ];

        if ($request->hasFile('file')) {
            $data['submission_path'] = $request->file('file')->store('submissions', 'public');
        }

        $submission->update($data);

        $this->notifyAdmins(
            'Test Submission',
            auth()->user()->name . " submitted {$submission->assignment->type}: {$submission->assignment->title}",
            route('admin.assignments')
        );

        return redirect()->back()->with('success', 'Submission uploaded successfully!');
    }

    private function resolveTargetStudents(Request $request)
    {
        if ($request->filled('student_ids')) {
            return User::whereIn('id', $request->student_ids)
                ->where('role', 'student')
                ->where('status', 'active')
                ->get();
        }

        $query = User::where('role', 'student')->where('status', 'active')
            ->whereHas('studentProfile', function ($q) use ($request) {
                if ($request->filled('class_name')) {
                    $q->where('class_name', $request->class_name);
                }
                if ($request->filled('department')) {
                    $q->where('department', $request->department);
                }
                if ($request->filled('semester')) {
                    $q->where('semester', $request->semester);
                }
            });

        $students = $query->get();

        if ($students->isEmpty()) {
            return collect();
        }

        return $students;
    }
}
