<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    
    public function index()
{
    $tasks = Task::orderBy('order')->get();
    return view('index', compact('tasks'));
}
public function storee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:todo,doing,done',
        ]);

        Task::create($request->all());

        return redirect()->back()->with('success', 'Task added successfully!');
    }

public function store(Request $request)
{
    Task::create($request->all());
    return redirect('/');
}

public function update(Task $task, Request $request)
{
    $task->update($request->all());
    return redirect('/');
}//
}
