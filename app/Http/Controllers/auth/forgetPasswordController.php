<?php

namespace App\Http\Controllers\auth;

use App\Helpers\ApiHelpers;
use App\Helpers\HashHelper;
use App\Helpers\LoginHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class forgetPasswordController extends Controller
{

    // get forgetpage data------------------>
    function forgetData(Request $req, $name)
    {
        try {
            $ret = ApiHelpers::ret();
            $token  = request()->cookie('token');
            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            }
            $ret->trace .= 'Intigrity_check, ';

            $response = SendResponse::SendResponse($ret, 'success', SendResponse::jsonUserData($user));
            $ret->trace .= 'get_data, ';
            $response = view('auth.' . $name)->with('user', $user);
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // change password----------------------->
    function change_password(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "email" => "required",
                "currentPassword" => "required",
                'password' => 'required|min:8',
                'comfirm_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $user = User::where(['email' => $req->email])->first();

            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'User Not Found');
            }
            $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';

            if (HashHelper::verifyWithSalt($req->currentPassword, $user->password, $salt)) {
                // $hashPassword = HashHelper::encrypt($req->password);
                if (HashHelper::verifyWithSalt($req->password, $user->password, $salt)) {
                    return SendResponse::jsonError($ret, 'password_error', 'New password must be different from the current password');
                }
                $ret->trace .= 'Intigrity_check, ';
                $user->password = HashHelper::hashWithSalt($req->password, $salt);
                $user->save();
                $ret->trace .= 'password_changed, ';
                $response = UpdateHelper::notification($req, 'isUser', $user, "User password has been changed successfully", 'success');
                // $response = view('auth.verifyforget')->with('user', $user);
                $response = LoginHelper::log_action($req, $user, true, 'password_changed', 'Password Updated');

                $response = SendResponse::SendResponse($ret, 'Success', SendResponse::jsonUserData($user));
                $message = 'Your password has been changed successfully';
                // $response = redirect('/get/profile');
                // $response = redirect('api/user/get/profile?message=' . urlencode($message));
                return $response;
            } else {
                $response = LoginHelper::log_action($req, $user, true, 'password_changed', 'Wrong Password');
                $response = SendResponse::jsonError($ret, 'password_error', 'Current password Not match');
                return $response;
            }
            // if ($plainPassword == $req->password) {
            //     return SendResponse::jsonError($ret, 'Integrity_error', 'current password and old password are same try different password');
            // }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // forget Password------------------------>
    function forget_password(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "email" => "required",
                "phone" => "required",
            ]);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $user = User::where(['email' => $req->email])->first();

            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'Enter Valid Email');
            }
            if ($user->phone !== $req->phone) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'Enter Valid Phone No');
            }
            $ret->trace .= 'Intigrity_check, ';

            $createToken =  HashHelper::createCustomToken();
            $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';
            $emailOtp = 12345;
            $phoneOtp = 12345;
            $user->save([
                'emailOtp' => HashHelper::hashWithSalt($emailOtp, $salt),
                'token' => $createToken,
                'mobileOtp' => HashHelper::hashWithSalt($phoneOtp, $salt),
            ]);
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'Something went wrong');
            }
            $ret->trace .= 'user_otps_sent, ';
            // $createLog = LoginHelper::log_action($req, $user, true, 'forget_password');
            $response = LoginHelper::log_action($req, $user, true, 'change_password', 'Otp Sent');

            $response = SendResponse::SendResponse($ret, 'success', $user);
            // $response = view('auth.verifyforget')->with('user', $user);

            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // verifyforget page data------------------------>
    function after_forget(Request $req, $name)
    {
        try {
            return view('auth.verifyforget')->with('user', $name);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // verify forget password------------------------>
    function verify_forget(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "email" => "required",
                "emailOtp" => "required",
                "mobileOtp" => "required",
                'password' => 'required|min:8',
                'cpassword' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';
            // $hashmobilelOtp = HashHelper::hashWithSalt($req->mobileOtp, $salt);
            // $hashemailOtp = HashHelper::hashWithSalt($req->emailOtp, $salt);

            $user = User::where(['email' => $req->email,])->first();
            if (
                HashHelper::verifyWithSalt($req->emailOtp, $user->emailOtp, $salt) &&
                HashHelper::verifyWithSalt($req->mobileOtp, $user->mobileOtp, $salt)
            ) {
                $ret->trace .= 'Intigrity_check, ';
                $user->update([
                    'password' => HashHelper::hashWithSalt($req->password, $salt),
                ]);
                $ret->trace .= 'password_updated, ';
                LoginHelper::log_action($req, $user, true, 'password_changed', 'Password Updated');
                UpdateHelper::notification($req, 'isUser', $user, 'your password has been successfully updated', 'success');
                $response = SendResponse::SendResponse($ret, 'success', SendResponse::jsonUserData($user));
                // $response = view('auth.login');
                return $response;
            } else {
                LoginHelper::log_action($req, $user, false, 'password_changed', 'Otp Not Valid');
                return SendResponse::jsonError($ret, 'Integrity_error', 'Otp Not Valid');
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
