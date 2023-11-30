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
$businessCategory = plancategory::where('id', $req->businessCategory)->first();

$amount = null;
if ($plan !== null) {
$amount = $plan->price;
}
// $userDuration = (int)$duration->duration;
// $userDurationType = $duration->durationType;
$expiryDate = null;
$userDuration = (int)$duration->duration;
$userDurationType = $duration->durationType;
if ($userDuration === 1) {
if ($userDurationType === 'Month') {
$expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
} elseif ($userDurationType === 'Year') {
$expiryDate = Carbon::now('Asia/Kolkata')->addYear();
}
} elseif ($userDuration === 3) {
if ($userDurationType === 'Month') {
$expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
} elseif ($userDurationType === 'Year') {
$expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
}
}
// $expiryDate = CalculateHelper::calculateExpiryDate($duration);
if ($req->addons != null) {
if ($addons !== null) {
$amount = $addons->price;
$userDuration = (int)$addons->duration;
$userDurationType = $addons->durationType;

if ($userDuration === 1) {
if ($userDurationType === 'Month') {
$expiryDate = Carbon::now('Asia/Kolkata')->addMonth();
} elseif ($userDurationType === 'Year') {
$expiryDate = Carbon::now('Asia/Kolkata')->addYear();
}
} elseif ($userDuration === 3) {
if ($userDurationType === 'Month') {
$expiryDate = Carbon::now('Asia/Kolkata')->addMonths(3);
} elseif ($userDurationType === 'Year') {
$expiryDate = Carbon::now('Asia/Kolkata')->addYears(3);
}
}
}
}
if (trim($subscription->business_Category) !== ($businessCategory->name)) {
$now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
$startDate = Carbon::parse($subscription->startDate);
$checkexpiryDate = Carbon::parse($subscription->expiryDate);

$numberOfDays = $startDate->diffInDays($now);
$duration = $checkexpiryDate->diffInDays($now);

if ($numberOfDays >= $duration) {
$refundAmount = 0; // No refund if a full month has passed
} else {
$costPerDay = $subscription->amount / $duration; // Assuming 30 days in a month
$refundAmount = abs(($numberOfDays * $costPerDay) - $subscription->amount);
}

$discountAmount = $amount - $refundAmount;

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
$card = [
'amount' => $amount,
'refundAmount' => $refundAmount,
'discountAmount' => $discountAmount,
'createSubscription' => $createSubscription,
];
$response = view('user.updatePayment')->with(['card' => $card]);

// $createSubscription = usersubscription::create([
// 'user_id' => $subscription->user_id,
// 'subs_id' => $subscription->subs_id,
// 'email' => $subscription->email,
// 'phone' => $subscription->phone,
// 'software' => $subscription->software,
// 'subscriptionType' => $req->addons && $addons ? $addons->name : null,
// 'business_Category' => $businessCategory->name,
// 'subscriptionStatus' => 'inactive',
// 'planInfo' => $plan->name,
// 'Duration' => $userDuration,
// 'startDate' => $now,
// 'expiryDate' => $expiryDate->format('Y-m-d'),
// 'durationType' => $userDurationType,
// 'amount' => $discountAmount,
// 'accept' => $req->accept,
// 'paymentStatus' => 'pending',
// 'kit' => HashHelper::createCustomToken(),
// ]);
// if ($createSubscription) {
// $subscription->delete();
// $ret->trace .= 'Database_inserted, ';
// $subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $createSubscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $discountAmount);
// $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
// $response = view('user.payment')->with(['subscription' => $createSubscription, 'refundAmount' => $refundAmount, 'amount' => $amount]);
// return $response;
// }
}
if (
$subscription->duration != $duration->duration ||
$subscription->durationType != $duration->durationType
) {
$now = Carbon::now('Asia/Kolkata')->format('Y-m-d'); // Current date and time
$updateexpiryDate = Carbon::parse($subscription->expiryDate);
$updateduration = $updateexpiryDate->diffInDays($now);
$expiryDate->addDays($updateduration)->format('Y-m-d');
$expiryDate = $expiryDate->format('Y-m-d');
}
$now = Carbon::now('Asia/Kolkata')->format('Y-m-d');

$subsHistory = SubscriptionHelper::update_subscriptionHistory($req, $plan, $subscription, $addons, $userDuration, $expiryDate, $userDurationType, $businessCategory->name, $amount);

if ($subsHistory) {
$subscription->startDate = $now;
$subscription->amount = $amount;
$subscription->expiryDate = $expiryDate;
$subscription->Duration = $userDuration;
$subscription->durationType = $userDurationType;
$subscription->save();
// if ($subsHistory->paymentStatus === 'pending') {
// $response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'Your subscription has been completed', 'success');
// $response = redirect('/subscription');
// return $response;
// }


$expiryDate = CalculateHelper::calculateExpiryDate($subsHistory);
$createInvoice = InvoicesHelper::subs_invoice($subsHistory, $subsHistory->expiryDate);
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
$response = redirect('/subscription');
return $response;
}

$response = UpdateHelper::notification($req, 'isUser', $subsHistory, 'subscription_failed', 'alert');

$response = SendResponse::jsonError($ret, 'Payment_failed.', 'payment_not_succeed');
return $response;
} catch (\Exception $e) {
return ApiHelpers::serverError($e);
}
}