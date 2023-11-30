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

class CalculateHelper
{
    public static function calculateExpiryDate($user)
    {
        $expiryDate = null;
        $userDuration = (int)$user->Duration;
        $userDurationType = $user->durationType;
        if ($userDuration === 1) {
            if ($userDurationType === 'Month') {
                $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
            } elseif ($userDurationType === 'Year') {
                $expiryDate = Carbon::now('Asia/Kolkata')->addYear();
            }
        } elseif ($userDuration === 3) {
            if ($userDurationType === 'Month') {
                $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
            } elseif ($userDurationType === 'Year') {
                $expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
            }
        }
        return $expiryDate;
    }
}
