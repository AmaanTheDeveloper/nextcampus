<?php

namespace App\Actions\Fortify;

use App\Mail\Usermail;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CompanyProfile;
use App\Models\TeacherProfile;
use App\Models\ClubLeaderProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:student,teacher,company,club_leader'],
            'phone' => ['nullable', 'string', 'max:255'],
            'extra_name' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $role = $input['role'];
        $status = ($role === 'teacher' || $role === 'company') ? 'pending' : 'active';

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $role,
            'status' => $status,
            'phone' => $input['phone'] ?? null,
        ]);

        // Assign Spatie Role
        $user->assignRole($role);

        // Create Profile based on Role
        if ($role === 'student') {
            StudentProfile::create([
                'user_id' => $user->id,
                'phone' => $input['phone'] ?? null,
                'institute' => $input['extra_name']
            ]);
        } elseif ($role === 'company') {
            CompanyProfile::create([
                'user_id' => $user->id,
                'company_name' => $input['extra_name']
            ]);
        } elseif ($role === 'teacher') {
            TeacherProfile::create([
                'user_id' => $user->id,
                'department' => $input['extra_name']
            ]);
        } elseif ($role === 'club_leader') {
            ClubLeaderProfile::create([
                'user_id' => $user->id,
                'club_name' => $input['extra_name']
            ]);
        }

        try {
            $message = "Hello, thanks for registering your account at NextCampus. Your role is: " . ucfirst($role) . ". Your status is currently: " . ucfirst($status) . ".";
            $subject = "NextCampus Account Registration Details";
            Mail::to($input['email'])->send(new Usermail($message, $subject, $input['email'], $input['password']));
        } catch (\Exception $e) {
            // Ignore mail delivery failure in local development
        }

        return $user;
    }
}
