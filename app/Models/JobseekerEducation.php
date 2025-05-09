<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobseekerEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'jobseeker_profile_id',
        'school_name',
        'school_year',
        'college_name',
        'college_year',
        'university_name',
        'university_year',
    ];

    public function jobseekerProfile(): BelongsTo
    {
        return $this->belongsTo(JobseekerProfile::class);
    }
} 