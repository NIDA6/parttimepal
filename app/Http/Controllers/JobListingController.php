<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobListingController extends Controller
{
    public function index()
    {
        $jobListings = JobListing::with('companyProfile')
            ->latest()
            ->get();
        
        return view('job-listings.index', compact('jobListings'));
    }

    public function create()
    {
        return view('job-listings.create');
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
                'job_time' => 'required|string|max:255',
                'additional_message' => 'nullable|string',
                'application_link' => 'nullable|string|max:255',
            ]);

            $validated['company_profile_id'] = $user->companyProfile->id;

            try {
                $jobListing = JobListing::create($validated);
                return redirect()->route('job-listings.show', $jobListing)
                    ->with('success', 'Job posted successfully!');
            } catch (\Exception $e) {
                \Log::error('Error creating job listing: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'There was an error creating the job listing. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Error in job listing creation: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error creating the job listing. Please try again.');
        }
    }

    public function show(JobListing $jobListing)
    {
        try {
            $jobListing->load('companyProfile');
            
            if (!$jobListing->companyProfile) {
                return redirect()->route('dashboard')
                    ->with('error', 'This job listing is no longer available.');
            }

            return view('job-listings.show', compact('jobListing'));
        } catch (\Exception $e) {
            \Log::error('Error showing job listing: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'There was an error loading the job listing.');
        }
    }

    public function edit(JobListing $jobListing)
    {
        // Check if the user owns this job listing
        if ($jobListing->company_profile_id !== auth()->user()->companyProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('job-listings.edit', compact('jobListing'));
    }

    public function update(Request $request, JobListing $jobListing)
    {
        // Check if the user owns this job listing
        if ($jobListing->company_profile_id !== auth()->user()->companyProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|string|max:255',
            'job_time' => 'required|string|max:255',
            'additional_message' => 'nullable|string',
        ]);

        try {
            $jobListing->update($validated);
            return redirect()->route('job-listings.show', $jobListing)
                ->with('success', 'Job listing updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating job listing: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error updating the job listing. Please try again.');
        }
    }

    public function apply(Request $request, JobListing $jobListing)
    {
        \Log::info('Apply method called', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'job_listing_id' => $jobListing->id,
            'request_method' => $request->method()
        ]);

        // Check if user is a jobseeker
        if (auth()->user()->role !== 'Jobseeker') {
            \Log::warning('Non-jobseeker tried to apply', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role
            ]);
            return redirect()->route('dashboard')->with('error', 'Only jobseekers can apply for jobs.');
        }

        // For GET requests, show the application form
        if ($request->isMethod('get')) {
            \Log::info('Showing application form');
            return view('job-listings.apply', compact('jobListing'));
        }

        // For POST requests, handle the form submission
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'cover_letter' => 'required|string|min:50',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
            'additional_notes' => 'nullable|string',
        ]);

        // Store the resume file
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // Create the job application
        JobApplication::create([
            'job_listing_id' => $jobListing->id,
            'user_id' => auth()->id(),
            'phone' => $validated['phone'],
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $resumePath,
            'additional_notes' => $validated['additional_notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('job-listings.show', $jobListing)
            ->with('success', 'Your application has been submitted successfully!');
    }
}
