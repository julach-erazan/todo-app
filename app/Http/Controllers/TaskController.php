<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TaskController extends BaseController
{
    // Get all tasks
    public function view(Request $request)
    {
        $userId = $request->input('user_id');

        // Validate that user_id exists
        if (!$userId) {
            return response()->json([
                'error' => 'User ID is required'
            ], 400);
        }

        // Fetch tasks filtered by user_id
        $tasks = Task::where('user_id', $userId)->get();

        return response()->json(['tasks' => $tasks]);
    }

    // Create a new task
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'text' => $validatedData['text'],
            'user_id' => $validatedData['user_id'],
        ]);

        return response()->json(['message' => 'Task created successfully!', 'task' => $task], 201);
    }

    // Update a task
    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'text' => $validated['text'],
        ]);

        return response()->json(['message' => 'Task updated successfully']);
    }

    // // Delete a task
    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!'], 200);
    }
}
