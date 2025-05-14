<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\JobseekerShortlisted;

class JobListing extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'job_time',
        'additional_message',
        'company_profile_id',
        'application_link',
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

    public function notifyJobseeker($jobseeker)
    {
        $jobseeker->notify(new JobseekerShortlisted($this->title, $this->id));
    }

    public function notifyCompany($companyUser)
    {
        $companyUser->notify(new JobseekerShortlisted($this->title, $this->id));
    }
}
