<?php

use App\Http\Controllers\Auth\AuthOtpController;
use App\Http\Controllers\EsewaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SmsController;
use App\Http\Controllers\TaskController;
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
// Route::get('/check-balance', 'SMSController@checkBalance');





// Route::post('/send-sms', [SmsController::class, 'sendSMS']);
Route::get('/payment', [PaymentController::class, ' showForm']);
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('process.payment');


Route::get('/subscribe-now', [App\Http\Controllers\SubscriptionController::class, 'subscribeNow'])->name('subscribe-now');
Route::get('/start-free-trial', [App\Http\Controllers\SubscriptionController::class, 'startFreeTrial'])->name('start-free-trial');


Route::post('/esewa', [EsewaController::class, 'esewaPay'])->name('esewa');
Route::get('/success', [EsewaController::class, 'esewaPaySuccess']);
Route::get('/failure', [EsewaController::class, 'esewaPayFailed']);


Route::get('update_task', [HomeController::class, 'update_task'])->name('update_task');

Route::get('/index', [TaskController::class, 'index']);
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::patch('/task/{task}', [TaskController::class, 'update'])->name('task.update');

Route::post('/tasks/{taskId}/update-description', [TaskController::class,'updateDescription'])->name('tasks.updateDescription');



Route::post('/tasks/{task}/update', [TaskController::class, 'updateStatus']);
// routes/web.php






Route::resource('tasks', TaskController::class);




use App\Http\Controllers\Auth\YourOtpVerificationController;

