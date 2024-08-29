<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActiveStatus
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
        if (Auth::check() && Auth::user()->status !== 'active') {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Your account is inactive.',
            ]);
        }

        return $next($request);
    }
}
