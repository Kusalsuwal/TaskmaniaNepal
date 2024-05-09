<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Status;
use App\Models\TaskHistory;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::all();
        return view('boards.index', compact('boards'));
    }

    public function Bstores(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $board = new Board();
        $board->title = $request->title;
        $board->save();


        return redirect()->route('home')->with('success', 'Board created successfully.');
    }
    public function show($id)
    {

        $board = Board::findOrFail($id);
        $statuses = Status::where('board_id', $id)->get();
        
        $task_histories = TaskHistory::where('old_status_id', $id,)->get();
        return view('projectview', ['board' => $board, 'statuses' => $statuses,'task_histories' =>$task_histories]);
    }
    public function store(Request $request)
    {
        $status = new Status();
        $status->name = $request->name;
        $status->board_id = $request->board_id;
        $status->save();

        return response()->json($status);
    }
    

}
