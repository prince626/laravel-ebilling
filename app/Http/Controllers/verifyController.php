<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use App\Helpers\HashHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class verifyController extends Controller
{
    public function verify(Request $req, $token)
    {
        try {
            $ret = ApiHelpers::ret();

            // Validate the form inputs
            $validator = Validator::make($req->all(), [
                'password' => 'required|min:8',
                'cpassword' => 'required|same:password',
                'mobileOtp' => 'required',
                'emailOtp' => 'required',
                'address' => 'required',
                'city' => 'required',
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $now = Carbon::now('Asia/Kolkata')->subMinutes(30);

            $user = User::where('token', $token)->first();

            if (!$user) {
                return SendResponse::jsonError($ret, 'Intigrity_error', 'Token not valid');
            }
            $ret->trace .= 'Intigrity_check, ';
            // $emailOtp = HashHelper::decrypt($user->emailOtp);
            // $mobileOtp = HashHelper::decrypt($user->mobileOtp);
            $emailOtp = $req->emailOtp;
            $mobileOtp = $req->mobileOtp;
            if ($user && $user['verify'] === "1") {
                $response = SendResponse::jsonError($ret, 'User_already_verified', SendResponse::jsonUserData($user));
                $response = redirect('/login');
                return $response;
            }
            if ($now >= $user->updated_at) {
                // return  SendResponse::jsonError($ret, 'otp_expired', SendResponse::jsonUserData($user));
                return view('auth.customer')->with(['user' => $user, 'expired' => true, 'signup' => false]);
            }

            // $hashemailOtp = HashHelper::encrypt($req->mobileOtp, $salt);
            // $hashmobileOtp = HashHelper::encrypt($req->emailOtp, $salt);
            // $user = User::where(['mobileOtp' => $hashemailOtp, 'emailOtp' => $hashmobileOtp])->first();
            $salt ='Rg6vd360a78c6da7QMCIdbUOdk';

            if (
                HashHelper::verifyWithSalt($emailOtp, $user->emailOtp, $salt) &&
                HashHelper::verifyWithSalt($mobileOtp, $user->mobileOtp, $salt)
                // $emailOtp === $req->emailOtp &&
                // $mobileOtp === $req->mobileOtp
            ) {
                $ret->trace .= 'otp_verified, ';
                // $user->password = HashHelper::hashWithSalt($req->password, $salt);
                $user->password = HashHelper::hashWithSalt($req->password, $salt);
                $user->address = $req->address;
                $user->city = $req->city;
                $user->verify = true;

                if ($user->save()) {
                    $ret->trace .= 'Database_inserted';
                    UpdateHelper::notification($req, 'isUser', $user, 'User has been register successfully', 'success');

                    $response =  SendResponse::SendResponse($ret, 'success',  SendResponse::jsonUserData($user));
                    // $response = redirect('api/user/profile');
                    return $response;
                }
            } else {
                return  SendResponse::jsonError($ret, 'Intigrity_error', 'otp not match');
            }
        } catch (\Exception $e) {
            return  ApiHelpers::serverError($e);
        }
    }
}
