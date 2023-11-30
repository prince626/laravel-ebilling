<?php

namespace App\Http\Controllers\admin\subscription;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\cancelsubscription;
use App\Models\rechargeinvoice;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class cancelSubscriptionController extends Controller
{
    public function adminCancelSubscription(Request $req, $subsId)
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
                'subscriptionType' => $userFound->subscriptionType,
                'planInfo' => $userFound->planInfo,
                'Duration' => $userFound->Duration . ' ' . $userFound->durationType,
                'amount' => $userFound->amount,
                'refundAmount' => $refundAmount,
                'refundStatus' => 'Processed',
            ]);
            $ret->trace .= 'cancelSubs_created, ';

            // $userFound->activationStatus = false; // Toggle the 'activate' status
            // $userFound->subscriptionStatus = 'cancel';
            $userFound->delete(); // Save the changes

            if ($canceluser && $userFound) {
                $ret->trace .= 'user_success, ';
                UpdateHelper::notification($req, 'isAdmin', $userFound, 'Your subscription has been canceled by Adminstator', 'alert');
                $response = SendResponse::SendResponse($ret, 'user_success', $canceluser);
                $message = 'user subscription has been canceled';
                $ret->trace .= 'Subscription_deleted, ';

                $response = redirect('/api/admin/all/Subscriptions');
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
