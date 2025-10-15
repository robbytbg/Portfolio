<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if ($request->user() && $request->user()->can($permission)) {
            return $next($request);
        }
        Auth::logout();

        return response()->view('unauthorized', [], 403);
    }
}
