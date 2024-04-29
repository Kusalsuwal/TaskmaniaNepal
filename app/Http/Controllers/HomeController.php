<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $boards = Board::all(); 
        return view('home', ['boards' => $boards]);
    }


    public function otp()
    {
        // dd('asdasdasdasdasd');
        return view('Account.otpverification');
    }

    public function subscription()
    {
        return view('auth.subscription');   
    }
    public function LoginProfile()
    {
        return view('Account.LoginProfile');
    }

}






