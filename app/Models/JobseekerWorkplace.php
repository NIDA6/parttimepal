<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobseekerWorkplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'jobseeker_profile_id',
        'company_name',
        'designation',
    ];

    public function jobseekerProfile(): BelongsTo
    {
        return $this->belongsTo(JobseekerProfile::class);
    }
} 