<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ValidateHelpers
{
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
    public static function updateValidateRequest(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "name" => ["required", "min:3"],
            "companyName" => "required",
            "address" => "required",
            "city" => "required",
            'password' => 'required|min:8',
            "category" => [
                "required", "min:5", "regex:/\d/",
            ],
            "phone" => ["required", "regex:/^[0-9]{10}$/"],
            "email" => "required",
        ]);
        return $validator;
    }
    public static function adminValidateRequest(Request $req)
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

    public static function serverError($e)
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'data' => $e->getMessage()
        ], 500);
    }
}
