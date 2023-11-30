<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FirstDataController extends Controller
{
    function get_firstdata(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $token  = request()->cookie('token');
            $now = Carbon::now('Asia/Kolkata')->addMonth()->format('Y-m-d');
            $user = User::where('token', $token)->first();
            if (!$user) {
                return view('auth.customer')->with(['user' => null, 'signup' => false, 'expired' => false]);
            }
            if ($user && $user->verify) {
                $response = SendResponse::jsonError($ret, 'User_already_verified', SendResponse::jsonUserData($user));
                $response = redirect('/login');
                return $response;
            } else if ($user && $token) {
                $ret->trace .= 'Intigrity_check, ';
                if (Carbon::parse($user['updated_at'])->format('Y-m-d') >= $now) {
                    $response = SendResponse::jsonError($ret, 'Token Expire', $user);
                    $response = view('auth.customer')->with(['user' => $user, 'signup' => false, 'expired' => true]);
                    return $response;
                } else {
                    $response = SendResponse::SendResponse($ret, 'Token valid', SendResponse::jsonUserData($user));
                    $ret->trace .= 'get_data, ';
                    $response = view('auth.customer')->with(['user' => $user, 'signup' => true]);
                    return $response;
                }
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
