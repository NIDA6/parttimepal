<?php

namespace App\Observers;

use App\Models\Application;
use App\Notifications\NewJobApplication;
use Illuminate\Support\Facades\Log;

class ApplicationObserver
{

    public function created(Application $application)
    {
        try {
            
            $application->load([
                'jobListing.companyProfile.user',
                'user'
            ]);

            $companyUser = $application->jobListing->companyProfile->user ?? null;

            if ($companyUser) {

                $companyUser->notify(new NewJobApplication($application));
                
                Log::info('Application notification sent', [
                    'application_id' => $application->id,
                    'company_user_id' => $companyUser->id
                ]);
            } else {
                Log::warning('Company user not found for application', [
                    'application_id' => $application->id,
                    'job_listing_id' => $application->job_listing_id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in ApplicationObserver: ' . $e->getMessage(), [
                'application_id' => $application->id ?? null,
                'exception' => $e
            ]);
        }
    }

    public function updated(Application $application)
    {
        
    }

    public function deleted(Application $application)
    {
        
    }
}