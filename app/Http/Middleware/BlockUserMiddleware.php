<?php

namespace App\Http\Middleware;

use App\Helpers\ApiHelpers;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlockUserMiddleware
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

        $userToken = request()->cookie('token'); // Get the authenticated user token

        if ($userToken) {
            $user = User::where('token', $userToken)->first();

            if ($userToken) {
                $user = User::where('token', $userToken)->first();

                if ($user) {
                    $userId = $user->user_id;
                    $rateLimitKey = 'rate_limit:' . $userId;
                    $maxRequests = 5;
                    $decayMinutes = 60;

                    $userIP = $request->ip();
                    $ipRateLimitKey = 'ip_rate_limit:' . $userIP;

                    $requestCount = Cache::get($rateLimitKey, 0);
                    $currentTime = Carbon::now();
                    $ipRequestCount = Cache::get($ipRateLimitKey, 0);

                    if (!$requestCount || $currentTime->diffInMinutes(Cache::get($rateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
                        Cache::put($rateLimitKey, 1, $decayMinutes);
                        Cache::put($rateLimitKey . '_time', $currentTime, $decayMinutes);
                    } else {
                        Cache::increment($rateLimitKey);
                    }
                    if (!$ipRequestCount || $currentTime->diffInMinutes(Cache::get($ipRateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
                        Cache::put($ipRateLimitKey, 1, $decayMinutes);
                        Cache::put($ipRateLimitKey . '_time', $currentTime, $decayMinutes);
                    } else {
                        Cache::increment($ipRateLimitKey);
                    }

                    if ($requestCount >= $maxRequests) {
                        $response =  ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded');
                        // $response = view('auth.login')->with(['blocked' => 'Blocked User']);
                        return $response;
                    }
                }
            }
        }
        return $next($request);
    }
}
