<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Customer
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
            return redirect()->route('SystemadminDashboard');
        }

        if(Auth::user()->role == 'supplier') {
            return redirect()->route('Supplier');
        }

        if (Auth::user()->role == 'storeadmin' || Auth::user()->role == 'staff' ) {
            return redirect()->route('StoreDashboard');
        }

        if (Auth::user()->role == 'customer') {
            return $next($request);
        }
    }
}
