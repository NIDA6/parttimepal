<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'Admin') {
            return view('dashboard.admindashboard');
        } elseif ($user->role === 'Company') {
            return view('dashboard.companydashboard');
        } else {
            // For jobseekers, fetch all active job listings with company information
            $jobListings = JobListing::with(['companyProfile' => function($query) {
                $query->select('id', 'company_name');
            }])
            ->latest()
            ->get();
                
            return view('dashboard.jobseekerdashboard', compact('jobListings'));
        }
    }
} 