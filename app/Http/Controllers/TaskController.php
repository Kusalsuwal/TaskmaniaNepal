<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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
        // dd($request->all());
      
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // dd($request);
        // Create a new task
        $task = new Task();             
        $task->name = $request->name;
        $task->board_id = $request->board_id;
        $task->status_id = $request->status;
        $task->save();
            
    
        // Return the newly created task as JSON response
        return redirect()->route('home')->with('success', 'Board created successfully.');
    }


    public function updateStatus(Request $request, $taskId)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:todo,doing,done',
        ]);
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $validatedData['status']]);
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
    
            // Return success  
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

}
