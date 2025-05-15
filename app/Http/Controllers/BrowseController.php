<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\JobseekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrowseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $type = $request->input('type', 'all'); // all, companies, or jobseekers

        $companies = collect();
        $jobseekers = collect();
        if (!empty($search)) {
            if ($type === 'all' || $type === 'companies') {
                $companies = User::where('role', 'Company')
                    ->where(function ($query) use ($search) {
                        // Split search terms by spaces
                        $terms = explode(' ', $search);
                        
                        foreach ($terms as $term) {
                            $term = trim($term);
                            if (!empty($term)) {
                                $query->orWhere(function ($q) use ($term) {
                                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . Str::lower($term) . '%'])
                                        ->orWhereHas('companyProfile', function ($q) use ($term) {
                                            $q->whereRaw('LOWER(company_name) LIKE ?', ['%' . Str::lower($term) . '%'])
                                                ->orWhereRaw('LOWER(description) LIKE ?', ['%' . Str::lower($term) . '%']);
                                        });
                                });
                            }
                        }
                    })
                    ->with('companyProfile')
                    ->get();
            }

            if ($type === 'all' || $type === 'jobseekers') {
                $jobseekers = User::where('role', 'Jobseeker')
                    ->where(function ($query) use ($search) {
                        // Split search terms by spaces
                        $terms = explode(' ', $search);
                        
                        foreach ($terms as $term) {
                            $term = trim($term);
                            if (!empty($term)) {
                                $query->orWhere(function ($q) use ($term) {
                                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . Str::lower($term) . '%'])
                                        ->orWhereHas('jobseekerProfile', function ($q) use ($term) {
                                            $q->whereRaw('LOWER(skills) LIKE ?', ['%' . Str::lower($term) . '%'])
                                                ->orWhereRaw('LOWER(address) LIKE ?', ['%' . Str::lower($term) . '%'])
                                                ->orWhereHas('education', function ($q) use ($term) {
                                                    $q->whereRaw('LOWER(school_name) LIKE ?', ['%' . Str::lower($term) . '%'])
                                                        ->orWhereRaw('LOWER(college_name) LIKE ?', ['%' . Str::lower($term) . '%'])
                                                        ->orWhereRaw('LOWER(university_name) LIKE ?', ['%' . Str::lower($term) . '%']);
                                                });
                                        });
                                });
                            }
                        }
                    })
                    ->with(['jobseekerProfile.education', 'jobseekerProfile.workplaces'])
                    ->get();
            }
        }

        return view('browse.index', compact('companies', 'jobseekers', 'search', 'type'));
    }

    public function showCompany($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'Company') {
            abort(404);
        }

        $companyProfile = $user->companyProfile;
        return view('profile.company.show', compact('companyProfile'));
    }

    public function showJobseeker($id)
    {
        $user = User::with(['jobseekerProfile.education', 'jobseekerProfile.workplaces'])->findOrFail($id);
        if ($user->role !== 'Jobseeker') {
            abort(404);
        }

        $jobseekerProfile = $user->jobseekerProfile;
        return view('profile.jobseeker.show', compact('jobseekerProfile'));
    }
} 