<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CompanyProfile;
use App\Models\TeacherProfile;
use App\Models\ClubLeaderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        if (auth()->user()->is_blocked) {
            return redirect()->route('blocked');
        }

        $user = auth()->user()->load([
            'studentProfile', 'companyProfile', 'teacherProfile', 'clubLeaderProfile',
        ]);

        return view('profile.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->update($request->only('name', 'phone', 'bio', 'facebook', 'twitter', 'linkedin', 'github'));

        if ($request->hasFile('photo')) {
            $user->updateProfilePhoto($request->file('photo'));
        }

        $this->updateRoleProfile($user, $request);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    private function updateRoleProfile(User $user, Request $request): void
    {
        match ($user->role) {
            'student' => $this->updateStudentProfile($user, $request),
            'company' => $this->updateCompanyProfile($user, $request),
            'teacher' => $this->updateTeacherProfile($user, $request),
            'club_leader' => $this->updateClubLeaderProfile($user, $request),
            default => null,
        };
    }

    private function updateStudentProfile(User $user, Request $request): void
    {
        $request->validate([
            'institute' => 'nullable|string|max:255',
            'class_name' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'semester' => 'nullable|string|max:50',
            'skills' => 'nullable|string|max:500',
        ]);

        StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('institute', 'class_name', 'department', 'semester', 'skills')
        );
    }

    private function updateCompanyProfile(User $user, Request $request): void
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        CompanyProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('company_name', 'website', 'address', 'description')
        );
    }

    private function updateTeacherProfile(User $user, Request $request): void
    {
        $request->validate([
            'department' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
        ]);

        TeacherProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('department', 'designation')
        );
    }

    private function updateClubLeaderProfile(User $user, Request $request): void
    {
        $request->validate([
            'club_name' => 'nullable|string|max:255',
            'club_description' => 'nullable|string|max:2000',
        ]);

        ClubLeaderProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('club_name', 'club_description')
        );
    }
}
