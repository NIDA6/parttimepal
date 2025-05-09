<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_workplaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_profile_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('designation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_workplaces');
    }
}; 