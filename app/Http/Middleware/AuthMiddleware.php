<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Helpers\ApiHelpers;

class AuthMiddleware
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
        // $authCheck = "hXfCbtDs0OA1CttdE77v0L0WduUlggT067AVm5Pxs8NntTX0ZneevByzn9aTl4ZEsmGTEuZ62SyfZ8vooTytfA";
        // dd($request->cookies->all());
        if ($authCheck) {
            $userFound = User::where('token', $authCheck)->first();
            if ($userFound) {
                if ($userFound->verify) {
                    auth()->login($userFound);
                    return $next($request);
                }
                return redirect('/api/getfirstdata');
            }
            $response =  ApiHelpers::jsonError($ret, 'Integrity_error', 'Token Invalid');
            $response = redirect('/login');
            return $response;
        } else {
            $response = ApiHelpers::jsonError($ret, 'Intigrity_error', 'Token not found');
            $response = redirect('/login');
            return $response;
        }
        // return $next($request);
    }
}
