<?php

namespace App\Helpers;

use App\Models\activateaction;
use App\Models\billinghistory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\categorycode;
use App\Models\invoiceHistory;
use App\Models\invoicereceipts;
use App\Models\rechargeinvoice;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class InvoicesHelper
{
    public static function autoAction_log($user)
    {
        $invoiceData = [
            'user_id' => $user->user_id,
            'subs_id' => $user->subs_id,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'planInfo' => $user->planInfo,
            'action' => false,
        ];
        $receipt = new activateaction($invoiceData);
        $receipt->save();
        return $receipt;
    }

    public static function subs_invoice($user, $expiryDate)
    {
        $randomNo = mt_rand(1000000, 9999999);
        $invoiceData = [
            'invoice_number' => $randomNo,
            'user_id' => $user->user_id,
            'subs_id' => $user->subs_id,
            'email' => $user->email,
            'phone' => $user->phone,
            'software' => $user->software,
            'planInfo' => $user->business_Category,
            'paid_amount' => $user->amount,
            'paymentStatus' => $user->paymentStatus,
            'invoice_date' => Carbon::now('Asia/Kolkata')->format('Y-m-d'),
            'due_date' => $expiryDate,
            // Add other fields as needed
        ];
        $invoice = new rechargeinvoice($invoiceData);
        $invoiceHIstory = new invoiceHistory($invoiceData);
        $invoiceHIstory->save(); 
        $invoice->save();
        return $invoice;
    }
    
    public static function invoice_Receipt($req, $invoice)
    {
        $randomNo = mt_rand(10000, 99999);
        $salt = env('MY_HASHING_SALT');
        $hashcvc = HashHelper::hashWithSalt($req->cvvcvc, $salt);

        $invoiceData = [
            'receipt_no' => $randomNo,
            'user_id' => $invoice->user_id,
            'subs_id' => $invoice->subs_id,
            'email' => $invoice->email,
            'phone' => $invoice->phone,
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'software' => $invoice->software,
            'planInfo' => $invoice->planInfo,
            'paid_amount' => $invoice->paid_amount,
            'paymentStatus' => $invoice->paymentStatus,
            'payment_method' => $req->payment_method, // Replace with actual payment method
            'holder_name' => $req->holderName,
            'cardExpiryDate' => $req->cardExpiryDate,
            'cvvcvc' => $hashcvc,
            'payment_id' => $req->card_number, // Replace with actual payment method
            'payment_date' => Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s'), // Replace with actual payment date
            // Add other fields as needed
        ];
        $receipt = new invoicereceipts($invoiceData);
        $bill = new billinghistory($invoiceData);
        $receipt->save();
        $bill->save();
        return $receipt;
    }
    public static function billing($invoice)
    {
        $invoiceData = [
            'user_id' => $invoice->user_id,
            'subs_id' => $invoice->subs_id,
            'email' => $invoice->email,
            'bill_no' => $invoice->invoice_number,
            'payment_method' => $invoice->payment_method, // Replace with actual payment method
            'cardExpiryDate' => $invoice->cardExpiryDate,
            'cvvcvc' => $invoice->cvvcvc,
            'payment_id' => $invoice->payment_id,
            'software' => $invoice->software,

            'plan' => $invoice->planInfo,
            'total' => $invoice->paid_amount,
        ];
        $bill = new billinghistory($invoiceData);

        return $bill->save();
    }
    public static function action_log($user)
    {
        $invoiceData = [
            'user_id' => $user->user_id,
            'subs_id' => $user->subs_id,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'planInfo' => $user->planInfo,
            'action' => $user->activationStatus,
        ];
        $receipt = new activateaction($invoiceData);
        return $receipt->save();
    }
}
