<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiHelpers;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Models\invoicereceipts;
use App\Models\rechargeinvoice;
use App\Models\usersubscription;

class invoicesController extends Controller
{
    function delete_subs_invoices(Request $req, $subsId)
    {
        try {
            $ret = ApiHelpers::ret();
            $subscription =  rechargeinvoice::where('subs_id', '=', $subsId)->delete();

            if (!$subscription) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'user_subscriptions', $subscription);
                // return view('user.profile')->with('user', $user);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    function delete_subs_receipt(Request $req, $subsId)
    {
        try {
            $ret = ApiHelpers::ret();
            $subscription =  invoicereceipts::where('user_id', '=', $subsId)->delete();

            if (!$subscription) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'user_subscriptions', $subscription);
                // return view('user.profile')->with('user', $user);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
