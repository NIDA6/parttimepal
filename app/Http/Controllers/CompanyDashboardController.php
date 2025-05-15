<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = Auth::user()->companyProfile;
        $jobListings = JobListing::where('company_profile_id', $company->id)->withCount('applications')->latest()->get();
        
        return view('dashboard.company', compact('jobListings'));
    }

    public function applications()
    {
        $company = Auth::user()->companyProfile;
        $applications = Application::whereHas('jobListing', function($query) use ($company) {
            $query->where('company_profile_id', $company->id);
        })->with(['jobListing', 'user'])->latest()->paginate(10);
        
        return view('company.applications.index', compact('applications'));
    }

    public function showApplication(Application $application)
    {
        // Ensure the application belongs to a job listing owned by the company
        if ($application->jobListing->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $application->load(['jobListing', 'user']);
        
        return view('company.applications.show', compact('application'));
    }

    public function updateStatus(Application $application, $status)
    {
        // Ensure the application belongs to a job listing owned by the company
        if ($application->jobListing->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $validStatuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }

        try {
            // Update the application status
            $application->update(['status' => $status]);
            
            return redirect()->back()->with('success', 'Application status updated successfully');
            
        } catch (\Exception $e) {
            Log::error('Error updating application status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the application status.');
        }
    }
}
