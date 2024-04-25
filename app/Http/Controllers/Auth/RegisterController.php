<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Providers\RouteServiceProvider;
use App\Services\SmsService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $smsService;
    protected $redirectTo = 'otp.verification';

    public function __construct(SmsService $smsService)
    {
        $this->middleware('guest');
        $this->smsService = $smsService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile_no' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_no' => $request->mobile_no
        ]);

        // Generate a random OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        dispatch(new SendEmailJob($user));

        try {
            $success = $this->smsService->sendSms($user->mobile_no, "$otp is your registration OTP for Taskmania Nepal");
            if (!$success) {
                throw new \Exception("Failed to send SMS.");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send OTP: ' . $e->getMessage());
        }
        

        return redirect()->route('otp.verification', ['user_id' => $user->id]);
    }
    public function index1()
    {
        // You may not need to send emails to all users here, as this could be heavy.
        // If you want to send emails to all users, consider queueing this operation separately.
        $users = User::all(); 
        foreach ($users as $user) {
            SendEmailJob::dispatch($user);
        }
    }

    public function     emailg()
    {
        return view('Emailotp');
    }

}