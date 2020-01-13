<?php

namespace App\Http\Middleware;

use Closure;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user('api') == null) {
            abort(403);
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;
        if ($request->user('api')->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        abort(403);
    }
}
