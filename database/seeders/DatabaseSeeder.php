<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Spatie Roles
        $roles = ['admin', 'student', 'teacher', 'company', 'club_leader'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Seed Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@nextcampus.com'],
            [
                'name' => 'NextCampus Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
        $admin->assignRole('admin');

        // Seed some other test accounts for demonstration if needed, let's keep it simple.

        // 3. Seed Categories
        $categories = [
            ['name' => 'Web Development', 'type' => 'competition'],
            ['name' => 'Hackathon', 'type' => 'competition'],
            ['name' => 'Coding Quiz', 'type' => 'competition'],
            ['name' => 'Design Contest', 'type' => 'competition'],

            ['name' => 'Need Based', 'type' => 'scholarship'],
            ['name' => 'Merit Based', 'type' => 'scholarship'],
            ['name' => 'Minority Scholarship', 'type' => 'scholarship'],
            ['name' => 'Government Funding', 'type' => 'scholarship'],

            ['name' => 'Computer Science', 'type' => 'note'],
            ['name' => 'Software Engineering', 'type' => 'note'],
            ['name' => 'Data Science', 'type' => 'note'],
            ['name' => 'Information Technology', 'type' => 'note'],

            ['name' => 'Software Development', 'type' => 'internship'],
            ['name' => 'Data Analytics', 'type' => 'internship'],
            ['name' => 'Marketing', 'type' => 'internship'],
            ['name' => 'Finance', 'type' => 'internship'],

            ['name' => 'Seminar', 'type' => 'event'],
            ['name' => 'Workshop', 'type' => 'event'],
            ['name' => 'Hackathon', 'type' => 'event'],
            ['name' => 'Career Fair', 'type' => 'event'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => $cat['type']]
            );
        }
    }
}
