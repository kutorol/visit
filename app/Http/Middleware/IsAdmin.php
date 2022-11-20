<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->role === User::ROLE_ADMIN) {
            return $next($request);
        }

        return self::getResponse($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function getResponse(Request $request)
    {
        if (!$request->wantsJson() && !$request->is('api/*')) {
            return redirect("/");
        }

        return response()->json(
            BaseController::errorResponse(__("auth.bad_role"), [], BaseController::FORBIDDEN_CODE),
            BaseController::FORBIDDEN_CODE
        );
    }
}
