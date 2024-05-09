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
        $history = $task->with(['history' => function ($query) {
            $query->with('oldStatus', 'newStatus'); 
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    
        foreach ($history as $event) {
            foreach ($event->history as $his) {
                $newStatus = $his->newStatus;
                $oldStatus = $his->oldStatus;
                $his->new_status_name = $newStatus ? $newStatus->name : 'Unknown';
                $his->old_status_name = $oldStatus ? $oldStatus->name : 'Unknown';
               
            }
        }
    
        return response()->json($history);
    }

public function updateTaskStatus(Request $request)
{
    $taskId = $request->input('task_id');
    $newStatusId = $request->input('status_id');

    $task = Task::find($taskId);
    $oldStatusId = $task->status_id;

    $task->status_id = $newStatusId;
    $task->save();

    TaskHistory::create([
        'task_id' => $taskId,
        'old_status_id' => $oldStatusId,
        'new_status_id' => $newStatusId,
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
