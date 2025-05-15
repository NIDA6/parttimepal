<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Application;
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
        Log::info('User:', ['user' => Auth::user()]);
        
        if (!Auth::check()) {
            Log::error('No authenticated user found');
            return redirect()->route('login');
        }

        if (Auth::user()->companyProfile === null) {
            return redirect()->route('company.profile.create')
                ->with('error', 'You need to create a company profile first.');
        }

        return view('job-listings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_time' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'additional_message' => 'nullable|string',
            //'application_link' => 'required|url|max:255',
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
            Log::error('Error showing job listing: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'The job listing you are looking for could not be found.');
        }
    }

    public function edit(JobListing $jobListing)
    {
        // Check if the user owns this job listing
        if ($jobListing->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('job-listings.edit', compact('jobListing'));
    }

    public function update(Request $request, JobListing $jobListing)
    {
        // Check if the user owns this job listing
        if ($jobListing->company_profile_id !== Auth::user()->companyProfile->id) {
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
            Log::error('Error updating job listing: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error updating the job listing. Please try again.');
        }
    }

    public function apply(Request $request, JobListing $jobListing)
    {
        $user = Auth::user();
        
        //  user and role information
        $debugInfo = [
            'method' => $request->method(),
            'isPost' => $request->isMethod('post'),
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'role_lower' => $user ? strtolower($user->role) : null,
            'is_jobseeker' => $user && strtolower($user->role) === 'jobseeker' ? 'yes' : 'no'
        ];
        
        Log::info('Job Application Debug:', $debugInfo);

        // Check if user is a jobseeker
        if (!$user || strtolower($user->role) !== 'jobseeker') {
            Log::warning('Access denied - User is not a jobseeker', $debugInfo);
            return redirect()->route('dashboard')
                ->with('error', 'Only jobseekers can apply for jobs. Your current role is: ' . ($user->role ?? 'guest'));
        }

        // For GET requests, show the application form
        if ($request->isMethod('get')) {
            Log::info('Showing application form');
            return view('job-listings.apply', compact('jobListing'));
        }

        // For POST requests, handle the form submission
        try {
            Log::info('Processing POST request', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'cover_letter' => 'required|string|min:50',
                'additional_notes' => 'nullable|string',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
            ]);

            $user = Auth::user();
            Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('resumes', $fileName, 'public');
                
                if (!$filePath) {
                    throw new \Exception('Failed to upload file');
                }
                Log::info('File uploaded successfully', ['file_path' => $filePath]);
            } else {
                throw new \Exception('No file uploaded');
            }

            // Create the application
            $application = Application::create([
                'job_listing_id' => $jobListing->id,
                'user_id' => $user->id,
                'name' => $validated['full_name'],
                'cover_letter' => $validated['cover_letter'],
                'additional_notes' => $validated['additional_notes'] ?? null,
                'application_link' => $filePath
                // status has a default value of 'pending' in the database
            ]);

            if (!$application) {
                throw new \Exception('Failed to create application');
            }

            Log::info('Application created successfully', ['application_id' => $application->id]);

            // Send notification to the company
            $companyUser = $jobListing->companyProfile->user;
            $companyUser->notify(new NewJobApplication($application));

            Log::info('Notification sent to company', ['company_user_id' => $companyUser->id]);

            // Redirect to the applied jobs page with success message
            return redirect()->route('jobs.applied')
                ->with('success', 'Your application for ' . $jobListing->title . ' has been submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Application submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your application: ' . $e->getMessage());
        }
    }

    /**
     * Show all jobs applied by the authenticated jobseeker
     *
     * @return \Illuminate\View\View
     */
    public function appliedJobs()
    {
        $applications = Application::with(['jobListing.companyProfile'])
            ->where('user_id', Auth::id())
            ->whereNotIn('status', ['shortlisted', 'hired'])
            ->latest()
            ->paginate(10);
            
        return view('job-listings.applied', compact('applications'));
    }

    /**
     * Show all confirmed jobs for the authenticated jobseeker
     *
     * @return \Illuminate\View\View
     */
    public function confirmedJobs()
    {
        $applications = Application::with(['jobListing.companyProfile'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['shortlisted', 'hired'])
            ->latest()
            ->paginate(10);
            
        return view('job-listings.confirmed', compact('applications'));
    }

    /**
     * Undo a job application (only if status is pending)
     *
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function undoApplication(Application $application)
    {
        // Check if the authenticated user owns this application
        if (Auth::id() !== $application->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the application status is pending
        if ($application->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'You can only withdraw pending applications.');
        }

        try {
            // Delete the application
            $application->delete();

            return redirect()->route('jobs.applied')
                ->with('success', 'Application withdrawn successfully.');
        } catch (\Exception $e) {
            Log::error('Error withdrawing application: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while withdrawing the application.');
        }
    }
}
