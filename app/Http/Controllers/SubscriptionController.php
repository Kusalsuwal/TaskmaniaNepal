<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function showOptions()
    {
        return view('subscription.options');
    }

    public function subscribe(Request $request)
    {
        $user = $request->user();
        $user->is_subscribed = true;
        $user->save();

        return redirect()->route('home')->with('status', 'Subscription activated!');
    }

    public function startTrial(Request $request)
    {
        $user = $request->user();
        $user->trial_ends_at = Carbon::now()->addDays(15);
        $user->save();

        return redirect()->route('home')->with('status', '15-day trial started!');
    }
    // SubscriptionController.php

    public function subscribeNow()
    {
        $transaction_uuid = Str::uuid()->toString();
    
        // Pass the UUID to your view
        return view('subscribe_now', compact('transaction_uuid'));
    }

public function startFreeTrial()
{
    // Logic to handle free trial
    return redirect()->to('/wherever-free-trial-starts');
}

}
