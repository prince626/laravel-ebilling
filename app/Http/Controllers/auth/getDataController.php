<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\billinghistory;
use App\Models\cancelsubscription;
use App\Models\contact;
use App\Models\invoicereceipts;
use App\Models\notification;
use App\Models\paiduser;
use App\Models\rechargeinvoice;
use App\Models\subscriptionhistory;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class getDataController extends Controller
{
    // function get_data(Request $req, $name)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $user = User::where('user_id', auth()->id())->first();
    //         $subscription =  usersubscription::where('user_id',$user->user_id)->get();
    //         $rechargeinvoices = rechargeinvoice::where('user_id', $user->user_id)->get();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'Success', SendResponse::jsonUserData($user));
    //             $response = view('user.' . $name)->with(['user' => $user,'subscription'=>$subscription,'recharge'=>$rechargeinvoices]);
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }

    // get profile data---------------------------------->
    function getProfile_data(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user_id');
            } else {
                $notifications = notification::where('user_id', $user->user_id)->get()->reverse();
                if ($notifications) {
                    $thirtyDaysAgo = Carbon::now()->subDays(30);;
                    foreach ($notifications as $notification) {
                        if (isset($notification['status']) && $notification['status'] === 'read') {
                            $createdAt = Carbon::parse($notification['created_at']);
                            if ($createdAt < $thirtyDaysAgo) {
                                notification::where('sno', $notification['sno'])->delete();
                            }
                        }
                    }
                    $unreadData = collect($notifications)->filter(function ($item) {
                        return $item['status'] === 'unread';
                    })->all();
                }
                $ret->trace .= 'get_data, ';

                $ret->trace .= 'Integrity_Check, ';
                $response = SendResponse::SendResponse($ret, 'Success', SendResponse::jsonUserData($user));
                $response = view('master')->with(['user' => $user, 'messages' => $unreadData]);

                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
    // function get_invoices(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $invoices = invoicereceipts::where('user_id', auth()->id())->get();
    //         if (!$invoices) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_invoices');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'Success', $invoices);
    //             $response = view('user.invoices')->with('invoiceReceipt', $invoices);
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function cancel_subscription(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $user = User::where('user_id', auth()->id())->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         }
    //         $cancelSubs = cancelsubscription::where('user_id', $user->user_id)->get();
    //         if (!$cancelSubs) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_subscription');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'cancel_subs', $cancelSubs);
    //             $response = view('user.cancelSubs')->with('cancelSubs', $cancelSubs);

    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function get_notifications(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $token  = request()->cookie('token');
    //         $user = User::where('token', $token)->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         }
    //         $messages = notification::where('user_id', $user->user_id)->get();
    //         if (!$messages) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_messages');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'messages', $messages);
    //             $response = view('user.notifications')->with('messages', $messages);
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function get_subscriptions(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();
    //         $subscription =  usersubscription::where('user_id', auth()->id())->get();

    //         if (!$subscription) {
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'user_subscriptions', $subscription);
    //             $ret->trace .= 'get_data, ';

    //             return view('user.subscription')->with(['subscription' => $subscription]);
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function get_subscriptionHistory(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $subscription =  subscriptionhistory::where('user_id', auth()->id())->get();

    //         if (!$subscription) {
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions_history');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', $subscription);
    //             $ret->trace .= 'get_data, ';

    //             return view('user.subscriptionhistory')->with(['subscription' => $subscription]);
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function get_billHistory(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $bills =  billinghistory::where('user_id', auth()->id())->get();

    //         if (!$bills) {
    //             return ApiHelpers::jsonError($ret, 'Integrity_error', 'user_subscriptions_history');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'user_subscriptions_history', $bills);
    //             $ret->trace .= 'get_data, ';

    //             return view('user.billhistory')->with(['bills' => $bills]);
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function getRecharge_invoices(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $rechargeinvoices = rechargeinvoice::where('user_id', auth()->id())->get();
    //         if (!$rechargeinvoices) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'not_found_invoices');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $response = SendResponse::SendResponse($ret, 'Success', $rechargeinvoices);
    //             $ret->trace .= 'get_data, ';

    //             $response = view('user.recharge')->with('recharge', $rechargeinvoices);
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }
    // function get_notifications(Request $req)
    // {
    //     try {
    //         $ret = ApiHelpers::ret();

    //         $user = User::where('user_id', auth()->id())->first();
    //         if (!$user) {
    //             return SendResponse::jsonError($ret, 'Integrity_error', 'token');
    //         } else {
    //             $ret->trace .= 'Integrity_Check, ';
    //             $notifications = notification::where('user_id', $user->user_id)->get()->reverse();
    //             if ($notifications) {
    //                 $thirtyDaysAgo = Carbon::now()->subDays(30);;
    //                 foreach ($notifications as $notification) {
    //                     if (isset($notification['status']) && $notification['status'] === 'read') {
    //                         $createdAt = Carbon::parse($notification['created_at']);
    //                         if ($createdAt < $thirtyDaysAgo) {
    //                             notification::where('sno', $notification['sno'])->delete();
    //                         }
    //                     }
    //                 }
    //                 $unreadData = collect($notifications)->filter(function ($item) {
    //                     return $item['status'] === 'unread';
    //                 })->all();
    //             }
    //             $ret->trace .= 'get_data, ';

    //             $response = SendResponse::SendResponse($ret, 'Success', $unreadData);
    //             $response = view('user.notifications')->with(['messages' => $unreadData, 'user' => $user]);
    //             return $response;
    //         }
    //     } catch (\Exception $e) {
    //         return ApiHelpers::serverError($e);
    //     }
    // }

// get alerts------------------------------->
    function get_alert(Request $req)
    {
        try {
            $ret = ApiHelpers::ret();
            $token  = request()->cookie('token');

            $user = User::where('token', $token)->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'token');
            } else {
                $ret->trace .= 'Integrity_Check, ';
                $notification = notification::where('user_id', $user->user_id)->get();
                if ($notification) {
                    $unreadData = collect($notification)->filter(function ($item) {
                        return $item['status'] === 'unread' || $item['type'] === 'alert';
                    })->all();
                }
                $alertData = collect($unreadData)->filter(function ($item) {
                    return $item['type'] === 'alert';
                })->all();
                $response = SendResponse::SendResponse($ret, 'Success', $alertData);
                $response = view('user.notifications')->with(['alerts' => $alertData]);
                return $response;
            }
        } catch (\Exception $e) {
            return ApiHelpers::serverError($e);
        }
    }
}
