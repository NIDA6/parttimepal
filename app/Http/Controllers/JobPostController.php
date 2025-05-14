<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function create()
    {
        return view('job-posts.create');
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user->companyProfile) {
                return redirect()->route('company.profile.create')
                    ->with('error', 'Please create your company profile first.');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'responsibilities' => 'required|string',
                'salary' => 'required|string|max:255',
                'job_time' => 'nullable|string|max:255',
                'additional_message' => 'nullable|string',
                'application_link' => 'nullable|url|max:255',
            ]);

            $validated['company_profile_id'] = $user->companyProfile->id;

            try {
                $jobListing = JobListing::create($validated);
                return redirect()->route('dashboard')->with('success', 'Job posted successfully!');
            } catch (\Exception $e) {
                \Log::error('Database error creating job listing: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'There was an error saving the job listing. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating job listing: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error creating the job listing. Please try again.');
        }
    }
}
