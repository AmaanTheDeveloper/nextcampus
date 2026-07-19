<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Internship;
use App\Models\Scholarship;
use App\Models\Competition;
use App\Models\Event;
use App\Models\Note;
use App\Models\Certificate;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealisticContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $categories = ['Software Engineering', 'Data Science', 'UI/UX Design', 'Cloud Computing', 'Cyber Security'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat], ['type' => 'general']);
        }
        $catIds = Category::pluck('id')->toArray();

        // 2. Realistic Companies
        $companies = [
            'Systems Limited', '10Pearls', 'Arbisoft', 'TPS', 'Afiniti', 'Contour Software', 
            'Folio3', 'Creative Chaos', 'Tkxel', 'Netsol Technologies', 'VentureDive', 'CureMD',
            'Google', 'Microsoft', 'Apple', 'Amazon', 'Meta', 'NVIDIA'
        ];
        
        $companyUsers = [];
        foreach ($companies as $idx => $companyName) {
            $user = User::firstOrCreate(
                ['email' => 'hr' . $idx . '@' . strtolower(str_replace(' ', '', $companyName)) . '.com'],
                [
                    'name' => $companyName . ' HR',
                    'password' => Hash::make('password'),
                    'role' => 'company',
                    'status' => 'active'
                ]
            );
            
            $user->companyProfile()->firstOrCreate([
                'company_name' => $companyName,
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $companyName)) . '.com'
            ]);
            $companyUsers[] = $user->id;
        }

        // 3. Realistic Internships
        $internshipTitles = [
            'Laravel Developer Intern', 'PHP Developer Intern', 'Frontend Developer Intern',
            'Backend Developer Intern', 'Full Stack Developer Intern', 'UI/UX Design Intern',
            'Mobile App Development Intern', 'Flutter Intern', 'AI & Machine Learning Intern',
            'Data Science Intern', 'DevOps Intern', 'Cyber Security Intern'
        ];

        foreach ($internshipTitles as $title) {
            Internship::firstOrCreate(
                ['title' => $title],
                [
                    'company_id' => $companyUsers[array_rand($companyUsers)],
                    'category_id' => $catIds[array_rand($catIds)],
                    'description' => "Join our team as a $title. You will be working on enterprise scale applications and learning industry best practices.",
                    'location' => ['Karachi', 'Lahore', 'Islamabad', 'Remote'][array_rand(['Karachi', 'Lahore', 'Islamabad', 'Remote'])],
                    'salary' => 'Rs. ' . rand(15, 30) . ',000 / month',
                    'requirements' => "Strong fundamentals in programming. Passion to learn.",
                    'deadline' => Carbon::now()->addDays(rand(10, 45)),
                    'status' => 'active',
                    'approval_status' => 'approved',
                    'is_published' => true
                ]
            );
        }

        // 4. Realistic Scholarships
        $scholarships = [
            'HEC Need-Based Scholarship', 'Ehsaas Undergraduate Scholarship', 'PEEF Scholarship',
            'Commonwealth Scholarship', 'Fulbright Scholarship', 'Chevening Scholarship',
            'Erasmus Mundus Scholarship', 'DAAD Scholarship'
        ];

        foreach ($scholarships as $scholarship) {
            Scholarship::firstOrCreate(
                ['title' => $scholarship],
                [
                    'category_id' => $catIds[array_rand($catIds)],
                    'description' => "Fully funded $scholarship for outstanding students demonstrating academic excellence.",
                    'amount' => 'Fully Funded',
                    'deadline' => Carbon::now()->addDays(rand(15, 60)),
                    'eligibility' => 'Minimum 3.0 CGPA. Enrolled in a recognized university.',
                    'official_apply_link' => 'https://example.com/apply',
                    'is_published' => true
                ]
            );
        }

        // 5. Realistic Competitions
        $competitions = [
            'National Hackathon 2026', 'AI Innovation Challenge', 'UI/UX Design Sprint',
            'Cyber Security CTF', 'Data Science Challenge', 'Web Development Olympiad'
        ];

        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin', 'status' => 'active']);
        
        foreach ($competitions as $comp) {
            Competition::firstOrCreate(
                ['title' => $comp],
                [
                    'category_id' => $catIds[array_rand($catIds)],
                    'description' => "Participate in the $comp and showcase your skills to top tech companies. Win exciting cash prizes and internship opportunities.",
                    'prizes' => 'Rs. 100,000 + Tech Gadgets',
                    'registration_deadline' => Carbon::now()->addDays(rand(5, 30)),
                    'start_date' => Carbon::now()->addDays(rand(35, 40)),
                    'end_date' => Carbon::now()->addDays(rand(41, 60)),
                    'created_by' => $admin->id,
                    'is_published' => true
                ]
            );
        }

        // 6. Realistic Events
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $events = [
            'Tech Career Fair 2026', 'AI Summit Pakistan', 'Startup Pitch Meetup',
            'Developer Conference', 'CV & Interview Workshop', 'Google Developer Group Meetup'
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(
                ['title' => $event],
                [
                    'created_by' => $admin->id,
                    'category_id' => $catIds[array_rand($catIds)],
                    'description' => "Join industry leaders and tech enthusiasts at the $event. Network with professionals and explore career opportunities.",
                    'event_date' => Carbon::now()->addDays(rand(2, 40)),
                    'location' => 'Expo Center, Karachi',
                    'type' => 'conference',
                    'registration_deadline' => Carbon::now()->addDays(rand(1, 35)),
                    'approval_status' => 'approved',
                    'is_published' => true
                ]
            );
        }

        // 7. Realistic Study Notes
        $subjects = ['Data Structures', 'Database Systems', 'Operating Systems', 'Software Engineering', 'Artificial Intelligence', 'Web Engineering'];
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@nextcampus.com'],
            ['name' => 'Dr. Ahmed (Professor)', 'password' => Hash::make('password'), 'role' => 'teacher', 'status' => 'active']
        );
        $teacher->teacherProfile()->firstOrCreate(['department' => 'Computer Science']);

        foreach ($subjects as $subject) {
            Note::firstOrCreate(
                ['title' => $subject . ' - Complete Course Notes'],
                [
                    'uploaded_by' => $teacher->id,
                    'category_id' => $catIds[array_rand($catIds)],
                    'subject' => $subject,
                    'semester' => 'Semester ' . rand(3, 8),
                    'description' => "Comprehensive study notes covering all essential topics for $subject.",
                    'file_path' => 'dummy/notes.pdf',
                    'downloads_count' => rand(50, 500),
                    'approval_status' => 'approved',
                    'is_published' => true
                ]
            );
        }
    }
}
