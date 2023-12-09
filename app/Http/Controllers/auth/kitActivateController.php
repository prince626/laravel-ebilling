<?php

namespace App\Http\Controllers\auth;

use App\Helpers\CalculateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiHelpers;
use App\Helpers\InvoicesHelper;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class kitActivateController extends Controller
{

    // activate user kit------------------------>
    public function activate_kit(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "kit" => "required",
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->erraors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $user = usersubscription::where('kit', $req->kit)->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'Kit_not_valid');
            }
            $ret->trace .= 'Integrity_check, ';
            $now = Carbon::now('Asia/Kolkata');
            $expiryDate = CalculateHelper::calculateExpiryDate($user);
            $user->activationStatus = true;
            $user->subscriptionStatus = 'active';
            $user->expiryDate = $expiryDate;
            $user->update();
            $ret->trace .= 'Data_updated, ';
            InvoicesHelper::action_log($user);
            UpdateHelper::notification($req, 'isUser', $user, 'your subscription has been successfully activated', 'success');
            $response = SendResponse::SendResponse($ret, 'subscription_Activated', $user);
            // $response = redirect('api/user/subscription');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
