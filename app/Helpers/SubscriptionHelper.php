<?php

namespace App\Helpers;

use App\Models\activateaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\planaddons;
use App\Models\plancategory;
use App\Models\planpricing;
use App\Models\planvalidities;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SubscriptionHelper
{

    public static function create_subscription($req, $userFound)
    {
        $expiryDate = null;
        $duration = planvalidities::where('planId', $req->duration)->first();
        $plan = planpricing::where('validityId', $req->plan)->first();
        $addons = planaddons::where('id', $req->addons)->first();
        $businessCategory = plancategory::where('id', $req->businessCategory)->first();

        $amount = null;
        if ($plan !== null) {
            $amount = $plan->price;
        }


        $userDuration = (int)$duration->duration;
        $userDurationType = $duration->durationType;

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

        if ($req->addons != null) {
            if ($addons !== null) {
                $addonamount = $addons->price;
                $amount = $amount + $addonamount;
            }
        }
        if ($req->paymentStatus === 'pending') {
            if ($userDuration === 1) {
                if ($userDurationType === 'Month') {
                    $expiryDate = Carbon::now('Asia/Kolkata')->addDays(2);
                } elseif ($userDurationType === 'Year') {
                    $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
                }
            } elseif ($userDuration === 3) {
                if ($userDurationType === 'Month') {
                    $expiryDate = Carbon::now('Asia/Kolkata')->addDays(10);
                } elseif ($userDurationType === 'Year') {
                    $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
                }
            }
        }
        $now = Carbon::now('Asia/Kolkata');
        $user = usersubscription::create([
            'user_id' => $userFound->user_id,
            'subs_id' => mt_rand(10000, 99999),
            'email' => $userFound->email,
            'phone' => $userFound->phone,
            'software' => $req->software,
            'subscriptionType' => $req->addons && $addons ? $addons->name : null,
            'business_Category' => $businessCategory->name,
            'subscriptionStatus' => 'inactive',
            'planInfo' => $plan->name,
            'Duration' => $userDuration,
            'startDate' => $now->format('Y-m-d'),
            'expiryDate' => $expiryDate->format('Y-m-d'),
            'durationType' => $userDurationType,
            'amount' => $amount,
            'accept' => $req->accept,
            'paymentStatus' => $req->paymentStatus,
            'kit' => HashHelper::createCustomToken(),
        ]);
        return $user;
    }
    public static function create_subscriptionHistory($user)
    {
        $subsHistory = subscriptionhistory::create([
            'user_id' => $user->user_id,
            'subs_id' => $user->subs_id,
            'email' => $user->email,
            'phone' => $user->phone,
            'software' => $user->software,
            'subscriptionType' => $user->subscriptionType,
            'subscriptionStatus' => $user->subscriptionStatus,
            'business_Category' => $user->business_Category,
            'planInfo' => $user->planInfo,
            'paymentStatus' => $user->paymentStatus,
            'duration' => $user->Duration,
            'startDate' => $user->startDate,
            'expiryDate' => $user->expiryDate,
            'durationType' => $user->durationType,
            'amount' => $user->amount,
        ]);
        return $subsHistory;
    }
    public static function update_subscriptionHistory($req, $plan, $subscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory, $amount)
    {
        $now = Carbon::now('Asia/Kolkata')->format('Y-m-d');
        $subsHistory = subscriptionhistory::create([
            'user_id' => $subscription->user_id,
            'subs_id' => $subscription->subs_id,
            'email' => $subscription->email,
            'phone' => $subscription->phone,
            'software' => $subscription->software,
            'subscriptionType' => $req->addons && $addons ? $addons->name : null,
            'subscriptionStatus' => 'inactive',
            'business_Category' => $businessCategory,
            'planInfo' => $plan->name,
            'paymentStatus' => $req->paymentStatus,
            'duration' => $userDuration,
            'startDate' => $now,
            'expiryDate' => $expiryDate,
            'durationType' => $userDurationType,
            'amount' => $amount,
        ]);
        return $subsHistory;
    }
    public static function refundAmount($subscription)
    {
        $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
        $startDate = Carbon::parse($subscription->startDate);
        $expiryDate = Carbon::parse($subscription->expiryDate);

        $numberOfDays = $startDate->diffInDays($now);
        $duration = $expiryDate->diffInDays($now);

        if ($numberOfDays >= $duration) {
            $refundAmount = 0; // No refund if a full month has passed
        } else {
            $costPerDay = $subscription->amount / $duration; // Assuming 30 days in a month
            $refundAmount = abs(($numberOfDays * $costPerDay) - $subscription->amount);
        }
        return $refundAmount;
    }
    public static function refundSubs($subscription, $req, $ret, $checkSubs, $userFound)
    {
        // if (in_array(false, $checkSubs)) {
        //     // SubscriptionHelper::refundSubs($subscription, $req, $ret);
        //     $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
        //     $startDate = Carbon::parse($subscription->startDate);
        //     $expiryDate = Carbon::parse($subscription->expiryDate);

        //     $numberOfDays = $startDate->diffInDays($now);
        //     $duration = $expiryDate->diffInDays($now);

        //     if ($numberOfDays >= $duration) {
        //         $refundAmount = 0; // No refund if a full month has passed
        //     } else {
        //         $costPerDay = $subscription->amount / $duration; // Assuming 30 days in a month
        //         $refundAmount = abs(($numberOfDays * $costPerDay) - $subscription->amount);
        //     }
        //     return $refundAmount;
        // }
        if (!in_array(false, $checkSubs)) {
            $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
            $startDate = Carbon::parse($subscription->startDate);
            $expiryDate = Carbon::parse($subscription->expiryDate);
            $duration = $expiryDate->diffInDays($now);
            $numberOfDays = $startDate->diffInDays($now);
            // $subscription->activationStatus = false; // Toggle the 'activate' status
            // $subscription->subscriptionStatus = 'cancel';
            // $subscription->update(); // Save the changes
            if ($subscription) {
                $expiryDate = null;
                $userDuration = (int)$req->duration;
                $userDurationType = $req->durationType;
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
                if ($numberOfDays >= $duration) {
                    $duration = 0; // No refund if a full month has passed
                }
                $expiryDate = Carbon::parse($expiryDate);
                $expiryDate->addDays($duration);

                // Format the updated expiry date as needed
                $updatedExpiryDate = $expiryDate->format('Y-m-d');

                // return $expiryDate;

                $subscription->subs_id = mt_rand(10000, 99999);
                $subscription->email = $userFound->email;
                $subscription->phone = $userFound->phone;
                $subscription->subscriptionType = $req->addons;
                $subscription->subscriptionStatus = 'inactive';
                $subscription->activationStatus = false;
                $subscription->business_Category = $req->businessCategory;
                $subscription->planInfo = $req->plan;
                $subscription->Duration = $req->duration;
                $subscription->durationType = $req->durationType;
                $subscription->startDate =  $now;
                $subscription->expiryDate = $updatedExpiryDate;
                $subscription->amount = $req->amount;
                $subscription->accept = $req->accept;
                $subscription->paymentStatus = 'success';
                $subscription->kit = HashHelper::createCustomToken();
                $subscription->update();
                return $subscription;
            }
        }
        return 'left';
    }
}
