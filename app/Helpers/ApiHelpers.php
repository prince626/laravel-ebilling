<?php

namespace App\Helpers;

use App\Models\activateaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ApiHelpers
{
    public static function checkSubs($req, $subscription)
    {
        $data = [
            trim(strtolower($req->businessCategory)) == trim(strtolower($subscription->business_Category)),
            trim(strtolower($req->plan)) == trim(strtolower($subscription->planInfo)),
            trim(strtolower($req->duration)) == trim(strtolower($subscription->Duration)),
            trim(strtolower($req->durationType)) == trim(strtolower($subscription->durationType)),
            trim(strtolower($req->addons)) == trim(strtolower($subscription->subscriptionType)),
            trim(strtolower($req->amount)) == trim(strtolower($subscription->amount))
        ];
        return $data;
    }
    public static function validationError($error, $ret)
    {
        $ret->status = 'validation_error';
        $ret->data = implode(',', array_keys($error->toArray()));

        return response()->json($ret, 200);
    }
    public static function updateValidateRequest(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "name" => ["required", "min:3"],
            "companyName" => "required",
            "category" => [
                "required", "min:5", "regex:/\d/",
            ],
            "phone" => ["required", "regex:/^[0-9]{10}$/"],
            "email" => "required",
        ]);
        return $validator;
    }
    public static function updateuserRequest(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "name" => ["required", "min:3"],
            "companyName" => "required",
            "address" => "required",
            "city" => "required",
            // 'password' => 'required|min:8',
            // "category" => [
            //     "required", "min:5", "regex:/\d/",
            // ],
            "phone" => ["required", "regex:/^[0-9]{10}$/"],
            "email" => "required",
        ]);
        return $validator;
    }
    public static function validateRequest($req)
    {
        $validator = Validator::make($req->all(), [
            "name" => ["required", "min:3"],
            "companyName" => "required",

            "category" => [
                "required", "min:5", "regex:/\d/",
            ],
            "phone" => ["required", "regex:/^[0-9]{10}$/", "unique:users",],
            "email" => "required|email|unique:users,email",
        ]);
        return $validator;
    }
    public static function serverError($e)
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'data' => $e->getMessage()
        ], 500);
    }

    public static function ret()
    {
        $ret = (object)[];
        $ret->success = false;
        $ret->status = '';
        $ret->data = '';
        $ret->trace = 'Api_Hit, ';
        return $ret;
    }
    public static function jsonError($ret, $status, $data,)
    {
        $ret->status = $status;
        $ret->data = $data;

        return response()->json($ret, 200);
    }
    public static function action_log($user)
    {
        $invoiceData = [
            'user_id' => $user->user_id,
            'subs_id' => $user->subs_id,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'planInfo' => $user->planInfo,
            'action' => $user->activationStatus,
        ];
        $receipt = new activateaction($invoiceData);
        return $receipt->save();
    }
}
