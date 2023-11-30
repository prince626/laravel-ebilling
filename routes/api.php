<?php

use App\Helpers\InvoicesHelper;
use App\Http\Controllers\admin\actionController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\invoicesController;
use App\Http\Controllers\admin\planController;
use App\Http\Controllers\admin\subscription\allSubscriptionController;
use App\Http\Controllers\admin\subscription\cancelSubscriptionController;
use App\Http\Controllers\admin\subscription\subscriptionAction;
use App\Http\Controllers\auth\forgetPasswordController;
use App\Http\Controllers\auth\getDataController;
use App\Http\Controllers\auth\invoices\cancelInvoiceControler;
use App\Http\Controllers\auth\invoices\getInvoiceController;
use App\Http\Controllers\auth\kitActivateController;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\notification\getNotificationController;
use App\Http\Controllers\auth\notification\readNotificationController;
use App\Http\Controllers\auth\payment\paymentController;
use App\Http\Controllers\auth\subscription\activateSubscription;
use App\Http\Controllers\auth\subscription\cancelSubs;
use App\Http\Controllers\auth\subscription\createSubscription;
use App\Http\Controllers\auth\subscription\getSubscription;
use App\Http\Controllers\auth\subscription\kitController;
use App\Http\Controllers\auth\subscription\updateSubscription;
use App\Http\Controllers\auth\subscriptionController;
use App\Http\Controllers\auth\ticket\createTicketController;
use App\Http\Controllers\auth\ticket\getTicketController;
use App\Http\Controllers\auth\ticket\ticketActionController;
use App\Http\Controllers\auth\ticketController;
use App\Http\Controllers\auth\updateController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\FirstDataController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\verifyController;
use App\Models\activateaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/encrypt', [loginController::class, 'encrypt']);

Route::get('/decrypt', [loginController::class, 'decrypt']);






// Route::post('/verify_login', [loginController::class, 'verify_login']);

Route::middleware(['auth:api'])->post('/verify_login', [loginController::class, 'verify_login']);

Route::middleware(['rate_limit'])->group(function () {

    Route::get('/create/{token}', [loginController::class, 'create']);


    Route::get('/getfirstdata', [FirstDataController::class, 'get_firstdata']);
    Route::post('/verify/{token}', [verifyController::class, 'verify']);
    Route::post('/edit/signup', [signupController::class, 'edit_signup']);


    Route::post('/login', [loginController::class, 'login']);
    Route::post('/verify_login', [loginController::class, 'verify_login']);
    Route::post('/forget_password', [forgetPasswordController::class, 'forget_password']);
    Route::post('/verify_forget', [forgetPasswordController::class, 'verify_forget']);



    Route::get('/customer', [FirstDataController::class, 'get_firstdata']);
    Route::get('/plans', [planController::class, 'all_plans']);

    Route::post('/register', [signupController::class, 'signUp']);
    // Route::post('/verify', [verifyController::class, 'verify']);
});

Route::post('/contact', [contactController::class, 'contact']);


Route::middleware(['auth:api'])->prefix('user')->group(function () {
    Route::get('/get', [loginController::class, 'get']);

    Route::get('/contact', function () {
        return view('user.contact');
    });
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    });
    Route::get('/profile', function () {
        return view('user.profile');
    });
    // Route::get('/view/plans', function () {
    //     return view('user.viewPlans');
    // });
    Route::get('/get_data', [loginController::class, 'get']);
    Route::get('/notifications', [getNotificationController::class, 'get_notifications']);
    // Route::get('/get_alert', [getDataController::class, 'get_alert']);
    // Route::get('/profile', [getDataController::class, 'get_data']);
    // Route::get('/edit/profile/{name}', [getDataController::class, 'get_data']);




    Route::get('/subscription', [getSubscription::class, 'get_user_subscriptions']);

    Route::get('user_update_plan/{id}', [getSubscription::class, 'get_Subscription']);

    Route::get('subs_history', [getSubscription::class, 'get_subscriptionHistory']);

    Route::get('/cancel_subs', [getSubscription::class, 'cancel_subscription']);


    Route::get('/receipt', [getInvoiceController::class, 'get_receipts']);

    Route::get('/read_receipt/{id}', [loginController::class, 'read_receipt']);

    Route::get('/recharge_invoices', [getInvoiceController::class, 'getRecharge_invoices']);

    Route::get('bill/history', [getInvoiceController::class, 'get_billHistory']);



    Route::get('/ticket', [getTicketController::class, 'getTicket_data']);

    // Route::get('/user_chat', [getTicketController::class, 'userChat']);

    Route::get('/get_tickets', [getTicketController::class, 'getTickets']);

    Route::get('/userChat/{id}', [getTicketController::class, 'userChat']);

    // Route::get('/latest/messages', [ticketController::class, 'get_LatestMessage']);




    Route::get('/adminChat/{id}', [adminController::class, 'adminChat']);

    Route::get('/users_messages', [adminController::class, 'userTickets']);


    Route::get('/logout', [loginController::class, 'logout']);
    Route::get('/get/profile/{id}', [getDataController::class, 'getProfile_data']);
    Route::post('/update/{id}', [updateController::class, 'user_update']);


    Route::post('/change_password', [forgetPasswordController::class, 'change_password']);
    Route::get('/forget_page/{name}', [forgetPasswordController::class, 'forgetData']);


    Route::post('/create_plan', [planController::class, 'create_plan']);

    Route::get('/plans/{name}', [planController::class, 'all_plans']);


    Route::post('/subs/{token}', [createSubscription::class, 'subscription']);
    Route::post('/cancel_subs/{id}', [cancelSubs::class, 'cancelSubscription']);
    Route::get('/get_subscriptions/{id}', [getSubscription::class, 'get_subscriptions']);

    Route::get('/get_cancel_subscription/{id}', [getSubscription::class, 'cancel_subscription']);

    Route::get('/update_sub/{id}', [getSubscription::class, 'all_plans']);

    Route::get('update_view_subs/{id}', [getSubscription::class, 'view_updateSubscription']);

    Route::post('update_subs/{id}', [updateSubscription::class, 'update_Subscription']);




    Route::post('/activate', [kitActivateController::class, 'activate_kit']);

    Route::get('/user-edit-key/{id}', [activateSubscription::class, 'edit_activation']);



    // Route::get('/get_notifications/{id}', [getDataController::class, 'get_notifications']);

    Route::post('/cancel_invoice/{invoice}', [cancelInvoiceControler::class, 'delete_invoice']);
    Route::post('/delete_receipt/{receipt}', [cancelInvoiceControler::class, 'delete_receipt']);

    Route::get('/delete_subs_receipt/{id}', [invoicesController::class, 'delete_subs_receipt']);

    // Route::post('/getresponse/{token}', [kitController::class, 'getresponse']);





    Route::get("/read/{sno}", [getNotificationController::class, 'readNotification']);
    Route::get("/alert/read/{sno}", [getNotificationController::class, 'readAlert']);
    Route::get("/read_all/{userId}", [getNotificationController::class, 'readAllNotification']);


    Route::post('/send_message/{id}', [createTicketController::class, 'sendMessage']);

    Route::get('ticket/action/{id}', [ticketActionController::class, 'ticketAction']);

    Route::post('send/message/{id}', [createTicketController::class, 'userSendMessage']);

    // Route::post('send/message/{id}', [ticketController::class, 'userSendMessage']);


    Route::post('payment/{id}', [paymentController::class, 'payment']);
    Route::post('/subs_update/{id}', [paymentController::class, 'updatePayment']);
});

// userSendMessage

Route::middleware(['isAdmin:api'])->prefix('admin')->group(function () {

    Route::get('/adminChat/{id}', [adminController::class, 'adminChat']);

    Route::get('/users_messages', [adminController::class, 'userTickets']);

    Route::get('/delete_subs_invoices/{id}', [invoicesController::class, 'delete_subs_invoices']);

    Route::get('/delete_subs_receipt/{id}', [invoicesController::class, 'delete_subs_receipt']);

    Route::post('/send/message/{id}', [adminController::class, 'adminSendMessage']);
    Route::post('solved/{id}', [adminController::class, 'completeTicket']);

    Route::get('all/Subscriptions', [allSubscriptionController::class, 'Admin_subscriptions']);
    Route::post('cancel_subs/{id}', [cancelSubscriptionController::class, 'adminCancelSubscription']);

    Route::get('user_subs_action/{id}', [subscriptionAction::class, 'users_editkey']);

    Route::get('/log/actions', [actionController::class, 'logAction']);

    Route::get('/actions', [actionController::class, 'activateAction']);

    Route::get('/action/{id}', [adminController::class, 'ticketAction']);
    // Route::post('/create-plan', [plansController::class, 'create_plan']);
    // Route::get('/delete-plan/{id}', [plansController::class, 'delete_plan']);
    // Route::get('/single-plan/{id}', [plansController::class, 'single_plan']);
    // Route::post('/update-plan/{id}', [plansController::class, 'update_plan']);
    // Route::get('/all-plans', [plansController::class, 'all_plans']);


    // Route::get('/user-edit-key/{id}', [adminController::class, 'users_editkey']);
    // Route::get("/all-paid-users", [paidUserController::class, 'paid_allUsers']);
    // Route::get("/paid-user-delete/{id}", [paidUserController::class, 'delete_paidUser']);


    // Route::post('/create-user', [userController::class, 'create_newuser']);
    // Route::get('/delete-user/{id}', [userController::class, 'delete_user']);
    // Route::get("/all-users", [userController::class, 'all_users']);
    // Route::post('/update-user/{id}', [userController::class, 'update_user']);

    // Route::get('/messages', [AdminContactController::class, 'getReadMessages']);
    // Route::get('/unread_messages', [AdminContactController::class, 'getUnreadMessages']);
    // Route::get('/get_message/{id}', [AdminContactController::class, 'getMessage']);
    // Route::get('/update_message/{sno}', [AdminContactController::class, 'updateMessage']);
});
