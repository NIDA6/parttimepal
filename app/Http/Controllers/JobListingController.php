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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|numeric',
            'job_time' => 'required|string',
            'additional_message' => 'nullable|string',
            'application_link' => 'required|url',
        ]);

        $validated['company_profile_id'] = Auth::user()->companyProfile->id;

        JobListing::create($validated);

        return redirect()->route('dashboard')->with('success', 'Job posted successfully!');
    }

    public function show(JobListing $jobListing)
    {
        return view('job-listings.show', compact('jobListing'));
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
            'salary' => 'required|numeric',
            'job_time' => 'required|string',
            'additional_message' => 'nullable|string',
            'application_link' => 'required|url',
        ]);

        $jobListing->update($validated);

        return redirect()->route('job-listings.show', $jobListing)
            ->with('success', 'Job listing updated successfully.');
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
