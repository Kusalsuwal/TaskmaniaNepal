<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RemoteMerge\Esewa\Client as EsewaClient;
use RemoteMerge\Esewa\Config as EsewaConfig;

class EsewaController extends Controller
{
    public function esewaPay(Request $request)
    {
        $pid = uniqid();
        $amount = $request->amount;

        Order::insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'product_id' => $pid,
            'amount' => $amount,
            'esewa_status' => 'unverified',
            'created_at' => Carbon::now(),
        ]);

        $successUrl = url('/success');
        $failureUrl = url('/failure');

        $config = new EsewaConfig($successUrl, $failureUrl);
        $esewa = new EsewaClient($config);

        // Assuming the process method is correct
        $esewa->process($pid, $amount, 0, 0, 0);
    }
    
    public function esewaPaySuccess()
    {
        //do when pay success.
        $pid = $_GET['oid'];
        $refId = $_GET['refId'];
        $amount = $_GET['amt'];

        $order = Order::where('product_id', $pid)->first();
        //dd($order);
        $update_status = Order::find($order->id)->update([
            'esewa_status' => 'verified',
            'updated_at' => Carbon::now(),
        ]);
        if ($update_status) {
            //send mail,....
            //
            $msg = 'Success';
            $msg1 = 'Payment success. Thank you for making purchase with us.';
            return view('thankyou', compact('msg', 'msg1'));
        }
    }

    public function esewaPayFailed()
    {
        //do when payment fails.
        $pid = $_GET['pid'];
        $order = Order::where('product_id', $pid)->first();
        //dd($order);
        $update_status = Order::find($order->id)->update([
            'esewa_status' => 'failed',
            'updated_at' => Carbon::now(),
        ]);
        if ($update_status) {
            //send mail,....
            //
            $msg = 'Failed';
            $msg1 = 'Payment is failed. Contact admin for support.';
            return view('thankyou', compact('msg', 'msg1'));
        }
    }

    // Rest of the controller methods
}
