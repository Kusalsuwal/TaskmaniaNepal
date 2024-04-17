<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function sendSMS(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'message' => 'required'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer your_bearer_token', // Replace with your actual bearer token
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://sms.sociair.com/api/sms', [
            'mobile' => $request->mobile,
            'message' => $request->message,
        ]);

        return response()->json($response->json(), $response->status());
    }
}
