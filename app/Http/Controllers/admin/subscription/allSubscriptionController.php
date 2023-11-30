<?php

namespace App\Http\Controllers\admin\subscription;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Models\usersubscription;
use Illuminate\Http\Request;

class allSubscriptionController extends Controller
{
    function Admin_subscriptions(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $subscription =  usersubscription::all();

            if (!$subscription) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'not_subscriptions_available');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'user_subscriptions', $subscription);
                $ret->trace .= 'get_data, ';

                return view('admin.subscription.allSubs')->with(['subscription' => $subscription]);
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
