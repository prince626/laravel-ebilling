<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\notification;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UpdateHelper
{

    public static function notification($req, $messageType, $user, $message, $type)
    {

        return notification::create([
            'messageType' => $messageType,
            'user_id' => $user->user_id,
            'email' => $user->email,
            'message' => $message,
            'type' => $type,
        ]);
    }
    public static function createNewUser(Request $req, $token)
    {
        $salt ='Rg6vd360a78c6da7QMCIdbUOdk';
        $randomId = mt_rand(10000, 99999);
        $emailOtp = 12345;
        $phoneOtp = 12345;
        return User::create([
            'user_id' => $randomId,
            'name' => $req->name,
            'companyName' => $req->companyName,
            'category' => $req->category,
            'email' => $req->email,
            'phone' => $req->phone,
            // 'emailOtp' => HashHelper::encrypt($emailOtp, $salt),
            'emailOtp' => HashHelper::hashWithSalt($emailOtp, $salt),
            'token' => $token,
            // 'mobileOtp' => HashHelper::encrypt($phoneOtp, $salt),
            'mobileOtp' => HashHelper::hashWithSalt($phoneOtp, $salt),
        ]);
    }
    public static function updateUser($user, $request, $createToken, $salt, $emailOtp, $phoneOtp)
    {
        $salt = 'Rg6vd360a78c6da7QMCIdbUOdk';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->companyName = $request->companyName;
        $user->category = $request->category;
        $user->emailOtp = HashHelper::hashWithSalt($emailOtp, $salt);
        $user->mobileOtp = HashHelper::hashWithSalt($phoneOtp, $salt);
        $user->token = $createToken;
        $user->save();
        return $user;
    }
    public static function loginUpdateUser($user, $req, $salt)
    {
        $user->name = $req->name;
        $user->companyName = $req->companyName;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->city = $req->city;
        $user->save();
        return $user;
    }
}
