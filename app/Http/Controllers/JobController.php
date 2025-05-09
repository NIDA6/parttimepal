<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function create()
    {
        return view('jobs.create');
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

        $validated['company_id'] = Auth::user()->company->id;

        Job::create($validated);

        return redirect()->route('dashboard')->with('success', 'Job posted successfully!');
    }
}
