<?php

namespace App\Http\Controllers\auth\invoices;

use App\Helpers\ApiHelpers;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\invoicereceipts;
use App\Models\rechargeinvoice;
use Illuminate\Http\Request;

class cancelInvoiceControler extends Controller
{
    // delete user invoice----------------------------------> 
    function delete_invoice(Request $req, $invoice)
    {
        try {
            $ret = ApiHelpers::ret();
            $invoice = rechargeinvoice::where('invoice_number', $invoice)->first();
            if (!$invoice) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_invoices');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $invoice->delete();
                if ($invoice) {
                    UpdateHelper::notification($req, 'isUser', $invoice, 'User invoice has been deleted', 'success');
                    $response = SendResponse::SendResponse($ret, 'Invoice_deleted', $invoice);

                    // $response = redirect('/api/user/recharge_invoices');
                    return $response;
                }
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    function delete_receipt(Request $req, $receipt)
    {
        try {
            $ret = ApiHelpers::ret();
            $receipt = invoicereceipts::where('receipt_no', $receipt)->first();
            if (!$receipt) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_receipt');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $receipt->delete();
                if ($receipt) {
                    UpdateHelper::notification($req, 'isUser', $receipt, 'User receipt has been deleted', 'success');
                    $response = SendResponse::SendResponse($ret, 'Receipt_deleted', $receipt);
                    // $response = redirect('/api/user/recharge_invoices');
                    return $response;
                }
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
