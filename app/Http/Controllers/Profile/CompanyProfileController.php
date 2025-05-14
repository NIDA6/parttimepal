<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyProfile;

class CompanyProfileController extends Controller
{
    public function create(): View
    {
        $user = Auth::user();
        $profile = $user->companyProfile;
        return view('profile.company.create', compact('user', 'profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'establish_date' => ['required', 'date'],
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $profile = $user->companyProfile;

            if ($profile) {
                // Update 
                $profile->update([
                    'company_name' => $validated['company_name'],
                    'description' => $validated['description'],
                    'website_url' => $validated['website_url'],
                    'location' => $validated['location'],
                    'phone_number' => $validated['phone_number'],
                    'establish_date' => $validated['establish_date'],
                ]);

                Log::info('Profile updated', [
                    'user_id' => $user->id,
                    'profile_id' => $profile->id,
                    'role' => $user->role
                ]);
            } else {
                // Create new profile
                $profile = CompanyProfile::create([
                    'user_id' => $user->id,
                    'company_name' => $validated['company_name'],
                    'description' => $validated['description'],
                    'website_url' => $validated['website_url'],
                    'location' => $validated['location'],
                    'phone_number' => $validated['phone_number'],
                    'establish_date' => $validated['establish_date'],
                    'company_email' => $user->email,
                ]);

                Log::info('Profile created', [
                    'user_id' => $user->id,
                    'profile_id' => $profile->id,
                    'role' => $user->role
                ]);
            }

            // Handle social media links
            if (!empty($validated['url'])) {
                foreach ($validated['url'] as $url) {
                    if (!empty($url)) {
                        $profile->socialMedia()->create([
                            'platform' => 'Social Media',
                            'url' => $url,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Company profile creation/update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            return back()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }

    public function edit(): View|RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->companyProfile;

        if (!$profile) {
            return redirect()->route('company.profile.create')
                ->with('error', 'Please create your company profile first.');
        }

        // Load the socialMedia relationship
        $profile->load('socialMedia');

        return view('profile.company.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'establish_date' => ['required', 'date'],
            'url' => ['nullable', 'array'],
            'url.*' => ['nullable', 'url', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $profile = $user->companyProfile;
            
            $profile->update([
                'company_name' => $validated['company_name'],
                'phone_number' => $validated['phone'],
                'location' => $validated['address'],
                'description' => $validated['description'],
                'website_url' => $validated['website'],
                'establish_date' => $validated['establish_date'],
            ]);

            // Delete existing social media records
            $profile->socialMedia()->delete();

            // Create new social media records
            if (!empty($validated['url'])) {
                foreach ($validated['url'] as $url) {
                    if (!empty($url)) {
                        $profile->socialMedia()->create([
                            'platform' => 'Social Media',
                            'url' => $url,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function show(CompanyProfile $companyProfile): View
    {
        // Load the relationships without the status filter
        $companyProfile->load(['socialMedia', 'jobListings' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('profile.company.show', compact('companyProfile'));
    }
} 