<?php

namespace App\Http\Middleware;

use App\Helpers\ApiHelpers;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class BlockUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof ThrottleRequestsException) {
    //         return response()->json([
    //             'error' => 'Rate limit exceeded. Please try again later.',
    //         ], 429);
    //     }

    //     return parent::render($request, $exception);
    // }
    // public function handle(Request $request, Closure $next)
    // {
    //     $ret = ApiHelpers::ret();

    //     $userIP = $request->ip(); // Get the authenticated user token

    //     if ($userIP) {
    //         $user = User::where('token', $userIP)->first();

    //         if ($userIP) {
    //             $user = User::where('token', $userIP)->first();

    //             if ($user) {
    //                 $userId = $user->user_id;
    //                 $rateLimitKey = 'rate_limit:' . $userId;
    //                 $maxRequests = 5;
    //                 $decayMinutes = 60;

    //                 $userIP = $request->ip();
    //                 $ipRateLimitKey = 'ip_rate_limit:' . $userIP;

    //                 $requestCount = Cache::get($rateLimitKey, 0);
    //                 $currentTime = Carbon::now();
    //                 $ipRequestCount = Cache::get($ipRateLimitKey, 0);

    //                 if (!$requestCount || $currentTime->diffInMinutes(Cache::get($rateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
    //                     Cache::put($rateLimitKey, 1, $decayMinutes);
    //                     Cache::put($rateLimitKey . '_time', $currentTime, $decayMinutes);
    //                 } else {
    //                     Cache::increment($rateLimitKey);
    //                 }
    //                 if (!$ipRequestCount || $currentTime->diffInMinutes(Cache::get($ipRateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
    //                     Cache::put($ipRateLimitKey, 1, $decayMinutes);
    //                     Cache::put($ipRateLimitKey . '_time', $currentTime, $decayMinutes);
    //                 } else {
    //                     Cache::increment($ipRateLimitKey);
    //                 }

    //                 if ($requestCount >= $maxRequests) {
    //                     $response =  ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded');
    //                     // $response = view('auth.login')->with(['blocked' => 'Blocked User']);
    //                     return $response;
    //                 }
    //             }
    //         }
    //     }
    //     return $next($request);
    // }
    // public function handle(Request $request, Closure $next)
    // {
    //     $ret = ApiHelpers::ret();
    //     $userIP = $request->ip();

    //     $ipRateLimitKey = 'ip_rate_limit:' . $userIP;
    //     $maxRequests = 5;
    //     $decayMinutes = 60;
    //     $blockDuration = 60; // Block the user for one hour (60 minutes)

    //     $ipRequestCount = Cache::get($ipRateLimitKey, 0);
    //     $currentTime = now();

    //     if (!$ipRequestCount || $currentTime->diffInMinutes(Cache::get($ipRateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
    //         Cache::put($ipRateLimitKey, 1, $decayMinutes);
    //         Cache::put($ipRateLimitKey . '_time', $currentTime, $decayMinutes);
    //     } else {
    //         Cache::increment($ipRateLimitKey);
    //     }

    //     $remainingAttempts = $maxRequests - $ipRequestCount;

    //     if ($ipRequestCount >= $maxRequests) {
    //         // Block the user for the specified duration
    //         Cache::put($ipRateLimitKey . '_blocked', true, $blockDuration * 60);

    //         $response = ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded', ['attempts_remaining' => 0]);
    //         return $response;
    //     }

    //     // Check if the user is blocked
    //     $isBlocked = Cache::get($ipRateLimitKey . '_blocked', false);
    //     if ($isBlocked) {
    //         $response = ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded', ['attempts_remaining' => 0]);
    //         return $response;
    //     }

    //     // If you want to include remaining attempts in the response for non-blocked users
    //     $response = $next($request);

    //     // Modify the response data to include attempts_remaining
    //     $responseData = $response->getData(true);
    //     $responseData['attempts_remaining'] = $remainingAttempts;

    //     // Update the response with the modified data
    //     $response->setData($responseData);

    //     return $response;
    // }
    public function handle(Request $request, Closure $next)
    {
        $ret = ApiHelpers::ret();
        $userIP = $request->ip();

        $ipRateLimitKey = 'ip_rate_limit:' . $userIP;
        $maxRequests = 5;
        $decayMinutes = 60;
        $blockDuration = 60; // Block the user for one hour (60 minutes)

        $ipRequestCount = Cache::get($ipRateLimitKey, 0);
        $currentTime = now();

        if (!$ipRequestCount || $currentTime->diffInMinutes(Cache::get($ipRateLimitKey . '_time', $currentTime)) >= $decayMinutes) {
            Cache::put($ipRateLimitKey, 1, $decayMinutes);
            Cache::put($ipRateLimitKey . '_time', $currentTime, $decayMinutes);
        } else {
            Cache::increment($ipRateLimitKey);
        }

        $remainingAttempts = $maxRequests - $ipRequestCount;

        if ($ipRequestCount >= $maxRequests) {
            // Block the user for the specified duration
            Cache::put($ipRateLimitKey . '_blocked', true, $blockDuration * 60);

            $response = ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded', ['attempts_remaining' => $remainingAttempts]);
            return $response;
        }

        // Check if the user is blocked
        $isBlocked = Cache::get($ipRateLimitKey . '_blocked', false);
        if ($isBlocked) {
            $response = ApiHelpers::jsonError($ret, 'Blocked User', 'Rate limit exceeded', ['attempts_remaining' => 0]);
            return $response;
        }

        // If you want to include remaining attempts in the response for non-blocked users
        $response = $next($request);

        // Modify the response data to include attempts_remaining
        $responseData = $response->getData(true);
        $responseData['attempts_remaining'] = $remainingAttempts;

        // Update the response with the modified data
        $response->setData($responseData);

        return $response;
    }
}
