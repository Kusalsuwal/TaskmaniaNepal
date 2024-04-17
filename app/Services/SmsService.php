<?php

namespace App\Services;
use App\Http\Controllers\Auth\AuthOtpController;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $baseUrl = 'https://sms.sociair.com/api/sms';
    protected $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiM2E3NWM1YWI1MmVjODEyZDI1OTgzOGI3ZjZkYTJiNWM2ZmRiMmQ0ODBmOGQ0MjBhMTU5Y2UwNDliMGMxYzMwMTk5ZjhkZjM2NTRlNDZkZDQiLCJpYXQiOjE2NjMyMzkxMTMuODgwMDQzLCJuYmYiOjE2NjMyMzkxMTMuODgwMDQ2LCJleHAiOjE2OTQ3NzUxMTMuODc1OTI0LCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.XeE2i8ONcx029w81IlatGYZ0PD9FpCXqkEKVDGEaREjj3YQlYyGEdcWNJmOHFDo2lU8ANkZW9z0TkdMgk8X1Jw'; // Place your actual bearer token here

    public function sendSms($mobile, $message)
{
    $response = Http::withHeaders([
        'Authorization' => "Bearer {$this->token}",
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ])->withoutVerifying()
      ->post($this->baseUrl, [
        'mobile' => $mobile,
        'message' => $message,
    ]);

    \Log::info('SMS API Response', ['response' => $response->body()]);

    return $response->successful();
}

}
