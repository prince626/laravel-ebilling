<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SendResponse
{

    public static function jsonUserData($user)
    {
        // HashHelper::decrypt($user->mobileOtp);
        // HashHelper::decrypt($user->mobileOtp);
        $data = ([
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'companyName' => $user['companyName'],
            'category' => $user['category'],
            'phone' => $user['phone'],
            'email' => $user['email'],
            'address' => $user['address'],
            'city' => $user['city'],
            'verify' => $user['verify'],
            'token' => $user['token'],
        ]);
        return $data;
    }
    public static function jsonPaidUserData($user)
    {
        $data = ([
            'user_id' => $user['user_id'],
            'business_Category' => $user['business_Category'],
            'plan' => $user['plan'],
            'phone' => $user['phone'],
            'email' => $user['email'],
            'duration' => $user['duration'],
            'addons' => $user['addons'],
            'kit' => $user['kit'],
        ]);
        return $data;
    }

    public static function jsonError($ret, $status, $data,)
    {
        $ret->status = $status;
        $ret->data = $data;

        return response()->json($ret, 200);
    }


    public static function SendResponse($ret, $status, $user)
    {
        $ret->success =true;
        $ret->status = $status;
        $ret->data = $user;


        return response()->json($ret, 200);
    }

    public static  function adminValidateRequest(Request $req)
    {
        return Validator::make($req->all(), [
            "name" => "required",
            "phone" => "required|regex:/^[0-9]{10}$/",
            "email" => "required",
            "companyName" => "required",
            "category" => "required",
            'password' => 'required|min:8',
            'cpassword' => 'required|same:password',
            'mobileOtp' => 'required',
            'emailOtp' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);
    }


    public static function jsonUserAndPaidData($user)
    {
        $data = ([
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'companyName' => $user['companyName'],
            'category' => $user['category'],
            'phone' => $user['phone'],
            'email' => $user['email'],
            'address' => $user['address'],
            'city' => $user['city'],
            'verify' => $user['verify'],
            'token' => $user['token'],
            'business_Category' => $user['business_Category'],
            'plan' => $user['plan'],
            'duration' => $user['duration'],
            'addons' => $user['addons'],
            'kit' => $user['kit'],
            'method' => $user['method'],
        ]);
        return $data;
    }
    public static function sendSubscriptions($users)
    {
        $result = [];

        foreach ($users as $userData) {
            $data = [
                'user_id' => $userData->user_id,
                'subs_id' => $userData->subs_id,
                'phone' => $userData->phone,
                'email' => $userData->email,
                'subscriptionType' => $userData->subscriptionType,
                'software' => $userData->software,
                'business_Category' => $userData->business_Category,
                'duration' => $userData->Duration . ' ' . $userData->durationType,
                'subscriptionStatus' => $userData->subscriptionStatus,
                'planInfo' => $userData->planInfo,
                'amount' => $userData->amount,
                'paymentStatus' => $userData->paymentStatus,
                'activationStatus' => $userData->activationStatus,
                'startDate' => $userData->startDate,
                'expiryDate' => $userData->expiryDate,
                'kit' => $userData->kit,
            ];

            $result[] = $data;
        }

        return $result;
    }

    public static function cancelSubscription($user)
    {
        $result = [];
        foreach ($user as $userData) {
            $data = [
                'user_id' => $userData->user_id,
                'subs_id' => $userData->subs_id,
                'phone' => $userData->phone,
                'email' => $userData->email,
                'subscriptionType' => $userData->subscriptionType,
                'software' => $userData->software,
                'duration' => $userData->Duration,
                // 'subscriptionStatus' => $userData->subscriptionStatus,
                'planInfo' => $userData->planInfo,
                'amount' => $userData->amount,
                'cancelationReason' => $userData->cancelationReason,
                'cancelationDate' => $userData->cancelationDate,
                'refundAmount' => $userData->refundAmount,
                'refundStatus' => $userData->refundStatus,
            ];
            $result[] = $data;
        }
        return $result;
    }
}
