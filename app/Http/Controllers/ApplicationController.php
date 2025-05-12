<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = auth()->user()->companyProfile->jobListings()
            ->with(['applications' => function ($query) {
                $query->with('user.jobseekerProfile');
            }])
            ->get()
            ->pluck('applications')
            ->flatten();

        return view('applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        // Check if the application belongs to one of the company's job listings
        if ($application->jobListing->company_profile_id !== auth()->user()->companyProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        // Check if the application belongs to one of the company's job listings
        if ($application->jobListing->company_profile_id !== auth()->user()->companyProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
} 