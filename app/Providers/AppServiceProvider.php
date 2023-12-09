<?php

namespace App\Providers;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Models\logaction;
use App\Models\notification;
use App\Models\rechargeinvoice;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $ret = ApiHelpers::ret();
            $user = User::where('user_id', auth()->id())->first();
            if (!$user) {
                return SendResponse::jsonError($ret, 'Integrity_error', 'user_id');
            }
            $subscription =  usersubscription::where('user_id', auth()->id())->get();
            $rechargeinvoices = rechargeinvoice::where('user_id', auth()->id())->get();
            $passwordUpdated = LogAction::where('user_id', auth()->id())
            ->latest('created_at') 
            ->take(9) 
            ->get();

          
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
                $unreadData = collect($unreadData)->filter(function ($item) {
                    $createdAt =  Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at, 'Asia/Kolkata');
                    $timeDifference = $createdAt->diffInMinutes(Carbon::now('Asia/Kolkata'));
                    return $timeDifference < 20;
                })->all();
            }
            $ret->trace .= 'get_data, ';

            $ret->trace .= 'Integrity_Check, ';
            $response = SendResponse::SendResponse($ret, 'Success', $unreadData);
            $view->with(['messageCount' => $unreadData, 'user' => $user, 'user_subscription' => $subscription, 'user_invoices' => $rechargeinvoices, 'activities' => $passwordUpdated]);
        });
        // View::composer('*', function ($view) {
        //     $ret = ApiHelpers::ret();
        //     $user = User::where('user_id', auth()->id())->first();

        //     if (!$user) {
        //         return SendResponse::jsonError($ret, 'Integrity_error', 'user_id');
        //     }

        //     $notifications = Notification::where('user_id', $user->user_id)->get()->reverse();
        //     $thirtyDaysAgo = Carbon::now()->subDays(30);

        //     $unreadData = collect($notifications)->filter(function ($notification) use ($thirtyDaysAgo) {
        //         if (isset($notification->status) && $notification->status === 'read') {
        //             $createdAt = Carbon::parse($notification->created_at);

        //             if ($createdAt < $thirtyDaysAgo) {
        //                 Notification::where('sno', $notification->sno)->delete();
        //             }

        //             return false; // Exclude read messages
        //         }

        //         if (isset($notification->status) && $notification->status === 'unread') {
        //             $createdAt = Carbon::parse($notification->created_at);
        //             $timeDifference = $createdAt->diffInMinutes(Carbon::now());

        //             return $timeDifference < 20;
        //         }

        //         return false;
        //     })->all();

        //     $ret->trace .= 'get_data, ';
        //     $ret->trace .= 'Integrity_Check, ';
        //     $response = SendResponse::SendResponse($ret, 'Success', $unreadData);

        //     $view->with(['messageCount' => $unreadData, 'user' => $user]);
        // });
    }
}
