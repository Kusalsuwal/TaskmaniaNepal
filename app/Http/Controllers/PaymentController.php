<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payments.form');
    }

    public function processPayment(Request $request)
    {
        $totalAmount = $request->total_amount;
        $transactionUUID = Str::uuid()->toString(); // Generating a UUID for the transaction
        $productCode = $request->product_code;

        // Create the data string in the exact order
        $data = "{$totalAmount},{$transactionUUID},{$productCode}";
        $secretKey = env('ESEWA_SECRET_KEY');

        // Generate HMAC signature
        $signature = hash_hmac('sha256', $data, $secretKey);

        // Normally you would send this $signature along with other data to eSewa's endpoint
        // Here we just log it for demonstration
        Log::info("Generated Signature: " . $signature);

        return view('payments.confirm', [
            'totalAmount' => $totalAmount,
            'transactionUUID' => $transactionUUID,
            'productCode' => $productCode,
            'signature' => $signature
        ]);
    }

    public function verifyPayment(Request $request)
    {
        // Code to verify payment after callback from eSewa
    }
}
