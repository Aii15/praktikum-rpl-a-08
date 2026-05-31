<?php

namespace App\Http\Middleware;
/* middleware untuk memeriksa role aktif pada sesi */

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:mitra') or ->middleware('role:mitra,admin')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $activeRole = $request->session()->get('active_role');

        if ($activeRole) {
            if (in_array($activeRole, $roles, true) && $user->hasRole($activeRole)) {
                return $next($request);
            }

            if (collect($roles)->contains(fn ($role) => $user->hasRole($role))) {
                return redirect()->route('role.choose');
            }

            abort(403);
        }

        $userRoles = $user->roles()->pluck('name')->all();

        if (count($userRoles) > 1) {
            return redirect()->route('role.choose');
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
