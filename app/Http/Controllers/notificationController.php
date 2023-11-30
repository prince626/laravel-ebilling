<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\notification;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    function readNotification(Request $req, $sno)
    {
        $ret = ApiHelpers::ret();
        $user = notification::where('sno', $sno)->first();
        if (!$user) {
            return SendResponse::jsonError($ret, 'Integrity_error', 'token');
        } else {
            $ret->trace .= 'Integrity_Check, ';
            $user->status = 'read';
            $user->save();
            $ret->trace .= 'notification_updated, ';
            $response = SendResponse::SendResponse($ret, 'Success', $user);
            // $response = redirect('api/user/notifications');
            return $response;
        }
    }
    function readAlert(Request $req, $sno)
    {
        $ret = ApiHelpers::ret();
        $user = notification::where('sno', $sno)->first();
        if (!$user) {
            return SendResponse::jsonError($ret, 'Integrity_error', 'token');
        } else {
            $ret->trace .= 'Integrity_Check, ';
            $user->status = 'read';
            $user->save();
            $ret->trace .= 'notifications_read, ';
            $response = SendResponse::SendResponse($ret, 'Success', $user);
            $response = redirect('api/user/get/dashboard');
            return $response;
        }
    }
    function readAllNotification(Request $req, $userId)
    {
        $ret = ApiHelpers::ret();

        // Find all notifications for the specified user
        $notifications = Notification::where('user_id', $userId)->get();

        if ($notifications->isEmpty()) {
            return SendResponse::jsonError($ret, 'Integrity_error', 'token');
        } else {
            $ret->trace .= 'Integrity_Check, ';

            // Loop through each notification and update its status
            foreach ($notifications as $notification) {
                $notification->status = 'read';
                $notification->save();
            }

            $ret->trace .= 'notifications_read, ';

            $response = SendResponse::SendResponse($ret, 'Success', $notifications);

            // Redirect the user to the notifications page
            return redirect('/api/user/notifications');
        }
    }
}
