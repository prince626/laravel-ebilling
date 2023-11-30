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

class HashHelper
{
    // public static function encrypt($string)
    // {
    //     $hash = Crypt::encryptString($string);
    //     $encrypted = Crypt::encryptString($hash);
    //     return $encrypted;
    // }
    // public static function decrypt($hash)
    // {
    //     $decrypt = Crypt::decryptString($hash);
    //     return $decrypt;
    // }
    public static  function encrypt($string)
    {
        $hashSalt = env('MY_HASHING_SALT');

        $hash = Crypt::encryptString($string);
        $addData = $hash . $hashSalt;
        $hash = Crypt::encryptString($addData);
        return $hash;
    }
    public static function decrypt($hash)
    {
        $decrypt = Crypt::decryptString($hash);

        $hashSalt = env('MY_HASHING_SALT');
        $saltLength = strlen($hashSalt);
        $decryptedWithoutSubstring = '';
        if (substr($decrypt, -$saltLength) === $hashSalt) {
            $decryptedWithoutSubstring = substr($decrypt, 0, -$saltLength);
        }
        return Crypt::decryptString($decryptedWithoutSubstring);
    }

    public static function hashWithSalt($value, $salt)
    {
        $algo = 'sha256';
        return hash($algo, $value . $salt);
    }
    public static function verifyWithSalt($value, $hashedValue, $salt)
    {
        $hashedInput = self::hashWithSalt($value, $salt);
        return hash_equals($hashedValue, $hashedInput);
    }

    public static function createCustomToken()
    {
        $randomPart = Str::random(64);
        return env('APP_TOKEN_STRING') . $randomPart;
    }
}
