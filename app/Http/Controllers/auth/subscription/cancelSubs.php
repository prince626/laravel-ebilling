<?php

namespace App\Http\Controllers\auth\subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiHelpers;
use App\Helpers\CalculateHelper;
use App\Helpers\HashHelper;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\SubscriptionHelper;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Models\activateaction;
use App\Models\cancelsubscription;
use App\Models\planaddons;
use App\Models\plancategory;
use App\Models\planpricing;
use App\Models\planvalidities;
use App\Models\rechargeinvoice;
use App\Models\software;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class cancelSubs extends Controller
{
    // cancel subscription------------------------------------>
    public function cancelSubscription(Request $req, $subsId)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "cancelationReason" => "required",
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $userFound = usersubscription::where('subs_id', $subsId)->first();

            if (!$userFound) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
            }

            // $cancelSubs = cancelsubscription::where('subs_id', $userFound->subs_id)->first();
            // if ($cancelSubs) {
            //     return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_already_cancel');
            // }
            $ret->trace .= 'Integrity_Check, ';

            $foundAmount = rechargeinvoice::where('subs_id', $subsId)->latest()->first();
            if (!$foundAmount && $userFound->paymentStatus === 'pending') {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_paid_user');
            }

            $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
            $startDate = Carbon::parse($userFound->startDate);
            $expiryDate = Carbon::parse($userFound->expiryDate);

            $numberOfDays = $startDate->diffInDays($now);
            $duration = $expiryDate->diffInDays($now);

            if ($numberOfDays >= $duration) {
                $refundAmount = 0; // No refund if a full month has passed
            } else {
                $costPerDay = $userFound->amount / $duration; // Assuming 30 days in a month
                $refundAmount = abs(($numberOfDays * $costPerDay) - $userFound->amount);
                $refundAmount = intval($refundAmount);
            }
            $canceluser = cancelsubscription::create([
                'user_id' => $userFound->user_id,
                'subs_id' => $userFound->subs_id,
                'email' => $userFound->email,
                'phone' => $userFound->phone,
                'cancelationReason' => $req->cancelationReason,
                'cancelationDate' => $now,
                'software' => $userFound->software,
                'subscriptionType' => $userFound->subscriptionType,
                'planInfo' => $userFound->planInfo,
                'Duration' => $userFound->Duration . ' ' . $userFound->durationType,
                'amount' => $userFound->amount,
                'refundAmount' => $refundAmount,
                'refundStatus' => 'Processing',
            ]);
            $ret->trace .= 'cancelSubs_created, ';

            // $userFound->activationStatus = false; // Toggle the 'activate' status
            // $userFound->subscriptionStatus = 'cancel';
            $userFound->delete(); // Save the changes
            if ($canceluser && $userFound) {
                $ret->trace .= 'Subscription_deleted, ';
                UpdateHelper::notification($req, 'isUser', $userFound, 'User subscription has been canceled', 'success');
                $response = SendResponse::SendResponse($ret, 'subscription_canceled', $canceluser);
                $message = 'Your subscription has been canceled';

                // $response = redirect('api/user/cancel_subs');
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
