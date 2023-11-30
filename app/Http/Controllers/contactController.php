<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Helpers\ValidateHelpers;
use App\Models\contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class contactController extends Controller
{
    public function contact(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "name" => "required",
                "businessName" => "required",
                "email" => "required",
                "phone" => ["required", "regex:/^[0-9]{10}$/"],
                "city" => "required",
                "message" => "required"
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            // $userFound = User::where('user_id', '=', $id)->first();
            // if (!$userFound) {
            //     return SendResponse::jsonError($ret, 'Integrity_error', 'Users Not Found');
            // }
            $ret->trace .= 'Integrity_Check, ';
            $randomId = mt_rand(10000, 99999);

            $contact = new contact([
                'user_id' => $randomId,
                'name' => $req->name,
                'businessName' => $req->businessName,
                'email' => $req->email,
                'phone' => $req->phone,
                'city' => $req->city,
                'message' => $req->message,
                'read' => false,
            ]);

            if ($contact->save()) {
                $ret->trace .= 'Database_Inserted, ';
                $response = UpdateHelper::notification($req, 'isUser', $contact, 'Message sent succesfully', 'success');
                $response = SendResponse::SendResponse($ret, 'send message successfully', $contact);
                $response = redirect('/api/user/contact');
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
