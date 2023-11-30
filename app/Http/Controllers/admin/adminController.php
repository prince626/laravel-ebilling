<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\ticket;
use App\Models\ticketmessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function userTickets()
    {
        // Fetch chat messages where the type is 'user' and the status is not 'completed'
        $ret = ApiHelpers::ret();

        $ticket = ticket::all();

        $response = view('admin.userMessages')->with(['messages' => $ticket, 'adminId' => auth()->id()]);
        $ret->trace .= 'get_data, ';

        return $response;
    }

    public function adminChat($id)
    {
        // Fetch chat messages for the admin
        $ret = ApiHelpers::ret();
        $ticket = ticket::where('ticketId', $id)->first();
        $messages = ticketmessage::where('ticketId', $id)->get();
        // return $ticket;
        $response = view('admin.adminChat')->with(['messages' => $messages, 'ticket' => $ticket]);
        $ret->trace .= 'get_data, ';

        return $response;
    }
    public function adminSendMessage(Request $req, $id)
    {
        $ret = ApiHelpers::ret();

        // Validate and store admin's message
        $req->validate([
            'message' => 'required|string',
        ]);
        $ret->trace .= 'validated, ';

        $user = ticket::where('ticketId', $id)->first();
        if (!$user) {

            return ApiHelpers::jsonError($ret, 'Integrity_error', 'User Not Found');
        }
        $ret->trace .= 'integrity_check, ';

        $createMessage = ticketmessage::create([
            'type' => 'Admin',
            'adminId' => '12345',
            'ticketId' => $id,
            'message_id' => mt_rand(10000, 99999),
            'message' => $req->input('message'),
            'status' => 'read',
        ]);
        if ($createMessage) {
            $ticket = ticket::where('ticketId', $createMessage->ticketId)->first();
            UpdateHelper::notification($req, 'isAdmin', $user, 'Admin : ' . $req->input('message'), 'alert');
            $ticket->status = 'open';
            $ticket->save();
            $ret->trace .= 'database_inserted, ';
        }
        return redirect('api/admin/adminChat/' . $id);
    }
    public function ticketAction(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();

            $userFound = ticket::where('ticketId', $id)->first();
            if (!$userFound) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
            }
            $ret->trace .= 'Integrity_check, ';

            if ($userFound->status === 'open') {
                $userFound->status = 'closed';
            } else {
                $userFound->status = 'open';
            }
            $userFound->save();
            $ret->trace .= 'status_updated, ';

            // if ($userFound->status === 'open') {
            //     $latestUserMessage = ticketmessage::where('ticketId', $userFound->ticketId)
            //         ->where('type', 'user')
            //         ->latest()
            //         ->first();

            $message = new ticketmessage([
                'type' => 'Admin',
                'ticketId' => $userFound->ticketId,
                'message_id' => mt_rand(10000, 99999),
                'message' => 'Admin ticket ' . $userFound->status,
                'status' => 'generate',
            ]);

            $message->save();
            // }
            UpdateHelper::notification($req, 'isAdmin', $userFound, 'Admin Ticket ' . $userFound->status, 'success');
            $ret->trace .= 'Database_Inserted, ';
            $response =  SendResponse::sendResponse($ret, 'send message successfully', $userFound);
            $response = redirect('api/admin/users_messages');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    public function completeTicket(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();
            // $validator = Validator::make($req->all(), [
            //     "message" => "required",
            // ]);

            // if ($validator->fails()) {
            //     return ApiHelpers::validationError($validator->errors(), $ret);
            // }
            // $ret->trace .= 'validated, ';
            $userFound = ticket::where('ticketId', $id)->first();
            if (!$userFound) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
            }
            $ret->trace .= 'Integrity_check, ';

            $message = new ticketmessage([
                'type' => 'Admin',
                'ticketId' => $userFound->ticketId,
                'message_id' => mt_rand(10000, 99999),
                'message' => 'Admin solved your Problem',
                'status' => 'solved',
            ]);
            $userFound->status = 'solved';
            $userFound->save();
            $message->save();
            $ret->trace .= 'Database_Inserted, ';
            UpdateHelper::notification($req, 'isAdmin', $userFound, 'Admin solved your Problem', 'success');
            $response =  SendResponse::sendResponse($ret, 'send message successfully', $userFound);
            $response = redirect('api/admin/users_messages');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
