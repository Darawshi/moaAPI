<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
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
        if($request -> api_password != env('API_PASSWORD' ,'4p8Vtu8G5WRTse4lkfsoiem')){
            return response() ->json(['message' => __('messages.unauthenticated')]);
        }
        return $next($request);
    }
}
