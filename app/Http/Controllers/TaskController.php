<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\TaskHistory;

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


    // public function updateStatus(Request $request, $taskId)
    // {
    //     $validatedData = $request->validate([
    //         'status' => 'required|string|in:todo,doing,done',
    //     ]);
    //     $task = Task::findOrFail($taskId);
    //     $task->update(['status' => $validatedData['status']]);
    //     return response()->json(['success' => true]);
    // }
    // public function updateDescription($taskId, Request $request)
    // {
    //     // Validate request data if needed
    //     $request->validate([
    //         'description' => 'required|string',
    //     ]);
    
    //     try {
    //         // Find the task by ID
    //         $task = Task::findOrFail($taskId);
            
    //         // Update the task description
    //         $task->description = $request->input('description');
    //         $task->save();
    
    //         // Return success  
    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         // Return error response if an exception occurs
    //         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //     }
    // }

// Controller method to update the status of a task
public function updateTaskStatus(Request $request)
{
    $taskId = $request->input('task_id');
    $newStatusId = $request->input('status_id');

    // Retrieve the current status ID of the task
    $task = Task::find($taskId);
    $oldStatusId = $task->status_id;

    // Update the status of the task
    $task->status_id = $newStatusId;
    $task->save();

    // Insert a new record into the task_histories table
    TaskHistory::create([
        'task_id' => $taskId,
        'old_status_id' => $oldStatusId,
        'new_status_id' => $newStatusId,
    ]);

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
