<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiHelpers;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\activateaction;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class kitController extends Controller
{
    function users_editkey(Request $req, $subsId)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = usersubscription::where('subs_id', $subsId)->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user Not Found');
            }
            $ret->trace .= 'Integrity_check, ';

            $user->activationStatus = !$user->activationStatus; // Toggle the 'activate' status
            $user->subscriptionStatus = ($user->subscriptionStatus === 'inactive' || $user->subscriptionStatus === null) ? 'active' : 'inactive';
            $user->save(); // Save the changes

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
            $message = "Your Subscription has been " . ($user->activationStatus ? 'Activated' : 'Deactivated') . " by Administrator";
            UpdateHelper::notification($req, 'iAdmin', $user, "Your Subscription has been " . ($user->activationStatus ? 'Activated' : 'Deactivated') . " by Administrator", 'success');
            InvoicesHelper::action_log($user);
            $ret->trace .= 'action_created, ';
            $response = SendResponse::SendResponse($ret, 'User_actionlog_edited', $user);
            $ret->trace .= 'Database_inserted, ';

            $response = redirect('/api/admin/');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
