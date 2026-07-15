<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('phone');
            $table->string('facebook')->nullable()->after('bio');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('github')->nullable()->after('linkedin');
        });

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->string('class_name')->nullable()->after('institute');
            $table->string('department')->nullable()->after('class_name');
            $table->string('semester')->nullable()->after('department');
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('company_id')->constrained('categories')->nullOnDelete();
            $table->string('approval_status')->default('approved')->after('status');
            $table->boolean('is_published')->default(true)->after('approval_status');
        });

        Schema::table('competitions', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('winners');
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('category_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('created_by')->constrained('categories')->nullOnDelete();
            $table->string('approval_status')->default('approved')->after('category_id');
            $table->boolean('is_published')->default(true)->after('approval_status');
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->string('approval_status')->default('approved')->after('category_id');
            $table->boolean('is_published')->default(true)->after('approval_status');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->string('type')->default('assignment')->after('teacher_id');
            $table->string('class_name')->nullable()->after('description');
            $table->string('department')->nullable()->after('class_name');
            $table->string('semester')->nullable()->after('department');
            $table->integer('total_marks')->nullable()->after('semester');
            $table->boolean('is_published')->default(true)->after('total_marks');
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('submission_path')->nullable();
            $table->text('answer_text')->nullable();
            $table->string('status')->default('pending');
            $table->integer('marks')->nullable();
            $table->string('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn(['type', 'class_name', 'department', 'semester', 'total_marks', 'is_published']);
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'is_published']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['approval_status', 'is_published']);
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });

        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['approval_status', 'is_published']);
        });

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn(['class_name', 'department', 'semester']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'facebook', 'twitter', 'linkedin', 'github']);
        });
    }
};
