<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_profile_id',
        'title',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'job_time',
        'additional_message',
        'application_link',
    ];

    public function companyProfile()
    {
        return $this->belongsTo(CompanyProfile::class);
    }
}
