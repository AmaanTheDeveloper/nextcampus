<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->default('My Resume');
            $table->json('personal_info')->nullable(); // name, email, phone, address, summary, website
            $table->json('education')->nullable(); // school, degree, start, end, grade
            $table->json('skills')->nullable(); // array of skills
            $table->json('projects')->nullable(); // title, description, link, technologies
            $table->json('experience')->nullable(); // company, role, start, end, description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
