<?php

namespace App\Http\Middleware;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserRoleContract;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    protected $accessManager;

    public function __construct(
        IAccessManager $accessManager
    ) {
        $this->accessManager = $accessManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if ($role) {
            if ($request->user()->role->{ UserRoleContract::FIELD_SLUG } !== $role) {
                abort(403, 'Доступ запрещен!');
            }

            return $next($request);
        }

        $routeName = $request->route()->getName();
        $routeAccess = $this->accessManager->checkRouteAccess($routeName);

        if (!$routeAccess) {
            abort(403, 'Доступ запрещен!');
        }

        return $next($request);
    }
}
