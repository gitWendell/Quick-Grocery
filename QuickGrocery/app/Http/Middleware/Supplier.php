<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Supplier
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
        if(!Auth::check()){
            return redirect()->route('login');
        }

        if(Auth::user()->role == 'systemadmin') {
            return redirect()->route('SystemAdmin');
        }

        if(Auth::user()->role == 'supplier') {
            return $next($request);
        }

        if (Auth::user()->role == 'customer') {
            return redirect()->route('CustomerDashboard');
        }

        if (Auth::user()->role == 'staff' || Auth::user()->role == 'storeadmin' ) {
            return redirect()->route('StoreDashboard');
        }
    }
}
