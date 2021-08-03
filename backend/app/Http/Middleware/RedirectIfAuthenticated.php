<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    //public function handle(Request $request, Closure $next, ...$guards)
    //{
        //$guards = empty($guards) ? [null] : $guards;

        //foreach ($guards as $guard) {
            //if (Auth::guard($guard)->check()) {
                //return redirect(RouteServiceProvider::HOME);   // 初期はRouteServiceProviderを呼び出してる
            //}
        //}
        //return $next($request);
    //}

    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if ($guard == "admin-higher" && Auth::guard($guard)->check()) {
                return redirect()->route('admin-home');
            }
            if ($guard == "user-higher" && Auth::guard($guard)->check()) {
                return redirect()->route('home');
            }
        }
        return $next($request);
    }

    //public function handle(Request $request)
    //{
        //if (method_exists($this, 'login')) {
            //return $this->login();
        //}

        //return property_exists($this, 'login') ? $this->login : '/home';
    //}
}
