<?php

namespace App\Http\Controllers\auth;

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

class subscriptionController extends Controller
{
    // public function subscription(Request $req, $token)
    // {
    //     try {
    //         /* This code snippet is creating a new user subscription record in the database. */
    //         $ret = ApiHelpers::ret();

    //         $validator = Validator::make($req->all(), [
    //             "software" => "required",
    //             "businessCategory" => "required",
    //             "plan" => "required",
    //             "duration" => "required",
    //             "addons" => "required",
    //             "accept" => "required",
    //         ]);

    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $ret->trace .= 'validated, ';

    //         $userFound = User::where('token', $token)->first();
    //         $ret->trace .= 'Integrity_Check, ';

    //         $subscription = usersubscription::where('user_id', $userFound->user_id)->first();
    //         if (!$userFound) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not found');
    //         } else if (!$userFound->verify) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'User Not Verified');
    //         }

    //         $user = SubscriptionHelper::create_subscription($req, $userFound);
    //         if ($user) {
    //             SubscriptionHelper::create_subscriptionHistory($user);
    //             $ret->trace .= 'Database_inserted, ';
    //             if ($user->paymentStatus === 'pending') {
    //                 $response =  UpdateHelper::notification($req, 'isAdmin', $user, "Dear $user->email You are currently in grace mode.Your grace period will be expire in Two days  ", 'success');

    //                 $response = redirect('/subscription');
    //                 return $response;
    //             }
    //             $expiryDate = CalculateHelper::calculateExpiryDate($user);
    //             $createInvoice = InvoicesHelper::subs_invoice($user, $expiryDate);
    //             if (!$createInvoice) {
    //                 $response = UpdateHelper::notification($req, 'isAdmin', $user, "Dear {$user->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
    //                 $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
    //                 return $response;
    //             }
    //             $ret->trace .= 'invoice_created, ';
    //             $createInvoice = InvoicesHelper::invoice_Receipt($createInvoice);
    //             if ($createInvoice) {
    //                 $ret->trace .= 'receipt_created, ';
    //                 InvoicesHelper::autoAction_log($user);
    //                 InvoicesHelper::billing($createInvoice);
    //                 $ret->trace .= 'created_bill, ';
    //             }
    //             $response =  UpdateHelper::notification($req, 'isAdmin', $user, 'Your subscription has been completed', 'success');
    //             $ret->trace .= 'Database_inserted, ';

    //             $response = SendResponse::SendResponse($ret, 'payment_successfully', $user);
    //             $response = redirect('/subscription');
    //             return $response;
    //         }
    //         $response = UpdateHelper::notification($req, 'isUser', $user, 'subscription_failed', 'alert');

    //         $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
    //         // $response = redirect('/subscription');
    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }

    // public function get_Subscription(Request $req, $id)
    // {
    //     try {
    //         /* This code snippet is creating a new user subscription record in the database. */
    //         $ret = ApiHelpers::ret();
    //         $subscription = usersubscription::where('subs_id', $id)->first();
    //         if (!$subscription) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'user');
    //         }
    //         $ret->trace .= 'Integrity_check, ';

    //         $software = software::all();
    //         $categories = plancategory::all();
    //         $pricings = planpricing::all();
    //         $validities = planvalidities::all();
    //         $addons = planaddons::all();
    //         $ret->trace .= 'get_data, ';

    //         return view('user.updateSubscription')->with([
    //             'software' => $software,
    //             'categories' => $categories,
    //             'pricings' => $pricings,
    //             'validities' => $validities,
    //             'subscription' => $subscription,
    //             'addons' => $addons
    //         ]);
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function update_Subscription(Request $req, $id)
    // {
    //     try {

    //         /* This code snippet is creating a new user subscription record in the database. */
    //         $ret = ApiHelpers::ret();
    //         $validator = Validator::make($req->all(), [
    //             "software" => "required",
    //             "businessCategory" => "required",
    //             "plan" => "required",
    //             "duration" => "required",
    //             "paymentStatus" => "required",
    //         ]);

    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $ret->trace .= 'validated, ';

    //         $subscription = usersubscription::where('subs_id', $id)->first();
    //         if (!$subscription) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'Token');
    //         }
    //         $expiryDate = null;
    //         $duration = planvalidities::where('id', $req->duration)->first();
    //         $plan = planpricing::where('id', $req->plan)->first();
    //         $addons = planaddons::where('id', $req->addons)->first();
    //         $businessCategory = plancategory::where('id', $req->businessCategory)->first();

    //         $amount = null;
    //         if ($plan !== null) {
    //             $amount = $plan->price;
    //         }
    //         // $userDuration = (int)$duration->duration;
    //         // $userDurationType = $duration->durationType;
    //         $expiryDate = null;
    //         $userDuration = (int)$duration->duration;
    //         $userDurationType = $duration->durationType;
    //         if ($userDuration === 1) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addYear();
    //             }
    //         } elseif ($userDuration === 3) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
    //             }
    //         }
    //         // $expiryDate = CalculateHelper::calculateExpiryDate($duration);
    //         if ($req->addons != null) {
    //             if ($addons !== null) {
    //                 $amount = $addons->price;
    //                 $userDuration = (int)$addons->duration;
    //                 $userDurationType = $addons->durationType;

    //                 if ($userDuration === 1) {
    //                     if ($userDurationType === 'Month') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
    //                     } elseif ($userDurationType === 'Year') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addYear();
    //                     }
    //                 } elseif ($userDuration === 3) {
    //                     if ($userDurationType === 'Month') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
    //                     } elseif ($userDurationType === 'Year') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
    //                     }
    //                 }
    //             }
    //         }
    //         if (trim($subscription->business_Category) !== ($businessCategory->name)) {
    //             $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //             $startDate = Carbon::parse($subscription->startDate);
    //             $checkexpiryDate = Carbon::parse($subscription->expiryDate);

    //             $numberOfDays = $startDate->diffInDays($now);
    //             $duration = $checkexpiryDate->diffInDays($now);

    //             if ($numberOfDays >= $duration) {
    //                 $refundAmount = 0; // No refund if a full month has passed
    //             } else {
    //                 $costPerDay = $subscription->amount / $duration; // Assuming 30 days in a month
    //                 $refundAmount = abs(($numberOfDays * $costPerDay) - $subscription->amount);
    //             }
    //             $card = [
    //                 'amount' => $amount,
    //                 'refundAmount' => $refundAmount,

    //             ];
    //             $discountAmount = $refundAmount - $amount;
    //             $createSubscription = usersubscription::create([
    //                 'user_id' => $subscription->user_id,
    //                 'subs_id' => $subscription->subs_id,
    //                 'email' => $subscription->email,
    //                 'phone' => $subscription->phone,
    //                 'software' => $subscription->software,
    //                 'subscriptionType' => $req->addons && $addons ? $addons->name : null,
    //                 'business_Category' => $businessCategory->name,
    //                 'subscriptionStatus' => 'inactive',
    //                 'planInfo' => $plan->name,
    //                 'Duration' => $userDuration,
    //                 'startDate' => $now,
    //                 'expiryDate' => $expiryDate->format('Y-m-d'),
    //                 'durationType' => $userDurationType,
    //                 'amount' => $discountAmount,
    //                 'accept' => $req->accept,
    //                 'paymentStatus' => 'pending',
    //                 'kit' => HashHelper::createCustomToken(),
    //             ]);
    //             if ($createSubscription) {
    //                 $subscription->delete();
    //                 $ret->trace .= 'Database_inserted, ';
    //                 $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $createSubscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $discountAmount);
    //                 $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //                 $response = view('user.payment')->with(['subscription' => $createSubscription, 'refundAmount' => $refundAmount, 'amount' => $amount]);
    //                 return $response;
    //             }
    //         }
    //         if (
    //             $subscription->duration != $duration->duration ||
    //             $subscription->durationType != $duration->durationType
    //         ) {
    //             $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //             $updateexpiryDate = Carbon::parse($subscription->expiryDate);
    //             $updateduration = $updateexpiryDate->diffInDays($now);
    //             $expiryDate->addDays($updateduration)->format('Y-m-d');
    //             $expiryDate = $expiryDate->format('Y-m-d');
    //         }
    //         $now = Carbon::now('Asia/Kolkata')->format('Y-m-d');

    //         $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $subscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $amount);

    //         if ($subsHistory) {
    //             $subscription->startDate = $now;
    //             $subscription->amount = $amount;
    //             $subscription->expiryDate = $expiryDate;
    //             $subscription->Duration = $userDuration;
    //             $subscription->durationType = $userDurationType;
    //             $subscription->save();
    //             // if ($subsHistory->paymentStatus === 'pending') {
    //             //     $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //             //     $response = redirect('/subscription');
    //             //     return $response;
    //             // }


    //             $expiryDate = CalculateHelper::calculateExpiryDate($subsHistory);
    //             $createInvoice = InvoicesHelper::subs_invoice($subsHistory, $subsHistory->expiryDate);
    //             if (!$createInvoice) {
    //                 $response = UpdateHelper::notification($req, 'isAdmin', $subsHistory, "Dear {$subsHistory->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
    //                 $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
    //                 return $response;
    //             }

    //             $ret->trace .= 'invoice_created, ';
    //             $createInvoice = InvoicesHelper::invoice_Receipt($createInvoice);
    //             if ($createInvoice) {
    //                 $ret->trace .= 'receipt_created, ';
    //                 InvoicesHelper::autoAction_log($subsHistory);
    //                 InvoicesHelper::billing($createInvoice);
    //                 $ret->trace .= 'created_bill, ';
    //             }
    //             $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //             $response = SendResponse::SendResponse($ret, 'payment_successfully', $subsHistory);
    //             $response = redirect('/subscription');
    //             return $response;
    //         }

    //         $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'subscription_failed', 'alert');

    //         $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function update_Subscription(Request $req, $id)
    // {
    //     try {

    //         /* This code snippet is creating a new user subscription record in the database. */
    //         $ret = ApiHelpers::ret();
    //         $validator = Validator::make($req->all(), [
    //             "software" => "required",
    //             "businessCategory" => "required",
    //             "plan" => "required",
    //             "duration" => "required",
    //             "addons" => "required",
    //             "paymentStatus" => "required",
    //         ]);

    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $ret->trace .= 'validated, ';

    //         $subscription = usersubscription::where('subs_id', $id)->first();
    //         if (!$subscription) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'Token');
    //         }
    //         $ret->trace .= 'Integrity_check, ';

    //         $expiryDate = null;
    //         $duration = planvalidities::where('id', $req->duration)->first();
    //         $plan = planpricing::where('id', $req->plan)->first();
    //         $addons = planaddons::where('id', $req->addons)->first();
    //         $businessCategory = plancategory::where('id', $req->businessCategory)->first();

    //         $amount = null;
    //         if ($plan !== null) {
    //             $amount = $plan->price;
    //         }
    //         // $userDuration = (int)$duration->duration;
    //         // $userDurationType = $duration->durationType;
    //         $expiryDate = null;
    //         $userDuration = (int)$duration->duration;
    //         $userDurationType = $duration->durationType;
    //         if ($userDuration === 1) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addYear();
    //             }
    //         } elseif ($userDuration === 3) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
    //             }
    //         }
    //         // $expiryDate = CalculateHelper::calculateExpiryDate($duration);
    //         if ($req->addons != null) {
    //             if ($addons !== null) {
    //                 $amount = $addons->price;
    //                 $userDuration = (int)$addons->duration;
    //                 $userDurationType = $addons->durationType;

    //                 if ($userDuration === 1) {
    //                     if ($userDurationType === 'Month') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
    //                     } elseif ($userDurationType === 'Year') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addYear();
    //                     }
    //                 } elseif ($userDuration === 3) {
    //                     if ($userDurationType === 'Month') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
    //                     } elseif ($userDurationType === 'Year') {
    //                         $expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
    //                     }
    //                 }
    //             }
    //         }
    //         if (trim($subscription->business_Category) !== ($businessCategory->name)) {
    //             $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //             $startDate = Carbon::parse($subscription->startDate);
    //             $checkexpiryDate = Carbon::parse($subscription->expiryDate);

    //             $numberOfDays = $startDate->diffInDays($now);
    //             $duration = $checkexpiryDate->diffInDays($now);

    //             if ($numberOfDays >= $duration) {
    //                 $refundAmount = 0; // No refund if a full month has passed
    //             } else {
    //                 $costPerDay = $subscription->amount / $duration; // Assuming 30 days in a month
    //                 $refundAmount = abs(($numberOfDays * $costPerDay) - $subscription->amount);
    //                 // return $duration;
    //             }

    //             $discountAmount = $amount - $refundAmount;

    //             // $createSubscription = [
    //             //     'user_id' => $subscription->user_id,
    //             //     'subs_id' => $subscription->subs_id,
    //             //     'email' => $subscription->email,
    //             //     'phone' => $subscription->phone,
    //             //     'software' => $subscription->software,
    //             //     'subscriptionType' => $req->addons && $addons ? $addons->name : null,
    //             //     'business_Category' => $businessCategory->name,
    //             //     'subscriptionStatus' => 'inactive',
    //             //     'planInfo' => $plan->name,
    //             //     'Duration' => $userDuration,
    //             //     'startDate' => $now,
    //             //     'expiryDate' => $expiryDate->format('Y-m-d'),
    //             //     'durationType' => $userDurationType,
    //             //     'amount' => $discountAmount,
    //             //     'accept' => $req->accept,
    //             //     'paymentStatus' => 'pending',
    //             //     'kit' => HashHelper::createCustomToken(),
    //             // ];
    //             // $card = [
    //             //     'amount' => $amount,
    //             //     'refundAmount' => $refundAmount,
    //             //     'discountAmount' => $discountAmount,
    //             //     'createSubscription' => $createSubscription,
    //             // ];
    //             // $response = view('user.updatePayment')->with(['card' => $card]);
    //             // return $response;

    //             $createSubscription = usersubscription::create([
    //                 'user_id' => $subscription->user_id,
    //                 'subs_id' => $subscription->subs_id,
    //                 'email' => $subscription->email,
    //                 'phone' => $subscription->phone,
    //                 'software' => $subscription->software,
    //                 'subscriptionType' => $req->addons && $addons ? $addons->name : null,
    //                 'business_Category' => $businessCategory->name,
    //                 'subscriptionStatus' => 'inactive',
    //                 'planInfo' => $plan->name,
    //                 'Duration' => $userDuration,
    //                 'startDate' => $now,
    //                 'expiryDate' => $expiryDate->format('Y-m-d'),
    //                 'durationType' => $userDurationType,
    //                 'amount' => intval($discountAmount),
    //                 'accept' => $req->accept,
    //                 'paymentStatus' => $req->paymentStatus,
    //                 'kit' => HashHelper::createCustomToken(),
    //             ]);
    //             if ($createSubscription) {
    //                 $subscription->delete();
    //                 $ret->trace .= 'Database_inserted, ';
    //                 $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $createSubscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $discountAmount);
    //                 $createInvoice = InvoicesHelper::subs_invoice($subsHistory, $subsHistory->expiryDate);
    //                 $ret->trace .= 'invoice_created, ';

    //                 InvoicesHelper::invoice_Receipt($createInvoice);
    //                 $ret->trace .= 'receipt_created, ';

    //                 $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //                 $ret->trace .= 'Database_inserted, ';

    //                 // $response = view('user.payment')->with(['subscription' => $createSubscription, 'refundAmount' => $refundAmount, 'amount' => $amount]);
    //                 $response = redirect('/subscription');
    //                 return $response;
    //             }
    //         }
    //         if (
    //             $subscription->duration != $duration->duration ||
    //             $subscription->durationType != $duration->durationType
    //         ) {
    //             $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //             $updateexpiryDate = Carbon::parse($subscription->expiryDate);
    //             $updateduration = $updateexpiryDate->diffInDays($now);
    //             $expiryDate->addDays($updateduration)->format('Y-m-d');
    //             $expiryDate = $expiryDate->format('Y-m-d');
    //         }
    //         $now = Carbon::now('Asia/Kolkata')->format('Y-m-d');

    //         $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $subscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $amount);

    //         if ($subsHistory) {
    //             $subscription->startDate = $now;
    //             $subscription->amount = $amount;
    //             $subscription->subscriptionType = $req->addons && $addons ? $addons->name : null;
    //             $subscription->expiryDate = $expiryDate;
    //             $subscription->Duration = $userDuration;
    //             $subscription->durationType = $userDurationType;
    //             $subscription->save();
    //             // if ($subsHistory->paymentStatus === 'pending') {
    //             // $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //             // $response = redirect('/subscription');
    //             // return $response;
    //             // }


    //             $expiryDate = CalculateHelper::calculateExpiryDate($subsHistory);
    //             $createInvoice = InvoicesHelper::subs_invoice($subsHistory, $subsHistory->expiryDate);
    //             if (!$createInvoice) {
    //                 $response = UpdateHelper::notification($req, 'isAdmin', $subsHistory, "Dear {$subsHistory->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
    //                 $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
    //                 return $response;
    //             }

    //             $ret->trace .= 'invoice_created, ';
    //             $createInvoice = InvoicesHelper::invoice_Receipt($createInvoice);
    //             if ($createInvoice) {
    //                 $ret->trace .= 'receipt_created, ';
    //                 InvoicesHelper::autoAction_log($subsHistory);
    //                 InvoicesHelper::billing($createInvoice);
    //                 $ret->trace .= 'created_bill, ';
    //             }
    //             $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
    //             $ret->trace .= 'Database_inserted, ';

    //             $response = SendResponse::SendResponse($ret, 'payment_successfully', $subsHistory);
    //             $response = redirect('/subscription');
    //             return $response;
    //         }

    //         $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'subscription_failed', 'alert');

    //         $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function payment(Request $req, $id)c
    // {
    //     try {
    //         /* This code snippet is creating a new user subscription record in the database. */
    //         $ret = ApiHelpers::ret();
    //         $subscription = usersubscription::where('subs_id', $id)->first();
    //         $subscriptionHistory = subscriptionhistory::where('subs_id', $id)->first();
    //         if (!$subscription) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
    //         }
    //         $userDuration = (int)$subscription->Duration;
    //         $userDurationType = $subscription->durationType;
    //         $startDate = Carbon::parse($subscription->startDate);
    //         $expiryDate = null;
    //         if ($userDuration === 1) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = $startDate->addMonth();
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = $startDate->addYear();
    //             }
    //         } elseif ($userDuration === 3) {
    //             if ($userDurationType === 'Month') {
    //                 $expiryDate = $startDate->addMonths(3);
    //             } elseif ($userDurationType === 'Year') {
    //                 $expiryDate = $startDate->addYears(3);
    //             }
    //         }
    //         $subscription->paymentStatus = 'paid';
    //         $subscription->expiryDate = $expiryDate->format('Y-m-d');
    //         $subscription->save();

    //         $subscriptionHistory->expiryDate = $expiryDate->format('Y-m-d');
    //         $subscriptionHistory->paymentStatus = 'paid';
    //         $subscriptionHistory->save();
    //         if ($subscription && $subscriptionHistory) {
    //             $expiryDate = CalculateHelper::calculateExpiryDate($subscription);
    //             $createInvoice = InvoicesHelper::subs_invoice($subscription, $expiryDate);
    //             if (!$createInvoice) {
    //                 $response = UpdateHelper::notification($req, 'isAdmin', $subscription, "Dear {$subscription->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
    //                 $response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
    //                 return $response;
    //             }
    //             $ret->trace .= 'invoice_created, ';
    //             $createInvoice = InvoicesHelper::invoice_Receipt($createInvoice);
    //             if ($createInvoice) {
    //                 $ret->trace .= 'receipt_created, ';
    //                 InvoicesHelper::autoAction_log($subscription);
    //                 InvoicesHelper::billing($createInvoice);
    //                 $ret->trace .= 'created_bill, ';
    //             }
    //             $response =  UpdateHelper::notification($req, 'isUser', $subscription, 'Your payment has been successfull completed', 'success');
    //             $response = SendResponse::SendResponse($ret, 'payment_successfully', $subscription);
    //             $response = redirect('/subscription');
    //             return $response;
    //         }
    //         $response = UpdateHelper::notification($req, 'isUser', $subscription, 'subscription_failed', 'alert');

    //         $response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
    //         // $response = redirect('/subscription');
    //         $ret->trace .= 'Database_inserted, ';

    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function cancelSubscription(Request $req, $subsId)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $validator = Validator::make($req->all(), [
    //             "cancelationReason" => "required",
    //         ]);

    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $ret->trace .= 'validated, ';

    //         $userFound = usersubscription::where('subs_id', $subsId)->first();

    //         if (!$userFound) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_id');
    //         }

    //         // $cancelSubs = cancelsubscription::where('subs_id', $userFound->subs_id)->first();
    //         // if ($cancelSubs) {
    //         //     return SendResponse::jsonError($ret, 'Integrity_error', 'subscription_already_cancel');
    //         // }
    //         $ret->trace .= 'Integrity_Check, ';

    //         $foundAmount = rechargeinvoice::where('subs_id', $subsId)->latest()->first();
    //         if (!$foundAmount && $userFound->paymentStatus === 'pending') {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not_paid_user');
    //         }

    //         $now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
    //         $startDate = Carbon::parse($userFound->startDate);
    //         $expiryDate = Carbon::parse($userFound->expiryDate);

    //         $numberOfDays = $startDate->diffInDays($now);
    //         $duration = $expiryDate->diffInDays($now);

    //         if ($numberOfDays >= $duration) {
    //             $refundAmount = 0; // No refund if a full month has passed
    //         } else {
    //             $costPerDay = $userFound->amount / $duration; // Assuming 30 days in a month
    //             $refundAmount = abs(($numberOfDays * $costPerDay) - $userFound->amount);
    //             $refundAmount = intval($refundAmount);
    //         }
    //         $canceluser = cancelsubscription::create([
    //             'user_id' => $userFound->user_id,
    //             'subs_id' => $userFound->subs_id,
    //             'email' => $userFound->email,
    //             'phone' => $userFound->phone,
    //             'cancelationReason' => $req->cancelationReason,
    //             'cancelationDate' => $now,
    //             'subscriptionType' => $userFound->subscriptionType,
    //             'planInfo' => $userFound->planInfo,
    //             'Duration' => $userFound->Duration . ' ' . $userFound->durationType,
    //             'amount' => $userFound->amount,
    //             'refundAmount' => $refundAmount,
    //             'refundStatus' => 'Processed',
    //         ]);
    //         $ret->trace .= 'cancelSubs_created, ';

    //         // $userFound->activationStatus = false; // Toggle the 'activate' status
    //         // $userFound->subscriptionStatus = 'cancel';
    //         $userFound->delete(); // Save the changes

    //         if ($canceluser && $userFound) {
    //             $ret->trace .= 'user_success, ';
    //             UpdateHelper::notification($req, 'isUser', $userFound, 'Your subscription has been canceled', 'success');
    //             $response = SendResponse::SendResponse($ret, 'user_success', $canceluser);
    //             $message = 'Your subscription has been canceled';
    //             $ret->trace .= 'Subscription_deleted, ';

    //             $response = redirect('/cancel_subs?message=' . urlencode($message));
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
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
    //             $response = redirect('/subscription');
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
}
