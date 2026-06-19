<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskApiController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::all());
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'user_id' => 1,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending',
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task Deleted'
        ]);
    }
}