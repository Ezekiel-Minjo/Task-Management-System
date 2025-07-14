<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->get();
        return response()->json($tasks);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => $request->user_id,
            'status' => 'pending'
        ]);

        return response()->json($task->load('user'), 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'deadline' => 'sometimes|required|date',
            'user_id' => 'sometimes|required|exists:users,id',
            'status' => 'sometimes|in:pending,in_progress,completed'
        ]);

        $task->update($request->only(['title', 'description', 'deadline', 'user_id', 'status']));

        return response()->json($task->load('user'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
