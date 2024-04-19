<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
 
    public function index()
    {
        $tasks = Task::all()->groupBy('status');
        return view('home', compact('tasks'));
    }

 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:todo,doing,done',
        ]);
    
        $task = Task::create($validated);
    
        if ($task) {
            return response()->json([
                'success' => true,
                'task' => $task
            ]);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
    


    public function updateStatus(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:todo,doing,done',
        ]);
        $task->update($validatedData);
        return response()->json(['success' => true, 'task' => $task]);
    }
}
