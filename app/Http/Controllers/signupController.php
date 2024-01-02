<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\categorycode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\ApiHelpers;
use App\Helpers\HashHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use Illuminate\Support\Facades\Cookie;

class signupController extends Controller
{
    // User Signup--------------->
    
    public function signUp(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $validator = ApiHelpers::validateRequest($req);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $matchCode = categorycode::where('category_code', $req->category)->first();
            if (!$matchCode) {
                return SendResponse::jsonError($ret, 'Intigrity_error', 'category');
            }
            $ret->trace .= 'Intigrity_check, ';

            $token = HashHelper::createCustomToken();
            $user = UpdateHelper::createNewUser($req, $token);
            if ($user) {
                $cookieExpiration = 30 * 24 * 60;
                $cookie = Cookie::make('token', $token, $cookieExpiration);
                $ret->trace .= 'Database_inserted,';
                $response = SendResponse::SendResponse($ret, 'success', $token)->withCookie($cookie);;
                $response->withCookie($cookie);
                // $response = redirect('/api/getfirstdata')->withCookie($cookie);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // edit singup data and resend Otp------------->
    function edit_signup(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $validator = ApiHelpers::updateValidateRequest($req);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $matchCode = categorycode::where('category_code', $req->category)->first();
            if (!$matchCode) {
                return SendResponse::jsonError($ret, 'Intigrity_error', 'category');
            }
            $cookieToken = request()->cookie('token');
            $user = User::where('token', $cookieToken)->first();

            if (!$user) {
                return SendResponse::jsonError($ret, 'Intigrity_error', 'Token');
            }
            $ret->trace .= 'Intigrity_check, ';

            $salt = env('MY_HASHING_SALT');
            $emailOtp = 12345;
            $phoneOtp = 12345;
            $createToken = HashHelper::createCustomToken();
            UpdateHelper::updateUser($user, $req, $createToken, $salt, $emailOtp, $phoneOtp);

            $ret->trace .= 'Database_inserted,';

            $response = SendResponse::SendResponse($ret, 'success', $createToken);
            $cookieExpiration = 30 * 24 * 60;
            $cookie = Cookie::make('token', $createToken, $cookieExpiration);
            $response->withCookie($cookie);
            $response = redirect('api/getfirstdata')->withCookie($cookie);
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
