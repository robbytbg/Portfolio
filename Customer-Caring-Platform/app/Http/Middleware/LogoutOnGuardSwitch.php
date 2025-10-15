<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutOnGuardSwitch
{
    public function handle(Request $request, Closure $next)
    {
        $isAdminRoute = str_starts_with($request->route()->getPrefix(), '/admin');
        $isWebGuard = Auth::guard('web')->check();
        $isAdminGuard = Auth::guard('admin')->check();

        Log::info('Current Route Prefix: ' . $request->route()->getPrefix());
        Log::info('Is Admin Route: ' . ($isAdminRoute ? 'Yes' : 'No'));
        Log::info('Is Web Guard Authenticated: ' . ($isWebGuard ? 'Yes' : 'No'));
        Log::info('Is Admin Guard Authenticated: ' . ($isAdminGuard ? 'Yes' : 'No'));

        if ($isWebGuard && $isAdminRoute) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::info('Logged out web guard and invalidated session');
        }

        if ($isAdminGuard && !$isAdminRoute) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::info('Logged out admin guard and invalidated session');
        }

        return $next($request);
    }
}
