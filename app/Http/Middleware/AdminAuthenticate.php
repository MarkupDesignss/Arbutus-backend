<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Admin logged in?
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login first');
        }

        // ✅ Admin active?
        if (Auth::guard('admin')->user()->status != 1) {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')
                ->with('error', 'Your account is inactive');
        }

        return $next($request);
    }
}
