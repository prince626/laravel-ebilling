<?php

namespace App\Http\Controllers\auth\invoices;

use App\Helpers\LoginHelper;
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
class receiptController extends Controller
{
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

    function read_receipt(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = User::where(['user_id' => $id])->first();
            $response = LoginHelper::log_action($req, $user, true, 'receipt_read','Receipt Read');
            $ret->trace .= 'receipt_read, ';

            $response = SendResponse::SendResponse($ret, 'success', 'receipt_read');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
