<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Status;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::all();
        return view('boards.index', compact('boards'));
    }

    public function Bstores(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Create a new board instance
        $board = new Board();
        $board->title = $request->title;
        $board->save();

        // Redirect to a relevant page after creating the board
        return redirect()->route('home')->with('success', 'Board created successfully.');
    }
    public function show($id)
    {
       
        $board = Board::findOrFail($id);
        $statuses = Status::where('board_id', $id)->get();
        return view('projectview', ['board' => $board, 'statuses' => $statuses]);
    }
    public function store(Request $request)
    {
        $status = new Status();
        $status->name = $request->name;
        $status->board_id = $request->board_id;
        $status->save();
    
        // Return the newly created status as JSON
        return response()->json($status);
    }
    

    // Implement other CRUD methods as needed
}
