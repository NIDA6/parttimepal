<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application;

class NewJobApplication extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_listing_id' => $this->application->job_listing_id,
            'jobseeker_name' => $this->application->full_name,
            'job_title' => $this->application->jobListing->title,
            'message' => "New application received from {$this->application->full_name} for {$this->application->jobListing->title}",
            'type' => 'job_application'
        ];
    }
} 