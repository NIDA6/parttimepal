<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_profile_id')->constrained()->onDelete('cascade');
            $table->string('school_name')->nullable();
            $table->string('school_year', 4)->nullable();
            $table->string('college_name')->nullable();
            $table->string('college_year', 4)->nullable();
            $table->string('university_name')->nullable();
            $table->string('university_year', 4)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_education');
    }
}; 