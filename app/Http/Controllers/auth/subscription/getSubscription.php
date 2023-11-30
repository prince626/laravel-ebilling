<?php

namespace App\Http\Controllers\auth\subscription;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\billinghistory;
use App\Models\cancelsubscription;
use App\Models\contact;
use App\Models\invoicereceipts;
use App\Models\notification;
use App\Models\paiduser;
use App\Models\planaddons;
use App\Models\plancategory;
use App\Models\planpricing;
use App\Models\software;
use App\Models\planvalidities;
use App\Models\rechargeinvoice;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class getSubscription extends Controller
{
    // get update subscription page data------------------->
    public function get_Subscription(Request $req, $id)
    {
        try {
            /* This code snippet is creating a new user subscription record in the database. */
            $ret = ApiHelpers::ret();
            $subscription = usersubscription::where('subs_id', $id)->first();
            if (!$subscription) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user');
            }
            $ret->trace .= 'Integrity_check, ';

            $software = software::all();
            $categories = plancategory::all();
            $pricings = planpricing::all();
            $validities = planvalidities::all();
            $addons = planaddons::all();
            $ret->trace .= 'get_data, ';
            return view('user.updateSubscription')->with([
                'software' => $software,
                'categories' => $categories,
                'pricings' => $pricings,
                'validities' => $validities,
                'subscription' => $subscription,
                'addons' => $addons
            ]);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get view plans update --------------------------------->
    public function view_updateSubscription(Request $req, $id)
    {
        try {
            /* This code snippet is creating a new user subscription record in the database. */
            $ret = ApiHelpers::ret();
            $subscription = usersubscription::where('subs_id', $id)->first();
            if (!$subscription) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user');
            }
            $ret->trace .= 'Integrity_check, ';

            $software = software::all();
            $categories = plancategory::all();
            $pricings = planpricing::all();
            $validities = planvalidities::all();
            $addons = planaddons::all();
            $ret->trace .= 'get_data, ';
            return view('user.updateSubView')->with([
                'software' => $software,
                'categories' => $categories,
                'pricings' => $pricings,
                'validities' => $validities,
                'subscription' => $subscription,
                'addons' => $addons
            ]);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get user subscriptions--------------------------> 
    function get_user_subscriptions(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $subscription =  usersubscription::where('user_id', auth()->id())->get();

            if (!$subscription) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                // $response = SendResponse::SendResponse($ret, 'user_subscriptions', $subscription);
                $response = SendResponse::SendResponse($ret, 'user_subscriptions', SendResponse::sendSubscriptions($subscription));
                $ret->trace .= 'get_data, ';
                $response = view('user.subscription')->with(['subscription' => $subscription]);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get subscription history----------------------------->
    function get_subscriptionHistory(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $subscription =  subscriptionhistory::where('user_id', auth()->id())->get();

            if (!$subscription) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions_history');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                // $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', $subscription);
                $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', SendResponse::sendSubscriptions($subscription));
                $ret->trace .= 'get_data, ';

                $response = view('user.subscriptionhistory')->with(['subscription' => $subscription]);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get cancel subscription data------------------------------>
    function cancel_subscription(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            }
            $cancelSubs = cancelsubscription::where('user_id', $user->user_id)->get();
            if (!$cancelSubs) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_subscription');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                // $response = SendResponse::SendResponse($ret, 'cancel_subs', $cancelSubs);
                $response = SendResponse::SendResponse($ret, 'cancel_subs', SendResponse::cancelSubscription($cancelSubs));
                $response = view('user.cancelSubs')->with('cancelSubs', $cancelSubs);

                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
