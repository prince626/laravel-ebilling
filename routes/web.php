<?php

use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\planController;
use App\Http\Controllers\auth\forgetPasswordController;
use App\Http\Controllers\auth\getDataController;
use App\Http\Controllers\auth\invoices\getInvoiceController;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\notification\getNotificationController;
use App\Http\Controllers\auth\subscription\getSubscription;
use App\Http\Controllers\auth\subscriptionController;
use App\Http\Controllers\auth\ticket\getTicketController;
use App\Http\Controllers\auth\ticketController;
use App\Http\Controllers\FirstDataController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\verifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     redirect('/get/dashboard');
// });

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/forget_password', function () {
    return view('auth.forgetPassword');
});
Route::get('/verify_login', function () {
    return view('auth.verifylogin');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/dashboard', function () {
    return view('master1');
});




// Route::get('/login', [loginController::class, 'login']);

Route::get('/logout', [loginController::class, 'logout']);


Route::post('/register', [signupController::class, 'signUp']);


// Route::get('/dashboard', [FirstDataController::class, 'get_firstdata']);


Route::post('/verify_login', [loginController::class, 'verify_login']);

Route::get('/customer', [FirstDataController::class, 'get_firstdata']);

Route::get('/plans', [planController::class, 'all_plans']);


Route::get("/create/{token}", [loginController::class, 'create']);
Route::get("/get", [loginController::class, 'get']);

Route::get('/getfirstdata', [FirstDataController::class, 'get_firstdata']);
Route::post('/verify/{token}', [verifyController::class, 'verify']);
Route::post('/edit/signup', [signupController::class, 'edit_signup']);



Route::get('/forget_page', [forgetPasswordController::class, 'forgetData']);
Route::get('/create/{token}', [loginController::class, 'create']);


Route::post('/forget_password', [forgetPasswordController::class, 'forget_password']);
Route::get('/verify_forget/{name}', [forgetPasswordController::class, 'after_forget']);
// Route::get('/verify_forget', function () {
//     return view('auth.verifyforget');
// });

Route::middleware(['auth:api'])->group(function () {


    Route::get('/notifications', [getNotificationController::class, 'get_notifications']);
    Route::get('/get_alert', [getDataController::class, 'get_alert']);
    Route::get('/get/{name}', [getDataController::class, 'get_data']);
    Route::get('/edit/profile/{name}', [getDataController::class, 'get_data']);


    // Route::get('/notifications', [getDataController::class, 'get_notifications']);


    Route::get('/subscription', [getSubscription::class, 'get_subscriptions']);

    Route::get('user_update_plan/{id}', [getSubscription::class, 'get_Subscription']);

    Route::get('subs_history', [getSubscription::class, 'get_subscriptionHistory']);

    Route::get('/cancel_subs', [getSubscription::class, 'cancel_subscription']);



    Route::get('/api/invoices', [getInvoiceController::class, 'get_invoices']);

    Route::get('/recharge_invoices', [getInvoiceController::class, 'getRecharge_invoices']);

    Route::get('bill/history', [getInvoiceController::class, 'get_billHistory']);





    Route::get('/ticket', [getTicketController::class, 'getTicket_data']);

    // Route::get('/user_chat', [getTicketController::class, 'userChat']);

    Route::get('/get_tickets', [getTicketController::class, 'getTickets']);

    Route::get('/userChat/{id}', [getTicketController::class, 'userChat']);

    // Route::get('/latest/messages', [ticketController::class, 'get_LatestMessage']);




    Route::get('/adminChat/{id}', [adminController::class, 'adminChat']);

    Route::get('/users_messages', [adminController::class, 'userTickets']);
});
