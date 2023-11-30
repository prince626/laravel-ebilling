<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\logaction;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginHelper
{


    public static function log_action($req, $user, $status, $actionType)
    {
        return logaction::create([
            'user_id' => $user->user_id,
            'action_type' => $actionType,
            'ip_address' => $req->ip(),
            'user_agent' => $req->header('User-Agent'),
            'status' =>  $status,
        ]);
    }
}
