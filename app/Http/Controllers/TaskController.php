<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', auth()->id())->get();
        return response()->json(['todos' => $todos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
        ]);

        return response()->json(['todo' => $todo], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $todo->update(['text' => $request->text]);

        return response()->json(['message' => 'Todo updated successfully']);
    }

    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }
}
