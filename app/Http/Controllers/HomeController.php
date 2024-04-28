<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
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
    // Fetch all tasks and group them by status
    $tasks = Task::all()->groupBy('status');

    // Ensure all statuses have a key even if there are no tasks
    $statuses = ['todo', 'doing', 'done'];
    foreach ($statuses as $status) {
        if (!isset($tasks[$status])) {
            $tasks[$status] = collect();  // Assign an empty collection if no tasks exist for a status
        }
    }

    return view('home', compact('tasks'));
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






