<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use function strcasecmp;
use function strtolower;

class CompanyProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Temporarily bypass all checks for testing
        return $next($request);
        
        /*
        Log::info('CompanyProfileMiddleware: Checking user access');
        
        $user = $request->user();
        
        if (!$user) {
            Log::error('CompanyProfileMiddleware: No authenticated user found');
            return redirect()->route('login');
        }

        Log::info('CompanyProfileMiddleware: User info', [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'has_company_profile' => $user->companyProfile ? 'Yes' : 'No'
        ]);
        
        // Check if user has the company role (case-insensitive)
        if (strtolower($user->role) !== 'company') {
            Log::error('CompanyProfileMiddleware: User does not have company role', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'expected_role' => 'company',
                'all_user_attributes' => $user->toArray()
            ]);
            return redirect()->route('dashboard')
                ->with('error', 'This section is only available for company accounts.');
        }

        Log::info('CompanyProfileMiddleware: Checking company profile');
        
        if (!$user->companyProfile) {
            Log::error('CompanyProfileMiddleware: No company profile found for company user', [
                'user_id' => $user->id,
                'user_role' => $user->role
            ]);
            return redirect()->route('company.profile.create')
                ->with('error', 'You need to create a company profile first.');
        }
        */

        Log::info('CompanyProfileMiddleware: Access granted');
        return $next($request);
    }
}
