<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_profile_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->timestamps();

            // Ensure a jobseeker can only review a company once
            $table->unique(['jobseeker_id', 'company_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
}; 