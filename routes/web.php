<?php

use App\Http\Controllers\Auth\AuthOtpController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EsewaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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


Route::post('/check-balance', [SmsController::class, 'checkBalance']);
Route::post('/send-sms', [SmsController::class, 'sendSMS']);
Route::get('/payment', [PaymentController::class, ' showForm']);
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('process.payment');
Route::get('/subscribe-now', [App\Http\Controllers\SubscriptionController::class, 'subscribeNow'])->name('subscribe-now');
Route::get('/start-free-trial', [App\Http\Controllers\SubscriptionController::class, 'startFreeTrial'])->name('start-free-trial');
Route::post('/esewa', [EsewaController::class, 'esewaPay'])->name('esewa');
Route::get('/success', [EsewaController::class, 'esewaPaySuccess']);
Route::get('/failure', [EsewaController::class, 'esewaPayFailed']);



Route::get('sendmail', [RegisterController::class, 'index1'])->name('index1');
Route::get('ok', [RegisterController::class, 'emailg'])->name('emailg');

Route::get('/LoginProfile', [HomeController::class, 'LoginProfile'])->name('LoginProfile');
Route::get('update_task', [HomeController::class, 'update_task'])->name('update_task');
Route::get('/index', [TaskController::class, 'index']);
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::patch('/task/{task}', [TaskController::class, 'update'])->name('task.update');
Route::post('/tasks/{taskId}/update-description', [TaskController::class,'updateDescription'])->name('tasks.updateDescription');
Route::post('/tasks/{task}/update', [TaskController::class, 'updateStatus']);
// routes/web.php
// Route for processing "Start Free Trial" form submission
Route::get('/start-free-trial', function () {
    // Capture the current date
    $trialStartDate = now();
    
    // Store the trial start date in the user's session or database
    session(['trial_start_date' => $trialStartDate]);
    
    // Redirect to the home page or wherever appropriate
    return redirect()->route('home');
});

// Route for checking trial status and accessing restricted features
Route::get('/restricted-page', function () {
    // Retrieve the trial start date from session or database
    $trialStartDate = session('trial_start_date');
    
    // Check if the trial period has expired (15 days)
    if ($trialStartDate && now()->diffInDays($trialStartDate) < 15) {
        // User is within the trial period, allow access
        return view('restricted-page');
    } else {
        // Trial period has expired, restrict access
        return redirect()->route('home')->with('error', 'Your trial has expired.');
    }
});



//Forgotpassword Implementing here
// routes/web.php
Route::get('forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.requests');
Route::post('forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.emails');



Route::resource('tasks', TaskController::class);




use App\Http\Controllers\Auth\YourOtpVerificationController;

