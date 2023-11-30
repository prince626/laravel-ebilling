<?php
public function update_Subscription(Request $req, $id)
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
"paymentStatus" => "required",
]);

if ($validator->fails()) {
return ApiHelpers::validationError($validator->errors(), $ret);
}
$ret->trace .= 'validated, ';

$subscription = usersubscription::where('subs_id', $id)->first();
if (!$subscription) {
return SendResponse::jsonError($ret, 'Integrity_error', 'Token');
}
$expiryDate = null;
$duration = planvalidities::where('id', $req->duration)->first();
$plan = planpricing::where('id', $req->plan)->first();
$addons = planaddons::where('id', $req->addons)->first();
$now = Carbon::now('Asia/Kolkata')->format('Y-m-d');

$amount = null;
if ($plan !== null) {
$amount = $plan->price;
}
$userDuration = (int)$addons->duration;
$userDurationType = $addons->durationType;
$expiryDate = CalculateHelper::calculateExpiryDate($duration);
if ($req->addons != null) {
$amount = $addons->price;
$userDuration = (int)$addons->duration;
$userDurationType = $addons->durationType;
$expiryDate = CalculateHelper::calculateExpiryDate($addons);
}
if (
$subscription->duration != $duration->duration ||
$subscription->durationType != $duration->durationType
) {
// Current date and time
$updateexpiryDate = Carbon::parse($subscription->expiryDate);
$updateduration = $updateexpiryDate->diffInDays($now);
$expiryDate->addDays($updateduration);
$expiryDate = $expiryDate->format('Y-m-d');
}

$subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $subscription, $addons, $userDuration, $expiryDate, $userDurationType, $amount);
if ($subsHistory) {
$subscription->startDate = $now;
$subscription->expiryDate = $expiryDate;
$subscription->save();
if ($subsHistory->paymentStatus === 'pending') {
$response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
$response = redirect('/subscription');
return $response;
}
$expiryDate = CalculateHelper::calculateExpiryDate($subsHistory);
$createInvoice = InvoicesHelper::subs_invoice($subsHistory, $expiryDate);
if (!$createInvoice) {
$response = UpdateHelper::notification($req, 'isAdmin', $subsHistory, "Dear {$subsHistory->email}, we regret to inform you that there is a delay in creating your invoice due to the following reason: Technical issues causing delay. We apologize for any inconvenience this may cause. Our team is working to resolve the issue. Thank you for your understanding.", 'alert');
$response = SendResponse::jsonError($ret, 'Intigrity_error', 'subs_invoice');;
return $response;
}
$ret->trace .= 'invoice_created, ';
$createInvoice = InvoicesHelper::invoice_Receipt($createInvoice);
if ($createInvoice) {
$ret->trace .= 'receipt_created, ';
InvoicesHelper::autoAction_log($subsHistory);
InvoicesHelper::billing($createInvoice);
$ret->trace .= 'created_bill, ';
}
$response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
$response = SendResponse::SendResponse($ret, 'payment_successfully', $subsHistory);
// $response = redirect('/subscription');
return $response;
}
$response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'subscription_failed', 'failed');

$response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
// $response = redirect('/subscription');
return $response;
} catch (\Exception $e) {
return ApiHelpers::serverError($e);
}
}

$discountAmount = $refundAmount - $amount;
                $card = [
                    'amount' => $amount,
                    'refundAmount' => $refundAmount,
                ]

$createSubscription = [
    'user_id' => $subscription->user_id,
    'subs_id' => $subscription->subs_id,
    'email' => $subscription->email,
    'phone' => $subscription->phone,
    'software' => $subscription->software,
    'subscriptionType' => $req->addons && $addons ? $addons->name : null,
    'business_Category' => $businessCategory->name,
    'subscriptionStatus' => 'inactive',
    'planInfo' => $plan->name,
    'Duration' => $userDuration,
    'startDate' => $now,
    'expiryDate' => $expiryDate->format('Y-m-d'),
    'durationType' => $userDurationType,
    'amount' => $discountAmount,
    'accept' => $req->accept,
    'paymentStatus' => 'pending',
    'kit' => HashHelper::createCustomToken(),
];
// if ($createSubscription) {
//     $subscription->delete();
//     $ret->trace .= 'Database_inserted, ';
//     $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $createSubscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $discountAmount);
//     $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
$response = view('user.updatePayment')->with(['card' => $card, 'subscription' => $createSubscription]);
return $response;
// }