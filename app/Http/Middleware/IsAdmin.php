<?php
namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->role == 'admin') { // or can write isAdminUser method on User model and call here Auth::user()->isAdminUser
             return $next($request);
        }

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'error',
            'data'      => 'You have not admin access'
        ],422));
    }
}
