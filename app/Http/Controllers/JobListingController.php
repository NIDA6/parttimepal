<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'salary' => 'required|numeric|min:0',
                'job_time' => 'required|string|max:255',
                'additional_message' => 'nullable|string',
            ]);

            $validated['company_profile_id'] = $user->companyProfile->id;

            $jobListing = JobListing::create($validated);

            return redirect()->route('job-listings.show', $jobListing)
                ->with('success', 'Job posted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating job listing: ' . $e->getMessage());
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
            'application_link' => 'required|url',
        ]);

        $jobListing->update($validated);

        return redirect()->route('job-listings.show', $jobListing)
            ->with('success', 'Job listing updated successfully.');
    }

    public function apply(Request $request, JobListing $jobListing)
    {
        // Check if user is a jobseeker
        if (strtolower(auth()->user()->role) !== 'jobseeker') {
            return redirect()->route('dashboard')->with('error', 'Only jobseekers can apply for jobs.');
        }

        // For GET requests, show the application form
        if ($request->isMethod('get')) {
            try {
                $jobListing->load('companyProfile');
                return view('job-listings.apply', compact('jobListing'));
            } catch (\Exception $e) {
                \Log::error('Error showing apply form: ' . $e->getMessage());
                return redirect()->back()->with('error', 'There was an error loading the application form. Please try again.');
            }
        }

        // For POST requests, handle the form submission
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_letter' => 'required|string|min:50',
            'experience' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'application_link' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('application_link')) {
                $file = $request->file('application_link');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('resumes', $fileName, 'public');
            }

            // Create the application in the existing table
            $application = Application::create([
                'job_listing_id' => $jobListing->id,
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'cover_letter' => $validated['cover_letter'],
                'experience' => $validated['experience'],
                'additional_notes' => $validated['additional_notes'],
                'application_link' => $filePath
            ]);

            // After successful submission, redirect to dashboard
            return redirect()->route('dashboard')
                ->with('success', 'Your application has been submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Application submission error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your application. Please try again.');
        }
    }
}
