<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

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
        // Retrieve the project from the database
        $board = Board::findOrFail($id);

        // Pass the project data to the view
        return view('projectview', ['board' => $board]);
    }
    // Implement other CRUD methods as needed
}
