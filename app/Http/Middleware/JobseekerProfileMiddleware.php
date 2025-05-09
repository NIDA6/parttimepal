<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobseekerProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if (strtolower($user->role) !== 'jobseeker') {
            return redirect()->route('dashboard')
                ->with('error', 'This section is only available for jobseeker accounts.');
        }

        if (!$user->jobseekerProfile) {
            return redirect()->route('jobseeker.profile.create')
                ->with('error', 'You need to create a jobseeker profile first.');
        }

        return $next($request);
    }
} 