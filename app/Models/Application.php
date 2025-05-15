<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobListing;
use App\Models\User;
use App\Models\ConfirmedJob;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_listing_id',
        'user_id',
        'name',
        'cover_letter',
        'experience',
        'additional_notes',
        'application_link',
        'status'
    ];

    // This tells Laravel to include 'full_name' in the model's attributes
    protected $appends = ['full_name'];

    // Accessor for the full_name attribute (maps to name in database)
    public function getFullNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the confirmed job record associated with the application.
     */
    public function confirmedJob()
    {
        return $this->hasOne(ConfirmedJob::class, 'application_id');
    }
}