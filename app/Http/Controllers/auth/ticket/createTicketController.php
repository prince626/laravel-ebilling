<?php

namespace App\Http\Controllers\auth\ticket;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\ticket;
use App\Models\ticketmessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class createTicketController extends Controller
{

    // create ticket------------------------------------->
    public function sendMessage(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();

            $validator = Validator::make($req->all(), [
                "message" => "required",
                "softwareName" => "required"
            ]);

            if ($validator->fails()) {
                return ApiHelpers::validationError($validator->errors(), $ret);
            }
            $ret->trace .= 'validated, ';
            $userFound = User::where('user_id', '=', $id)->first();
            if (!$userFound) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
            }
            $ticketId = rand(10000, 99999);
            $ret->trace .= 'Integrity_Check, ';
            $createTicket = new ticket([
                'ticketId' => $ticketId,
                'user_id' => $userFound->user_id,
                'email' => $userFound->email,
                'phone' => $userFound->phone,
                'software_name' => $req->softwareName,
                'status' => 'generated',
            ]);
            $createTicket->save();
            if ($createTicket) {
                $message = new ticketmessage([
                    'type' => 'user',
                    'ticketId' => $createTicket->ticketId,
                    'message_id' => mt_rand(10000, 99999),
                    'message' => $req->message,
                    'status' => 'unread',
                ]);
                $message->save();
                $ret->trace .= 'Database_Inserted, ';
                UpdateHelper::notification($req, 'isUser', $createTicket, $req->input('message'), 'success');
                $response =  SendResponse::sendResponse($ret, 'send_message_successfully', $createTicket);
                // $response = redirect('/api/user/get_tickets');
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // user chat message------------------------------------------->

    public function userSendMessage(Request $request, $id)
    {
        // Validate and store user's message
        $ret = ApiHelpers::ret();
        $request->validate([
            'message' => 'required|string',
        ]);
        $ret->trace .= 'validated, ';
        $tickets = ticket::where('ticketId', '=', $id)->first();
        ticketmessage::create([
            'type' => 'user',
            'ticketId' => $id,
            'message_id' =>  mt_rand(10000, 99999),
            'message' => $request->input('message'),
            'status' => 'unread',
        ]);
        // UpdateHelper::notification($request, 'isUser', $tickets, $request->input('message'), 'success');
        $ret->trace .= 'database_inserted, ';
        $response =  SendResponse::sendResponse($ret, 'send message successfully', $tickets);
        // $response = redirect('/api/user/userChat/' . $id)->with('success', 'Message sent successfully');
        return $response;
    }
}
