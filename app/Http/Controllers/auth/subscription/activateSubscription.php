<?php

namespace App\Http\Controllers\auth\subscription;

use App\Http\Controllers\Controller;
use App\Helpers\ApiHelpers;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Models\subscriptionhistory;
use App\Models\usersubscription;
use Illuminate\Http\Request;

class activateSubscription extends Controller
{
    function edit_activation(Request $req, $subsId)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = usersubscription::where('subs_id', $subsId)->first();
            $subsHis = subscriptionhistory::where('subs_id', $subsId)->latest()->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user Not Found');
            }
            $ret->trace .= 'Integrity_check, ';

            $user->activationStatus = !$user->activationStatus; // Toggle the 'activate' status
            $user->subscriptionStatus = ($user->subscriptionStatus === 'inactive' || $user->subscriptionStatus === null) ? 'active' : 'inactive';
            $user->save(); // Save the changes

            $subsHis->subscriptionStatus = $user->subscriptionStatus;
            $subsHis->save();
            
            // if ($user->activationStatus) {

            //     $findAction = activateaction::where('subs_id', $user->subs_id)
            //         ->latest('created_at')
            //         ->first();
            //     if ($findAction && !$findAction->action) {
            //         $userSubscription = UserSubscription::where('subs_id', $user->subs_id)->first();
            //         if ($userSubscription) {
            //             $createdAt = Carbon::parse($findAction->created_at);
            //             $currentTime = Carbon::now('Asia/Kolkata')->format('Y-m-d');
            //             $expiryDate = Carbon::parse($userSubscription->expiryDate);
            //             $diffDays = $createdAt->diffInDays($currentTime);

            //             $updatedExpiryDate = $expiryDate->addDays($diffDays)->format('Y-m-d');

            //             // Update the expiryDate attribute of the userSubscription
            //             $userSubscription->update(['expiryDate' => $updatedExpiryDate]);

            //             UpdateHelper::notification($req, 'isUser', $user, "Your key has been " . ($user->subscriptionStatus ? 'Activated' : 'Deactivated'), $user->subscriptionStatus ? 'success' : 'user_Deactivated');
            //             $user = InvoicesHelper::action_log($user);
            //             $ret->trace .= 'action_created';

            //             $response = SendResponse::SendResponse($ret, 'User_actionlog_edited', $user);
            //             $response = redirect('/subscription');
            //             return $response;
            //         }
            //     }
            // }
            $message = "Your Subscription has been " . ($user->activationStatus ? 'Activated' : 'Deactivated') . "by Administrator";
            UpdateHelper::notification($req, 'isUser', $user, "User Subscription has been " . ($user->activationStatus ? 'Activated' : 'Deactivated'), 'success');
            // $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', SendResponse::sendSubscriptions($user));
            InvoicesHelper::action_log($user);
            $ret->trace .= 'action_created, ';
            $ret->trace .= 'Database_inserted, ';
            $response = SendResponse::SendResponse($ret, "User Subscription has been " . ($user->activationStatus ? 'Activated' : 'Deactivated'), $user);
            // $response = redirect('api/user/subscription?message=' . urlencode($message));
            $response = redirect('api/user/subscription');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
