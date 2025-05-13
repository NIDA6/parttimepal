<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'job_time',
        'additional_message',
        'company_profile_id',
    ];

    public function companyProfile()
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function company()
    {
        return $this->belongsTo(CompanyProfile::class, 'company_profile_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
