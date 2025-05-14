<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserSession;

class HandleConcurrentLogins
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentSessionId = Session::getId();

            // Create or update the session record
            UserSession::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'session_id' => $currentSessionId
                ],
                [
                    'last_activity' => now()
                ]
            );

            // Clean up old sessions (optional)
            UserSession::where('user_id', $user->id)
                ->where('last_activity', '<', now()->subHours(2))
                ->delete();
        }

        return $next($request);
    }
} 