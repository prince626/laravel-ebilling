<?php

namespace App\Http\Controllers\auth\invoices;

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
use App\Models\rechargeinvoice;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class getInvoiceController extends Controller
{
    // get user incvoices----------------------------->
    function getRecharge_invoices(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $rechargeinvoices = rechargeinvoice::where('user_id', auth()->id())->get();
            if (!$rechargeinvoices) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_invoices');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'Success', $rechargeinvoices);
                $ret->trace .= 'get_data, ';

                $response = view('user.invoice')->with('invoices', $rechargeinvoices);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

// get user receipts--------------------------->
    function get_receipts(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $receipt = invoicereceipts::where('user_id', auth()->id())->get();
            if (!$receipt) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_receipt');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'Success', $receipt);
                $response = view('user.receipt')->with('invoiceReceipt', $receipt);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get bill history----------------------->
    function get_billHistory(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $bills =  billinghistory::where('user_id', auth()->id())->get();

            if (!$bills) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions_history');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', $bills);
                $ret->trace .= 'get_data, ';

                return view('user.billhistory')->with(['bills' => $bills]);
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
