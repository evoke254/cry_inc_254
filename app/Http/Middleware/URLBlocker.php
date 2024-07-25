<?php

namespace App\Http\Middleware;

use App\Providers\Admin\BasicSettingsProvider;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class URLBlocker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $route_block_list = [];
            $basic_settings = BasicSettingsProvider::get();
            if(!$basic_settings->user_registration) {
                array_push($route_block_list,'user.register');
            }

            if(in_array(Route::currentRouteName(), $route_block_list)) return abort(404);
        }catch(Exception $e) {
            // handle error
        }

        return $next($request);
    }
}
