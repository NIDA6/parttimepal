<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CompanyProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('CompanyProfileMiddleware: Checking user access');
        
        $user = $request->user();
        
        if (!$user) {
            Log::error('CompanyProfileMiddleware: No authenticated user found');
            return redirect()->route('login');
        }

        Log::info('CompanyProfileMiddleware: User role', ['role' => $user->role]);
        
        if (strtolower($user->role) !== 'company') {
            Log::error('CompanyProfileMiddleware: User is not a company', ['role' => $user->role]);
            return redirect()->route('dashboard')
                ->with('error', 'This section is only available for company accounts.');
        }

        Log::info('CompanyProfileMiddleware: Checking company profile');
        
        if (!$user->companyProfile) {
            Log::error('CompanyProfileMiddleware: No company profile found');
            return redirect()->route('company.profile.create')
                ->with('error', 'You need to create a company profile first.');
        }

        Log::info('CompanyProfileMiddleware: Access granted');
        return $next($request);
    }
}
