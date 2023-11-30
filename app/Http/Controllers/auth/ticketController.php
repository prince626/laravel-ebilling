<?php

namespace App\Http\Controllers\auth;

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

class ticketController extends Controller
{
    // public function sendMessage(Request $req, $id)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $validator = Validator::make($req->all(), [
    //             "message" => "required",
    //             "softwareName" => "required"
    //         ]);

    //         if ($validator->fails()) {
    //             return ApiHelpers::validationError($validator->errors(), $ret);
    //         }
    //         $ret->trace .= 'validated, ';
    //         $userFound = User::where('user_id', '=', $id)->first();
    //         if (!$userFound) {
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
    //         }
    //         $ticketId = rand(10000, 99999);
    //         $ret->trace .= 'Integrity_Check, ';
    //         $createTicket = new ticket([
    //             'ticketId' => $ticketId,
    //             'user_id' => $userFound->user_id,
    //             'email' => $userFound->email,
    //             'phone' => $userFound->phone,
    //             'software_name' => $req->softwareName,
    //             'status' => 'generated',
    //         ]);
    //         $createTicket->save();
    //         if ($createTicket) {
    //             $message = new ticketmessage([
    //                 'type' => 'user',
    //                 'ticketId' => $createTicket->ticketId,
    //                 'message_id' => mt_rand(10000, 99999),
    //                 'message' => $req->message,
    //                 'status' => 'unread',
    //             ]);
    //             $message->save();
    //             $ret->trace .= 'Database_Inserted, ';
    //             UpdateHelper::notification($req, 'isUser', $createTicket, 'Ticket created User message has been sent succesfully', 'success');
    //             $response =  SendResponse::sendResponse($ret, 'send_message_successfully', $createTicket);
    //             // $response = redirect('/api/user/get_tickets');
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function ticketAction(Request $req, $id)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $userFound = ticket::where('ticketId', $id)->first();
    //         if (!$userFound) {
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
    //         }
    //         if ($userFound->status === 'open') {
    //             $userFound->status = 'closed'; // Change status to "open"
    //         }  // Change status to "closed"
    //         else {
    //             $userFound->status = 'open';
    //         }
    //         $userFound->save();
    //         if ($userFound->status === 'open') {
    //             $latestUserMessage = ticketmessage::where('ticketId', $userFound->ticketId)
    //                 ->where('type', 'user')
    //                 ->latest()
    //                 ->first();
    //             $message = new ticketmessage([
    //                 'type' => 'user',
    //                 'ticketId' => $userFound->ticketId,
    //                 'message_id' => mt_rand(10000, 99999),
    //                 'message' => $latestUserMessage->message,
    //                 'status' => 'unread',
    //             ]);
    //             $message->save();
    //             UpdateHelper::notification($req, 'isUser', $userFound, $req->input('message'), 'success');
    //         }
    //         $ret->trace .= 'Database_Inserted, ';
    //         $response =  SendResponse::sendResponse($ret, 'send message successfully', $userFound);
    //         // $response = redirect('api/user/get_tickets');
    //         return $response;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }

    // public function getTickets(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();


    //         $user = User::where('user_id', auth()->id())->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         }
    //         $ret->trace .= 'token_valid, ';
    //         $tickets = ticket::where('senderId', '=', $user->user_id)->get();
    //         if (!$tickets) {
    //             $ret->trace .= 'user_not_found, ';
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
    //         }
    //         foreach ($tickets as $messages) {
    //             $messages = ticketmessage::where('message_id', $messages->message_id)->get();
    //             $messages->messages = $messages;
    //         }

    //         foreach ($tickets as $ticket) {
    //             // Get the latest message for the ticket
    //             $latestMessage = ticketmessage::where('ticketId', $ticket->ticketId)
    //                 ->latest()
    //                 ->first();

    //             if ($latestMessage) {
    //                 if ($latestMessage->status === 'completed') {
    //                     $ticket->status = 'completed';
    //                     $ticket->save(); // Save the individual ticket
    //                 }
    //             }
    //         }
    //         return view('user.tickets', ['tickets' => $tickets, 'messages' => $messages]);
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function getTickets(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $user = User::where('user_id', auth()->id())->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         }
    //         $ret->trace .= 'token_valid, ';
    //         $tickets = ticket::where('user_id', '=', $user->user_id)->get();

    //         // Initialize an empty array for messages
    //         $messages = [];

    //         if (!$tickets) {
    //             $ret->trace .= 'user_not_found, ';
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
    //         }
    //         $ret->trace .= 'Integrity_check, ';
    //         foreach ($tickets as $ticket) {
    //             // Get the latest message for the ticket
    //             $latestMessage = ticketmessage::where('ticketId', $ticket->ticketId)
    //                 ->latest()
    //                 ->first();

    //             if ($latestMessage) {
    //                 if ($latestMessage->status === 'solved') {
    //                     $ticket->status = 'solved';
    //                     $ticket->save(); // Save the individual ticket
    //                 }
    //             }

    //             // Append the messages for the ticket
    //             $ticketMessages = ticketmessage::where('ticketId', $ticket->ticketId)->get();
    //             $messages[$ticket->ticketId] = $ticketMessages;
    //         }
    //         $ret->trace .= 'get_data, ';
    //         return view('user.tickets', ['tickets' => $tickets, 'messages' => $messages]);
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }

    // public function userChat(Request $req, $id)
    // {
    //     $ret = ApiHelpers::ret();

    //     $tickets = ticket::where('ticketId', '=', $id)->first();
    //     $messages = ticketmessage::where('ticketId', $id)->get();
    //     // return view('user.userChat', compact('messages'));
    //     if (!$tickets) {
    //         $ret->trace .= 'Integrity_error, ';
    //         return ApiHelpers::jsonError($ret, 'Integrity_error', 'Users Not Found');
    //     }
    //     $ret->trace .= 'Integrity_check, ';
    //     $ret->trace .= 'get_data, ';

    //     return view('user.userChat', ['tickets' => $tickets, 'messages' => $messages]);
    //     // return $messages;
    // }
    // public function userSendMessage(Request $request, $id)
    // {
    //     // Validate and store user's message
    //     $ret = ApiHelpers::ret();
    //     $request->validate([
    //         'message' => 'required|string',
    //     ]);
    //     $ret->trace .= 'validated, ';
    //     $tickets = ticket::where('ticketId', '=', $id)->first();
    //     ticketmessage::create([
    //         'type' => 'user',
    //         'ticketId' => $id,
    //         'message_id' =>  mt_rand(10000, 99999),
    //         'message' => $request->input('message'),
    //         'status' => 'unread',
    //     ]);
    //     // UpdateHelper::notification($request, 'isUser', $tickets, $request->input('message'), 'success');
    //     $ret->trace .= 'database_inserted, ';
    //     return redirect('/api/user/userChat/' . $id)->with('success', 'Message sent successfully');
    // }
    // public function get_LatestMessage(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         // Fetch the user's tickets
    //         $tickets = ticket::where('user_id', auth()->id())->get();

    //         if ($tickets->isEmpty()) {
    //             $ret->trace .= 'user_not_found, ';
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'User Not Found');
    //         }
    //         $ret->trace .= 'Integrity_check, ';

    //         foreach ($tickets as $ticket) {
    //             // Get the latest message for the ticket
    //             $latestMessage = ticketmessage::where('ticketId', $ticket->ticketId)
    //                 ->latest()
    //                 ->first();

    //             if ($latestMessage) {
    //                 if ($latestMessage->status === 'completed') {
    //                     $ticket->status = 'completed';
    //                     $ticket->save(); // Save the individual ticket
    //                 }
    //                 $ticket->latestMessage = $latestMessage;
    //             }
    //         }
    //         $ret->trace .= 'get_data, ';

    //         return $latestMessage;
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function getTicket_data(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $ret = ApiHelpers::ret();
    //         $token  = request()->cookie('token');

    //         $user = User::where('user_id', auth()->id())->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         }
    //         $ret->trace .= 'Integrity_check, ';
    //         $ret->trace .= 'get_data, ';
    //         return  view('auth.ticket')->with(['user' => $user]);
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // public function adminChat()
    // {
    //     // Fetch chat messages for the admin
    //     $messages = ticketmessage::where('admin_id', auth()->id())->get();

    //     return view('admin-chat', compact('messages'));
    // }
}
