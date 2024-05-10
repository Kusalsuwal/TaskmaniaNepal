<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\TaskHistory;

class TaskController extends Controller
{
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $task = new Task();             
        $task->name = $request->name;
        $task->board_id = $request->board_id;
        $task->status_id = $request->status;
        $task->save();
        return redirect()->route('home')->with('success', 'Board created successfully.');
    }
    public function fetchTaskHistory($taskId)
    {
        $task = Task::findOrFail($taskId); 
        $history = Task::where('id', $taskId)
        ->with(['history' => function ($query) {
            $query->with('oldStatus', 'newStatus','user'); 
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    
        foreach ($history as $event) {
            foreach ($event->history as $his) {
                $oldStatus = $his->oldStatus;
                $newStatus = $his->newStatus;
                $user_id = $his->user_id;
    
                $his->old_status_name = $oldStatus ? $oldStatus->name : 'Unknown';
                $his->new_status_name = $newStatus ? $newStatus->name : 'Unknown';
                $his->user_id = $user_id; 
            }
        }
    
        return response()->json($history);
    }
    

public function updateTaskStatus(Request $request)
{
    // dd($request->all());
    $taskId = $request->input('task_id');
    $newStatusId = $request->input('status_id');
    $user_id = Auth()->user()->id;
    // dd($user_id);


    $task = Task::find($taskId);
    $oldStatusId = $task->status_id;

    $task->status_id = $newStatusId;
    $task->save();

    TaskHistory::create([
        'task_id' => $taskId,
        'old_status_id' => $oldStatusId,
        'new_status_id' => $newStatusId,
        'user_id' => $user_id,
    ]);

    return response()->json(['success' => true]);
}

    public function updateDescription($taskId, Request $request)
    {
        
        $request->validate([
            'description' => 'required|string',
        ]);
    
        try {
       
            $task = Task::findOrFail($taskId);
            $task->description = $request->input('description');
            $task->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
