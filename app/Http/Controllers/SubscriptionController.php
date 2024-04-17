<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
}
