<?php

use App\Http\Controllers\Auth\AuthOtpController;
use App\Http\Controllers\EsewaController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
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
  
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();
  
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/subscription', [App\Http\Controllers\Auth\AuthOtpController::class, 'subscriptionpage'])->name('subscriptionpage.index');

Route::get('/subscription', [App\Http\Controllers\HomeController::class, 'subscription'])->name('subscriptionpage.index');
  
Route::controller(AuthOtpController::class)->group(function(){
    Route::get('otp/login', 'login')->name('otp.login');
    Route::post('otp/generate', 'generate')->name('otp.generate');
    Route::get('otp/verification/{user_id}', 'verification')->name('otp.verification');
    Route::post('otp/login', 'loginWithOtp')->name('otp.getlogin');
});
Route::get('/otp/verification/{user_id}', [App\Http\Controllers\Auth\AuthOtpController::class, 'verification'])->name('otp.verification');
Route::post('/otp/verify/{user_id}', [AuthOtpController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/check-balance', 'SMSController@checkBalance');



use App\Http\Controllers\SmsController;

Route::post('/send-sms', [SmsController::class, 'sendSMS']);

Route::get('/payment', [PaymentController::class, ' showForm']);
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('process.payment');
// Web routes file (web.php)

// Route for subscribing

Route::get('/subscribe-now', [App\Http\Controllers\SubscriptionController::class, 'subscribeNow'])->name('subscribe-now');
// Route::get('/subscribe-now', 'SubscriptionController@subscribeNow')->name('subscribe-now');

// Route for starting a free trial
Route::get('/start-free-trial', 'SubscriptionController@startFreeTrial')->name('start-free-trial');

Route::post('/esewa', [EsewaController::class, 'esewaPay'])->name('esewa');
Route::get('/success', [EsewaController::class, 'esewaPaySuccess']);
Route::get('/failure', [EsewaController::class, 'esewaPayFailed']);


use App\Http\Controllers\Auth\YourOtpVerificationController;

