<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,jobseeker,company'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'User created successfully.');
    }

    public function jobseekers()
    {
        $jobseekers = User::where('role', 'jobseeker')
            ->with('jobseekerProfile')
            ->latest()
            ->paginate(10);

        return view('admin.users.jobseekers', compact('jobseekers'));
    }

    public function companies()
    {
        $companies = User::where('role', 'company')
            ->with('companyProfile')
            ->latest()
            ->paginate(10);

        return view('admin.users.companies', compact('companies'));
    }

    public function admins()
    {
        $admins = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.users.admins', compact('admins'));
    }

    public function destroyJobseeker(User $user)
    {
        if ($user->role !== 'jobseeker') {
            return redirect()->route('admin.jobseekers')
                ->with('error', 'Invalid user type.');
        }

        try {
            DB::beginTransaction();
            
            // Delete related jobseeker profile if exists
            if ($user->jobseekerProfile) {
                $user->jobseekerProfile->delete();
            }

            // Delete the user
            $user->delete();

            DB::commit();

            return redirect()->route('admin.jobseekers')
                ->with('success', 'Jobseeker deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.jobseekers')
                ->with('error', 'Failed to delete jobseeker. Please try again.');
        }
    }

    public function destroyCompany(User $user)
    {
        if ($user->role !== 'company') {
            return redirect()->route('admin.companies')
                ->with('error', 'Invalid user type.');
        }

        try {
            DB::beginTransaction();
            
            // Delete related company profile if exists
            if ($user->companyProfile) {
                $user->companyProfile->delete();
            }

            // Delete any job listings associated with this company
            if ($user->jobListings) {
                $user->jobListings->each->delete();
            }

            // Delete the user
            $user->delete();

            DB::commit();

            return redirect()->route('admin.companies')
                ->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.companies')
                ->with('error', 'Failed to delete company. Please try again.');
        }
    }

    public function showJobseeker(User $user)
    {
        // Load only the jobseeker profile and education
        $user->load(['jobseekerProfile.education']);
        
        return view('admin.users.show-jobseeker', compact('user'));
    }

    public function showCompany(User $user)
    {
        try {
            // Load the company profile
            $user->load('companyProfile');
            
            // Check if user is a company (case-insensitive)
            if (strtolower($user->role) !== 'company') {
                return redirect()->route('admin.companies')
                    ->with('error', 'Invalid user type. User role is: ' . $user->role);
            }

            // Get company profile data
            $companyProfile = $user->companyProfile;

            if (!$companyProfile) {
                return redirect()->route('admin.companies')
                    ->with('error', 'Company profile not found for user ID: ' . $user->id);
            }

            return view('admin.users.show-company', compact('user', 'companyProfile'));
        } catch (\Exception $e) {
            return redirect()->route('admin.companies')
                ->with('error', 'Error loading company details: ' . $e->getMessage());
        }
    }
} 