<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function create()
    {
        return view('job-posts.create');
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

        JobPost::create($validated);

        return redirect()->route('dashboard')->with('success', 'Job posted successfully!');
    }
}
