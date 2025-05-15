<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'Admin') {
            $totalJobseekers = User::where('role', 'jobseeker')->count();
            $totalCompanies = User::where('role', 'company')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalUsers = User::count();
            
            return view('dashboard.admindashboard', compact('totalJobseekers', 'totalCompanies', 'totalAdmins', 'totalUsers'));
        } elseif ($user->role === 'Company') {
            return view('dashboard.companydashboard');
        } else {
            // For jobseekers, fetch all active job listings with company information
            $jobListings = JobListing::with(['companyProfile' => function($query) {
                $query->select('id', 'company_name');
            }])
            ->whereDoesntHave('applications', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();
            
            // Get user's applications
            $applications = Application::with(['jobListing', 'jobListing.companyProfile'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
                
            // Get confirmed jobs (where status is 'shortlisted' or 'hired')
            $confirmedJobs = $applications->whereIn('status', ['shortlisted', 'hired']);
                
            return view('dashboard.jobseekerdashboard', compact(
                'jobListings',
                'applications',
                'confirmedJobs'
            ));
        }
    }
} 