<?php

namespace AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use AwemaPL\BaselinkerClient\Facades\BaselinkerClient;

class Installation
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (BaselinkerClient::canInstallation()){
            $route = Route::getRoutes()->match($request);
            $name = $route->getName();
            if (!in_array($name, config('baselinker-client.routes.admin.installation.expect'))){
                return redirect()->route('baselinker_client.admin.installation.index');
            }
        }
        return $next($request);
    }
}
