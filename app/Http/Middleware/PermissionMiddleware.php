<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // skip is not authenticated
        if (!auth()->check()) {
            return $next($request);
        }

        // skip route tertentu 
        $exceptRoutes = [
            'login',
            'logout',
            'password.*',
            'register',
            'verification.*',
            'profile.*',
            'dashboard',
        ];

        foreach ($exceptRoutes as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }

        $action = $request->route()->getAction();

        if (isset($action['controller'])) {

            [$controller, $method] = explode('@', $action['controller']);

            $controller = class_basename($controller);
            $prefix = strtolower(str_replace('Controller', '', $controller));

            $permission = "{$prefix}.{$method}";

            abort_unless(auth()->user()?->can($permission), 403);
        }

        return $next($request);
    }
}
