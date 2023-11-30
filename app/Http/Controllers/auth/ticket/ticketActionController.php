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

class ticketActionController extends Controller
{

    // ticket open and close action---------------------->
    public function ticketAction(Request $req, $id)
    {
        try {
            $ret = ApiHelpers::ret();

            $userFound = ticket::where('ticketId', $id)->first();
            if (!$userFound) {
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
            }
            if ($userFound->status === 'open') {
                $userFound->status = 'closed'; // Change status to "open"
            }  // Change status to "closed"
            else {
                $userFound->status = 'open';
            }
            $userFound->save();
            if ($userFound->status === 'open') {
                $latestUserMessage = ticketmessage::where('ticketId', $userFound->ticketId)
                    ->where('type', 'user')
                    ->latest()
                    ->first();
                $message = new ticketmessage([
                    'type' => 'user',
                    'ticketId' => $userFound->ticketId,
                    'message_id' => mt_rand(10000, 99999),
                    'message' => $latestUserMessage->message ? $latestUserMessage->message : null,
                    'status' => 'generate',
                ]);
                $message->save();
            }
            UpdateHelper::notification($req, 'isUser', $userFound,  'User Ticket ' . $userFound->status, 'success');
            $ret->trace .= 'Database_Inserted, ';

            $response =  SendResponse::sendResponse($ret, 'User Ticket ' . $userFound->status, $userFound);
            // $response = redirect('api/user/get_tickets');
            return $response;
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
