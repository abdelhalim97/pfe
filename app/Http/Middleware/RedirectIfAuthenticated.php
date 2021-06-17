<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch($guard){
            case 'moderator';
            if(Auth::guard($guard)->check()){

                return redirect()->route('moderator.dashboard');
            }

            case 'admin';
            if(Auth::guard('moderator')->check()){
                return redirect()->route('moderator.dashboard');
            }
            case 'admin.login';
            if(Auth::guard('moderator')->check()){
                return redirect()->route('moderator.dashboard');
            }
            case 'modertor.login';
            if(Auth::guard('admin')->check()){
                return redirect()->route('admin.dashboard');
            }

            // case 'login';
            // if(Auth::guard('moderator')->check()){
            //     return redirect()->route('moderator.dashboard');
            // }

            case 'admin';
            if(Auth::guard($guard)->check()){
                return redirect()->route('admin.dashboard');
                //if we logged in as admin and try to access admin.login it send us back to admin.dashboard
            }
        break;
        default: if(Auth::guard('web')->check()){ //if we logged in as user and try access /login it redirect us to home
            return redirect('/home');
        }
    break;
        }
        return $next($request); //otherwise it continue the request
    }
}
