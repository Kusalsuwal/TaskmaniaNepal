<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserOtp;
use Carbon\Carbon;

class AuthOtpController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function login()
    {
        return view('auth.otpLogin');
    }

    public function verify(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        return view('auth.verify',compact('user'));   

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generate(Request $request)
    {
        /* Validate Data */
        $request->validate([
            'mobile_no' => 'required|exists:users,mobile_no'
        ]);
  
        /* Generate An OTP */
        $userOtp = $this->generateOtp($request->mobile_no);
        $userOtp->sendSMS($request->mobile_no);
  
        return redirect()->route('otp.verification', ['user_id' => $userOtp->user_id])
                         ->with('success',  "OTP has been sent on Your Mobile Number."); 
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateOtp($mobile_no)
    {
        $user = User::where('mobile_no', $mobile_no)->first();
  
        /* User Does not Have Any Existing OTP */
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();
  
        $now = now();
  
        if($userOtp && $now->isBefore($userOtp->expire_at)){
            return $userOtp;
        }
  
        /* Create a New OTP */
        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(10)
        ]);
    }
  

    public function loginWithOtp(Request $request)
    {
        /* Validation */
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);  
  
        /* Validation Logic */
        $userOtp   = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
  
        $now = now();
        if (!$userOtp) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }else if($userOtp && $now->isAfter($userOtp->expire_at)){
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
        }
    
        $user = User::whereId($request->user_id)->first();
  
        if($user){
              
            $userOtp->update([
                'expire_at' => now()
            ]);
  
            Auth::login($user);
  
            return redirect('/home');
        }
  
        return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
    }

public function verifyOtp(Request $request, $user_id)
{
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $user = User::findOrFail($user_id);

    if ((int) $user->otp !== (int) $request->otp) {
        return redirect()->back()->withErrors(['otp' => 'The OTP entered is incorrect.']);
    }

    if (Carbon::parse($user->otp_expires_at)->isPast()) {
        return redirect()->back()->withErrors(['otp' => 'The OTP has expired.']);
    }

    
    $user->otp = null; 
    $user->otp_expires_at = null;
    $user->save();

    // Login the user
    auth()->login($user);

    return redirect()->route('subscriptionpage.index')->with('success', 'You have been successfully verified.');
}
public function subscriptionpage()
{
    return view('auth.subscription');
}
public function verification($user_id)
{
    $user = User::findOrFail($user_id);  

    return view('auth.verify', compact('user'));  
}

}