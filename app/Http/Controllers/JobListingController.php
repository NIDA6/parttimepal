<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewJobApplication;
use Illuminate\Support\Facades\Notification;

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
        Log::info('JobListingController@create method called');
        Log::info('User:', ['user' => auth()->user()]);
        
        if (!auth()->user()) {
            Log::error('No authenticated user found');
            return redirect()->route('login');
        }

        if (!auth()->user()->companyProfile) {
            Log::error('No company profile found for user');
            return redirect()->route('company.profile.create')
                ->with('error', 'You need to create a company profile first.');
        }

        return view('job-listings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'salary' => 'required|numeric|between:0,99999999.99',
            'job_time' => 'required|string|max:255',
            'additional_message' => 'nullable|string',
            'application_link' => 'required|url|max:255',
        ]);

        $validated['company_profile_id'] = Auth::user()->companyProfile->id;

        JobListing::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Job posted successfully! You can view it in your job listings below.');
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
            'salary' => 'required|numeric|between:0,99999999.99',
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
        // Add debugging
        \Log::info('Apply method called', [
            'method' => $request->method(),
            'isPost' => $request->isMethod('post'),
            'user' => auth()->user()->id,
            'role' => auth()->user()->role
        ]);

        // Check if user is a jobseeker
        if (strtolower(auth()->user()->role) !== 'jobseeker') {
            \Log::error('User is not a jobseeker', ['user' => auth()->user()]);
            return redirect()->route('dashboard')->with('error', 'Only jobseekers can apply for jobs.');
        }

        // For GET requests, show the application form
        if ($request->isMethod('get')) {
            \Log::info('Showing application form');
            return view('job-listings.apply', compact('jobListing'));
        }

        // For POST requests, handle the form submission
        try {
            \Log::info('Processing POST request', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'cover_letter' => 'required|string|min:50',
                'experience' => 'nullable|string',
                'additional_notes' => 'nullable|string',
                'application_link' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload
            if ($request->hasFile('application_link')) {
                $file = $request->file('application_link');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('resumes', $fileName, 'public');
                
                if (!$filePath) {
                    throw new \Exception('Failed to upload file');
                }
                \Log::info('File uploaded successfully', ['file_path' => $filePath]);
            } else {
                throw new \Exception('No file uploaded');
            }

            // Create the application
            $application = Application::create([
                'job_listing_id' => $jobListing->id,
                'user_id' => auth()->id(),
                'Full Name' => $validated['full_name'],
                'cover_letter' => $validated['cover_letter'],
                'experience' => $validated['experience'] ?? null,
                'additional_notes' => $validated['additional_notes'] ?? null,
                'application_link' => $filePath
            ]);

            if (!$application) {
                throw new \Exception('Failed to create application');
            }

            \Log::info('Application created successfully', ['application_id' => $application->id]);

            // Send notification to the company
            $companyUser = $jobListing->companyProfile->user;
            $companyUser->notify(new NewJobApplication($application));

            \Log::info('Notification sent to company', ['company_user_id' => $companyUser->id]);

            return redirect()->route('dashboard')
                ->with('success', 'Your application has been submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Application submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your application: ' . $e->getMessage());
        }
    }
}
