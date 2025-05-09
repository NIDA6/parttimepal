<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'job_time',
        'additional_message',
        'application_link',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
