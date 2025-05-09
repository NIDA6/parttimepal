<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\JobseekerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class JobseekerProfileController extends Controller
{
    public function create(): View
    {
        
        $user = Auth::user();
        $profile = $user->jobseekerProfile;
        $education = $profile ? $profile->education : null;
        $workplaces = $profile ? $profile->workplaces : null;

        return view('profile.jobseeker.create', compact('user', 'profile', 'education', 'workplaces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_year' => ['nullable', 'string', 'max:4'],
            'college_name' => ['nullable', 'string', 'max:255'],
            'college_year' => ['nullable', 'string', 'max:4'],
            'university_name' => ['nullable', 'array'],
            'university_name.*' => ['nullable', 'string', 'max:255'],
            'university_year' => ['nullable', 'array'],
            'university_year.*' => ['nullable', 'string', 'max:4'],
            'workplace_name' => ['nullable', 'array'],
            'workplace_name.*' => ['nullable', 'string', 'max:255'],
            'workplace_designation' => ['nullable', 'array'],
            'workplace_designation.*' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $profile = $user->jobseekerProfile;

            if ($profile) {
                // Update existing profile
                $profile->update([
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'skills' => $validated['skills'],
                ]);

                // Delete existing education and workplace records
                $profile->education()->delete();
                $profile->workplaces()->delete();
            } else {
                // Create new profile
                $profile = JobseekerProfile::create([
                    'user_id' => $user->id,
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'skills' => $validated['skills'],
                ]);

                // Debug information
                Log::info('Profile created', [
                    'user_id' => $user->id,
                    'profile_id' => $profile->id,
                    'role' => $user->role
                ]);
            }

            // Create education records
            if (!empty($validated['school_name'])) {
                $profile->education()->create([
                    'school_name' => $validated['school_name'],
                    'school_year' => $validated['school_year'],
                ]);
            }

            if (!empty($validated['college_name'])) {
                $profile->education()->create([
                    'college_name' => $validated['college_name'],
                    'college_year' => $validated['college_year'],
                ]);
            }

            if (!empty($validated['university_name'])) {
                foreach ($validated['university_name'] as $index => $uniName) {
                    if (!empty($uniName)) {
                        $profile->education()->create([
                            'university_name' => $uniName,
                            'university_year' => $validated['university_year'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Create workplace records
            if (!empty($validated['workplace_name'])) {
                foreach ($validated['workplace_name'] as $index => $companyName) {
                    if (!empty($companyName)) {
                        $profile->workplaces()->create([
                            'company_name' => $companyName,
                            'designation' => $validated['workplace_designation'][$index] ?? '',
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function edit(): View|RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->jobseekerProfile;

        if (!$profile) {
            return redirect()->route('jobseeker.profile.create')
                ->with('error', 'Please create your profile first.');
        }

        $education = $profile->education;
        $workplaces = $profile->workplaces;

        return view('profile.jobseeker.edit', compact('user', 'profile', 'education', 'workplaces'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_year' => ['nullable', 'string', 'max:4'],
            'college_name' => ['nullable', 'string', 'max:255'],
            'college_year' => ['nullable', 'string', 'max:4'],
            'university_name' => ['nullable', 'array'],
            'university_name.*' => ['nullable', 'string', 'max:255'],
            'university_year' => ['nullable', 'array'],
            'university_year.*' => ['nullable', 'string', 'max:4'],
            'workplace_name' => ['nullable', 'array'],
            'workplace_name.*' => ['nullable', 'string', 'max:255'],
            'workplace_designation' => ['nullable', 'array'],
            'workplace_designation.*' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            
            $user = Auth::user();
            $profile = $user->jobseekerProfile;

            if ($profile) {
                // Update existing profile
                $profile->update([
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'skills' => $validated['skills'],
                ]);

                // Delete existing education and workplace records
                $profile->education()->delete();
                $profile->workplaces()->delete();
            } else {
                // Create new profile
                $profile = JobseekerProfile::create([
                    'user_id' => $user->id,
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'skills' => $validated['skills'],
                ]);
            }

            // Create education records
            if (!empty($validated['school_name'])) {
                $profile->education()->create([
                    'school_name' => $validated['school_name'],
                    'school_year' => $validated['school_year'],
                ]);
            }

            if (!empty($validated['college_name'])) {
                $profile->education()->create([
                    'college_name' => $validated['college_name'],
                    'college_year' => $validated['college_year'],
                ]);
            }

            if (!empty($validated['university_name'])) {
                foreach ($validated['university_name'] as $index => $uniName) {
                    if (!empty($uniName)) {
                        $profile->education()->create([
                            'university_name' => $uniName,
                            'university_year' => $validated['university_year'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Create workplace records
            if (!empty($validated['workplace_name'])) {
                foreach ($validated['workplace_name'] as $index => $companyName) {
                    if (!empty($companyName)) {
                        $profile->workplaces()->create([
                            'company_name' => $companyName,
                            'designation' => $validated['workplace_designation'][$index] ?? '',
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        }  
        catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    } 
}