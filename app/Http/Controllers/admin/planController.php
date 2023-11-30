<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Http\Controllers\Controller;
use App\Models\addons;
use App\Models\plan;
use App\Models\planaddons;
use App\Models\plancategory;
use App\Models\planpricing;
use App\Models\planvalidities;
use App\Models\software;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class planController extends Controller
{
    function create_plan(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $rules = array(
                "businessCategory" => "required",
                "plan" => "required",
                "amount" => "required",
                "duration" => "required",
                "addons" => "required",
                "durationType" => "required",
            );
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $randomId = mt_rand(10000, 99999);
            $plan = new plan;
            $plan->id = $randomId;
            $plan->businessCategory = $req->businessCategory;
            $plan->plan = $req->plan;
            $plan->duration = $req->duration;
            $plan->addons = $req->addons;
            $plan->durationType = $req->durationType;
            $plan->save();
            $ret->trace .= 'Database_inserted, ';
            UpdateHelper::notification($req, 'isUser', $plan, 'new plan created', 'success');
            return SendResponse::SendResponse($ret, 'Plan Created', $plan);
            // return $this->jsonResponsewithData($ret, 'User activation edited', ApiHelpers::jsonUserData($user), 200);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    function all_plans(Request $req,$name)
    {
        try {
            $ret = ApiHelpers::ret();
            $software = software::all();
            $categories = plancategory::all();
            $pricings = planpricing::all();
            $validities = planvalidities::all();
            $addons = planaddons::all();

            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'userId');
            }
            if (!$software || !$categories || !$pricings || !$validities) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'plans Not Found');
            }
            $ret->trace .= 'Integrity_check, ';
            $data = [
                'software' => $software,
                'categories' => $categories,
                'pricings' => $pricings,
                'validities' => $validities,
                'user' => $user,
                'addons' => $addons
            ];
            $response =  SendResponse::SendResponse($ret, 'all plans', $data);
            return view('user.'.$name)->with([
                'software' => $software,
                'categories' => $categories,
                'pricings' => $pricings,
                'validities' => $validities,
                'user' => $user,
                'addons' => $addons
            ]);
            // return $data;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    function delete_plan(Request $req, $id)
    {

        try {
            $ret = ApiHelpers::ret();

            $plan =  plan::where('id', '=', $id)->delete();
            if (!$plan) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'plan Not Found');
            }
            $ret->trace .= 'Integrity_check, ';

            return SendResponse::SendResponse($ret, 'plan deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    function update_plan(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();

            $rules = array(
                "businessCategory" => "required",
                "plan" => "required",
                "amount" => "required",
                "duration" => "required",
                "addons" => "required",
                "durationType" => "required",
            );
            $validator = Validator::make($req->all(), $rules);

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';

            $plan = plan::where('id', "=", $id)->first();
            if (!$plan) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'plan Not Found');
            }
            $ret->trace .= 'integrity_check, ';

            $plan->businessCategory = $req->businessCategory;
            $plan->plan = $req->plan;
            $plan->duration = $req->duration;
            $plan->addons = $req->addons;
            $plan->durationType = $req->durationType;
            $result = $plan->update();
            if ($result) {
                $ret->trace .= 'Database_inserted, ';
                return SendResponse::SendResponse($ret, 'plan updated', $plan);
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
