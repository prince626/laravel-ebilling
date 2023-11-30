<?php

namespace App\Http\Controllers\auth;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\categorycode;
use App\Models\User;
use Illuminate\Http\Request;

class updateController extends Controller
{
    // update user profile------------------------->
    public function user_update(Request $req, $id)  //update User-->
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = ApiHelpers::updateuserRequest($req);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            } else {
                $ret->trace .= 'validated, ';
                $user = User::where('user_id', "=", $id)->first();

                if (!$user) {
                    return SendResponse::jsonError($ret, 'Intigrity_error', 'User Not Found');
                }
                $existingUser = User::where('email', '=', $req->email)->where('user_id', '!=', $id)->first();
                $existingphone = User::where('phone', '=', $req->phone)->where('user_id', '!=', $id)->first();
                // $matchCode = categorycode::where('category_code', $req->category)->first();
                // if (!$matchCode) {
                //     return SendResponse::jsonError($ret, 'Intigrity_error', 'category');
                // }
                if ($existingUser) {
                    return SendResponse::jsonError($ret, 'Integrity_error', 'Email already in use by another user');
                }
                if ($existingphone) {
                    return SendResponse::jsonError($ret, 'Integrity_error', 'Phone No already in use by another user');
                }
                $ret->trace .= 'Intigrity_check, ';
                $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';

                $user = UpdateHelper::loginUpdateUser($user, $req, $salt);

                $ret->trace .= 'Data_updated, ';
                UpdateHelper::notification($req, 'isUser', $user, 'User profile data has been update successfully', 'success');
                $response =  SendResponse::SendResponse($ret, 'User profile data update successfully', SendResponse::jsonUserData($user));
                // $response = redirect('api/user/get/profile');
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
