<?php

namespace App\Http\Controllers\auth\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiHelpers;
use App\Helpers\CalculateHelper;
use App\Helpers\HashHelper;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\SubscriptionHelper;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Models\activateaction;
use App\Models\cancelsubscription;
use App\Models\invoicehistory;
use App\Models\planaddons;
use App\Models\plancategory;
use App\Models\planpricing;
use App\Models\planvalidities;
use App\Models\rechargeinvoice;
use App\Models\software;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    // user after payment function-------------------->
    public function payment(Request $req, $id)
    {
        try {
            /* This code snippet is creating a new user subscription record in the database. */
            $ret = ApiHelpers::ret();
            $validator = Validator::make($req->all(), [
                "holderName" => "required",
                "card_number" => "required",
                "cardExpiryDate" => "required",
                "cvvcvc" => "required",
                "payment_method" => "required",
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $subscription = usersubscription::where('subs_id', $id)->first();
            $subscriptionHistory = subscriptionhistory::where('subs_id', $id)->first();
            $invoice = rechargeinvoice::where('subs_id', $id)->first();
            $invoiceHistory = invoicehistory::where('subs_id', $id)->first();
            if (!$subscription && $subscriptionHistory) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
            }
            $expiryDate = CalculateHelper::calculateExpiryDate($subscription);
            $subscription->paymentStatus = 'paid';
            $subscription->expiryDate = $expiryDate->format('Y-m-d');
            $subscription->save();

            $subscriptionHistory->expiryDate = $expiryDate->format('Y-m-d');
            $subscriptionHistory->paymentStatus = 'paid';
            $subscriptionHistory->save();
            if ($subscription && $subscriptionHistory) {
            $expiryDate = CalculateHelper::calculateExpiryDate($subscription);
            $invoice->due_date = $expiryDate->format('Y-m-d');
                $invoice->paymentStatus = 'paid';
                $invoice->save();
                $invoiceHistory->due_date = $expiryDate->format('Y-m-d');
                $invoiceHistory->paymentStatus = 'paid';
                $invoiceHistory->save();

                // $createInvoice = InvoicesHelper::subs_invoice($subscription, $expiryDate);
                if (!$invoice) {
                    $response = UpdateHelper::notification($req, 'isAdmin', $subscription, "Dear {$subscription->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
                    $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
                    return $response;
                }
                $ret->trace .= 'invoice_created, ';
                $createInvoice = InvoicesHelper::invoice_Receipt($req, $invoice);
                if ($createInvoice) {
                    $ret->trace .= 'receipt_created, ';
                    InvoicesHelper::autoAction_log($subscription);
                    // InvoicesHelper::billing($createInvoice);
                    $ret->trace .= 'created_bill, ';
                }
                $response =  UpdateHelper::notification($req, 'isUser', $subscription, 'Your payment has been successfull completed', 'success');
                $response = SendResponse::SendResponse($ret, 'payment_successfully', $subscription);
                // $response = redirect('api/user/subscription');
                return $response;
            }
            $response = UpdateHelper::notification($req, 'isUser', $subscription, 'subscription_failed', 'alert');

            $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
            // $response = redirect('/subscription');
            $ret->trace .= 'Database_inserted, ';

            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // update Payment------------------->
    // public function updatePayment(Request $req, $id)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $subscription = usersubscription::where('subs_id', $id)->first();
    //         $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //         $createSubscription = usersubscription::create([
    //             'user_id' => $req->user_id,
    //             'subs_id' => $req->subs_id,
    //             'email' => $req->email,
    //             'phone' => $req->phone,
    //             'software' => $req->software,
    //             'subscriptionType' => $req->subscriptionType,
    //             'business_Category' => $req->business_Category,
    //             'subscriptionStatus' => 'inactive',
    //             'planInfo' => $req->planInfo,
    //             'Duration' => $req->Duration,
    //             'startDate' => $now,
    //             'expiryDate' => $req->expiryDate,
    //             'durationType' => $req->durationType,
    //             'amount' => $req->amount,
    //             'accept' => $req->accept,
    //             'paymentStatus' => 'paid',
    //             'kit' => HashHelper::createCustomToken(),
    //         ]);
    //         if ($createSubscription) {
    //             $subsHistory = subscriptionhistory::create([
    //                 'user_id' => $createSubscription->user_id,
    //                 'subs_id' => $createSubscription->subs_id,
    //                 'email' => $createSubscription->email,
    //                 'phone' => $createSubscription->phone,
    //                 'software' => $createSubscription->software,
    //                 'subscriptionType' => $createSubscription->subscriptionType,
    //                 'subscriptionStatus' => 'inactive',
    //                 'business_Category' => $createSubscription->business_Category,
    //                 'planInfo' => $createSubscription->planInfo,
    //                 'paymentStatus' => $createSubscription->paymentStatus,
    //                 'duration' => $createSubscription->Duration,
    //                 'startDate' => $now,
    //                 'expiryDate' => $createSubscription->expiryDate,
    //                 'durationType' => $createSubscription->durationType,
    //                 'amount' => $createSubscription->amount,
    //             ]);
    //             $subscription->delete();
    //             $ret->trace .= 'Database_inserted, ';
    //             $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //             $response = redirect('api/user/subscription');
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
}
