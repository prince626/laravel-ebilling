<?php

namespace App\Http\Controllers\auth;

use App\Helpers\ApiHelpers;
use App\Helpers\HashHelper;
use App\Helpers\LoginHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\logaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class loginController extends Controller
{

    // user login------------------------->
    function login(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "email" => "required",
                "password" => "required",
            ]);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $user = User::where(['email' => $req->email])->first();
            $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';

            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'User Not Valid');
            }
            // $plain = HashHelper::verifyWithSalt($req->password, $user->password, $salt);
            if (HashHelper::verifyWithSalt($req->password, $user->password, $salt)) {
                $ret->trace .= 'Intigrity_check, ';
                $createToken = HashHelper::createCustomToken();
                $user->token = $createToken;
                $user->save();
                $cookieExpiration = 30 * 24 * 60;

                $cookie = Cookie::make('token', $createToken, $cookieExpiration);
                // $cookie = Cookie::make('token', $createToken, $cookieExpiration, null, null, true, true);
                $response = LoginHelper::log_action($req, $user, true, 'login_success');
                $response = response('hello cookie')->withCookie($cookie);
                $response = SendResponse::SendResponse($ret, 'success', 'login_success')->withCookie($cookie);
                // $response = redirect("api/user/get/profile")->withCookie($cookie);
                return $response;
            } else {
                LoginHelper::log_action($req, $user, false, 'password Not match');
                return SendResponse::jsonError($ret, 'Integrity_error', 'password Not valid');
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    // function verify_login(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $validator = Validator::make($req->all(), [
    //             "email" => "required",
    //             "emailOtp" => "required",
    //             "mobileOtp" => "required",
    //         ]);
    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $now = Carbon::now('Asia/Kolkata')->subMinutes(30);

    //         $ret->trace .= 'validated, ';

    //         $salt = env('MY_HASHING_SALT');

    //         // $hashemailOtp = HashHelper::encrypt($req->emailOtp, $salt);
    //         // $hashmobileOtp = HashHelper::encrypt($req->mobileOtp, $salt);
    //         $user = User::where(['email' => $req->email])->first();
    //         $hashemailOtp = HashHelper::decrypt($user->mobileOtp);
    //         $hashmobileOtp = HashHelper::decrypt($user->emailOtp);
    //         $verifyuser = ([$hashemailOtp === $req->emailOtp &&
    //             $hashmobileOtp === $req->mobileOtp]);
    //         if (!$verifyuser) {
    //             $response = SendResponse::jsonError($ret, 'Integrity_error', 'otp Not valid');
    //             return $response;
    //         }
    //         if ($now >= $user->updated_at) {
    //             return  SendResponse::jsonError($ret, 'otp_expired', SendResponse::jsonUserData($user));
    //         }
    //         $ret->trace .= 'Intigrity_check, ';
    //         $response = SendResponse::SendResponse($ret, 'success', $user);
    //         $createToken = HashHelper::createCustomToken();
    //         $user->token = $createToken;
    //         $user->save();
    //         $cookieExpiration = 30 * 24 * 60;
    //         // $cookie = Cookie::make('token', $createToken, $cookieExpiration); // Cookie name, value, and expiration time in minutes
    //         $cookie = Cookie::make('token', $createToken, $cookieExpiration);
    //         // $cookie = Cookie::make('token', $createToken, $cookieExpiration, null, null, true, true);
    //         $createLog = LoginHelper::log_action($req, $user, true, 'successful_login');

    //         if ($createLog) {
    //             UpdateHelper::notification($req, 'isUser', $user, "User login Successfully", 'success');
    //             UpdateHelper::notification($req, 'isUser', $user, 'welcome back user', 'success');
    //             $ret->trace .= 'created_log, ';
    //             $ret->trace .= 'user_login_successfully, ';
    //         }
    //         $response = response('hello cookie')->withCookie($cookie);
    //         // return response('hello cookie')->withCookie($cookie)->redirect("/get/profile");
    //         $response = redirect("api/user/get/profile")->withCookie($cookie);
    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }


    function create(Request $req, $token)
    {
        $ret = ApiHelpers::ret();

        $cookieExpiration = 30 * 24 * 60;
        $cookie = Cookie::make('token', $token, $cookieExpiration);
        $response = response('hello cookie')->withCookie($cookie);
        // $response = redirect("/get/profile");
        return $response;
    }
    function get(Request $req)
    {
        $ret = ApiHelpers::ret();

        $passwordUpdated = LogAction::where('user_id', auth()->id())
            ->where('action_type', 'password_changed')
            ->latest('created_at')
            ->first();

        $receiptRead = LogAction::where('user_id', auth()->id())
            ->where('action_type', 'receipt_read') // corrected the action_type
            ->latest('created_at')
            ->first();

        $logAction = LogAction::where('user_id', auth()->id())
            ->where('action_type', 'login_success')
            ->latest('created_at')
            ->first();
        $activities = [
             $logAction,
            $passwordUpdated,
           $receiptRead
        ];

        $response  = request()->cookie('token');
        // $response = auth()->id();
        // Send the response to the client
        // dd($logction);
        return [ 'activities' => $activities];
    }
    function read_receipt(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = User::where(['user_id' => $id])->first();
            $response = LoginHelper::log_action($req, $user, true, 'receipt_read');
            $ret->trace .= 'receipt_read, ';

            $response = SendResponse::SendResponse($ret, 'success', 'receipt_read');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // user logout function----------------------->
    public function logout(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $cookieToken = request()->cookie('token');
            // return $cookieToken;
            $user = User::where('token', $cookieToken)->first();

            if (!$user) {
                return SendResponse::jsonError($ret, 'Intigrity_error', 'Token');
            }

            $cookie = Cookie::forget('token');
            $createLog = LoginHelper::log_action($req, $user, true, 'user_logged_out');
            if ($createLog) {
                $ret->trace .= 'user_logged_out, ';
            }
            $response = SendResponse::SendResponse($ret, 'success', null); // Pass null as the user data since the user is now logged out
            $response->withCookie($cookie);
            $response = redirect('/login')->withCookie($cookie);
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
