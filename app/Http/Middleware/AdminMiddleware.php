<?php

namespace App\Http\Middleware;

use App\Helpers\ApiHelpers;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        $ret = ApiHelpers::ret();

        $authCheck = request()->cookie('token');
        // $authCheck = "hXfCbtDs0OA1CttdE77v0L0WduUlggT067AVm5Pxs8NntTX0ZneevByzn9aTl4ZEsmGTEuZ62SyfZ8vooTytfA";a
        if ($authCheck) {
            $userFound = User::where('token', $authCheck)->first();
            if ($userFound && $userFound->role) {
                return $next($request);
            }
            return  ApiHelpers::jsonError($ret, 'Integrity_error', 'User not Admin');
        }
        return  ApiHelpers::jsonError($ret, 'Integrity_error', 'User Invalid');
    }
}
