<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TaskController extends BaseController
{
    // Create a new task
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string|max:255',
            'user_id' => 'required|exists:user,id', // Ensure the user_id exists in the users table
        ]);

        $task = Task::create([
            'text' => $validatedData['text'],
            'user_id' => $validatedData['user_id'],
        ]);

        return response()->json(['message' => 'Task created successfully!', 'task' => $task], 201);
    }

    // Get all tasks
    public function index()
    {
        $tasks = Task::with('user')->get(); // Include user details
        return response()->json($tasks, 200);
    }

    // Get a task by ID
    public function show($id)
    {
        $task = Task::with('user')->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    // Update a task
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'text' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|exists:user,id',
        ]);

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($validatedData);

        return response()->json(['message' => 'Task updated successfully!', 'task' => $task], 200);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!'], 200);
    }
}
