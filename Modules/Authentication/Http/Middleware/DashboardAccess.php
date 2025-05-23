<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Auth;

class DashboardAccess
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if ( auth()->user()->can('dashboard_access') || auth()->user()->can('company_dashboard_access') ){

                if(auth()->user()->status == 0){
                    auth()->logout();
                    return redirect()->route('dashboard.login');
                }
                return $next($request);
            }

            abort(403);
        }

        return $next($request);
    }
}
