<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeController extends Controller
{
    /**
     * Show resume form. If none exists, create one with empty blocks.
     */
    public function index()
    {
        $resume = Resume::firstOrCreate(
            ['student_id' => auth()->id()],
            [
                'title' => 'My Main Resume',
                'personal_info' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone ?? '',
                    'address' => '',
                    'summary' => '',
                    'website' => ''
                ],
                'education' => [],
                'skills' => [],
                'projects' => [],
                'experience' => []
            ]
        );

        return view('student.resume', compact('resume'));
    }

    /**
     * Update resume data.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'personal_info' => 'required|array',
            'education' => 'nullable|array',
            'skills' => 'nullable|array',
            'projects' => 'nullable|array',
            'experience' => 'nullable|array',
        ]);

        $resume = Resume::where('student_id', auth()->id())->firstOrFail();
        
        $resume->update([
            'title' => $request->title,
            'personal_info' => $request->personal_info,
            'education' => $request->education ?: [],
            'skills' => $request->skills ?: [],
            'projects' => $request->projects ?: [],
            'experience' => $request->experience ?: [],
        ]);

        return redirect()->back()->with('success', 'Resume updated successfully!');
    }

    /**
     * Download resume in PDF format.
     */
    public function download()
    {
        $resume = Resume::where('student_id', auth()->id())->firstOrFail();

        // Load the print view and stream/download the PDF
        $pdf = Pdf::loadView('student.resume-pdf', compact('resume'));
        
        return $pdf->download(str_replace(' ', '_', auth()->user()->name) . '_Resume.pdf');
    }
}
