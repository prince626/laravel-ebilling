<?php

namespace App\Http\Controllers\auth\subscription;


use App\Helpers\ApiHelpers;
use App\Helpers\CalculateHelper;
use App\Helpers\HashHelper;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\SubscriptionHelper;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\activateaction;
use App\Models\cancelsubscription;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class createSubscription extends Controller
{

    // create subscription----------------------------->
    public function subscription(Request $req, $token)
    {
        try {
            /* This code snippet is creating a new user subscription record in the database. */
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "software" => "required",
                "businessCategory" => "required",
                "plan" => "required",
                "duration" => "required",
                "addons" => "required",
                "accept" => "required",
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $userFound = User::where('token', $token)->first();
            $ret->trace .= 'Integrity_Check, ';

            $subscription = usersubscription::where('user_id', $userFound->user_id)->first();
            if (!$userFound) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'not found');
            } else if (!$userFound->verify) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'User Not Verified');
            }

            $createSubscription = SubscriptionHelper::create_subscription($req, $userFound);
            if ($createSubscription) {
                SubscriptionHelper::create_subscriptionHistory($createSubscription);
                $createInvoice = InvoicesHelper::subs_invoice($createSubscription, $createSubscription->expiryDate);
                $ret->trace .= 'subs_history, ';
                if ($createSubscription->paymentStatus === 'pending') {
                    $response =  UpdateHelper::notification($req, 'isAdmin', $createSubscription, "Dear $createSubscription->email You are currently in grace mode.Your grace period will be expire $createSubscription->expiryDate  ", 'warning');
                    $response = SendResponse::SendResponse($ret, 'subscription_Completed', $createSubscription->kit);

                    // $response = redirect('api/user/subscription');
                    return $response;
                }
                $expiryDate = CalculateHelper::calculateExpiryDate($createSubscription);
                // $createInvoice = InvoicesHelper::subs_invoice($createSubscription, $expiryDate->format('Y-m-d'));

                if (!$createInvoice) {
                    $response = UpdateHelper::notification($req, 'isAdmin', $createSubscription, "Dear {$createSubscription->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
                    $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
                    // $response = redirect('api/user/subscription');
                    return $response;
                }
                $ret->trace .= 'invoice_created, ';
                $createReceipt = InvoicesHelper::invoice_Receipt($req, $createInvoice);
                if ($createReceipt) {
                    $ret->trace .= 'receipt_created, ';
                    InvoicesHelper::autoAction_log($createSubscription);
                    // InvoicesHelper::billing($createReceipt);
                }

                $response =  UpdateHelper::notification($req, 'isAdmin', $createSubscription, 'User subscription has been completed', 'success');
                $ret->trace .= 'Database_inserted, ';

                // $response = SendResponse::SendResponse($ret, 'created_subscription', SendResponse::sendSubscriptions($user));

                $response = SendResponse::SendResponse($ret, 'subscription_Completed', $createSubscription->kit);
                // $response = redirect('api/user/subscription');
                return $response;
            }
            $response = UpdateHelper::notification($req, 'isUser', $userFound, 'subscription_failed', 'alert');

            $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
            // $response = redirect('/subscription');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
