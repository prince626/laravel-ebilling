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

class getTicketController extends Controller
{

    // get all tickets---------------------------------->
    public function getTickets(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            }
            $ret->trace .= 'token_valid, ';
            $tickets = ticket::where('user_id', '=', $user->user_id)->get();

            // Initialize an empty array for messages
            $messages = [];

            if (!$tickets) {
                $ret->trace .= 'user_not_found, ';
                return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
            }
            $ret->trace .= 'Integrity_check, ';
            foreach ($tickets as $ticket) {
                // Get the latest message for the ticket
                $latestMessage = ticketmessage::where('ticketId', $ticket->ticketId)
                    ->latest()
                    ->first();

                if ($latestMessage) {
                    if ($latestMessage->status === 'solved') {
                        $ticket->status = 'solved';
                        $ticket->save(); // Save the individual ticket
                    }
                }

                // Append the messages for the ticket
                $ticketMessages = ticketmessage::where('ticketId', $ticket->ticketId)->get();
                $messages[$ticket->ticketId] = $ticketMessages;
            }
            $ret->trace .= 'get_data, ';
            return view('user.tickets', ['tickets' => $tickets, 'messages' => $messages]);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }


    // get data for ticket form-------------------->
    public function getTicket_data(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();

            $ret = ApiHelpers::ret();
            $token  = request()->cookie('token');

            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            }
            $ret->trace .= 'Integrity_check, ';
            $ret->trace .= 'get_data, ';
            $response =  SendResponse::sendResponse($ret, 'send message successfully', SendResponse::jsonUserData($user));
            return  view('auth.ticket')->with(['user' => $user]);
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // get user ticket message------------------------->
    public function userChat($id)
    {
        $ret = ApiHelpers::ret();

        $tickets = ticket::where('ticketId', '=', $id)->first();
        $messages = ticketmessage::where('ticketId', $id)->get();
        // return view('user.userChat', compact('messages'));
        if (!$tickets) {
            $ret->trace .= 'Integrity_error, ';
            return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
        }
        $ret->trace .= 'Integrity_check, ';
        $ret->trace .= 'get_data, ';

        return view('user.userChat', ['tickets' => $tickets, 'messages' => $messages]);
        // return $messages;
    }
}
