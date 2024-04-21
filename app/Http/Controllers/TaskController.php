<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
 
    // public function index()
    // {
    //     $tasks = Task::all()->groupBy('status');
    //     dd($tasks);
    //     return view('home', compact('tasks'));
    // }

 
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:todo,doing,done',
        ]);

        // Create a new task
        $task = Task::create([
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
        ]);

        // Return the newly created task as JSON response
        return response()->json(['success' => true, 'task' => $task]);
    }


    public function updateStatus(Request $request, $taskId)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'status' => 'required|string|in:todo,doing,done',
        ]);

        // Find the task by ID
        $task = Task::findOrFail($taskId);

        // Update the task status
        $task->update(['status' => $validatedData['status']]);

        // Return success response
        return response()->json(['success' => true]);
    }
    public function updateDescription($taskId, Request $request)
    {
        // Validate request data if needed
        $request->validate([
            'description' => 'required|string',
        ]);
    
        try {
            // Find the task by ID
            $task = Task::findOrFail($taskId);
            
            // Update the task description
            $task->description = $request->input('description');
            $task->save();
    
            // Return success response
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
