<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth('api')->user()->status == 0){
            return (new ApiController)->error(__('user::api.users.user_blocked'));
        }
        return $next($request);
    }
}
