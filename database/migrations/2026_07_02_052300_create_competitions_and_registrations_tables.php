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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->text('rules')->nullable();
            $table->text('prizes')->nullable();
            $table->date('registration_deadline');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->text('winners')->nullable(); // JSON or text of winners description
            $table->timestamps();
        });

        Schema::create('competition_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('competitions')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('registered'); // registered, participated, winner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_registrations');
        Schema::dropIfExists('competitions');
    }
};
