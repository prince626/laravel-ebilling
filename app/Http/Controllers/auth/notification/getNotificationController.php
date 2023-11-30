<?php

namespace App\Http\Controllers\auth\notification;

use App\Http\Controllers\Controller;
use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class getNotificationController extends Controller
{

    // get all notifications--------------------->
    function get_notifications(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $authCheck = request()->cookie('token');
            // return $authCheck;
            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $notifications = notification::where('user_id', $user->user_id)->get()->reverse();
                if ($notifications) {
                    $thirtyDaysAgo = Carbon::now()->addDays(30);
                    foreach ($notifications as $notification) {
                        if (isset($notification['status']) && $notification['status'] === 'read') {
                            $createdAt = Carbon::parse($notification['created_at']);
                            if ($createdAt > $thirtyDaysAgo) {
                                notification::where('sno', $notification->sno)->delete();
                            }
                        }
                    }
                    $unreadData = collect($notifications)->filter(function ($item) {
                        return $item['status'] === 'unread';
                    })->all();
                }
                $ret->trace .= 'get_data, ';

                $response = SendResponse::SendResponse($ret, 'Success', $unreadData);
                $response = view('user.notifications')->with(['messages' => $unreadData, 'user' => $user,'allMessages'=>$notifications]);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }

    // read notification----------------------------------->
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

    // read alerts------------------------->
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
            // $response = redirect('api/user/get/dashboard');
            return $response;
        }
    }

    // read all notifications-------------------------------->
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
            // return redirect('/api/user/notifications');
            return $response;
        }
    }
}
