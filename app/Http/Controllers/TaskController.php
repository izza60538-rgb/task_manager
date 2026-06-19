<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Events\TaskCreated;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use App\Notifications\TaskCreatedNotification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Cache::remember(
            'tasks_' . auth()->id(),
            60,
            function () {
                return Task::where('user_id', auth()->id())
                ->latest()
                ->paginate(5);
            }
        );

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')
            ->store('tasks', 'public');
        }

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending',
            'attachment' => $filePath
        ]);
        event(new TaskCreated($task));
        Cache::forget('tasks_' . auth()->id());
        return redirect()->route('tasks.index')
        ->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
        ->with('success', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')
        ->with('success', 'Task Deleted Successfully');
    }

        /*
    |--------------------------------------------------------------------------
    | Soft Delete Methods
    |--------------------------------------------------------------------------
    */

    public function trash()
    {
        $tasks = Task::onlyTrashed()->get();

        return view('tasks.trash', compact('tasks'));
    }

    public function restore($id)
    {
        Task::withTrashed()
        ->findOrFail($id)
        ->restore();

        return redirect()
        ->route('tasks.trash')
        ->with('success', 'Task Restored Successfully');
    }

    public function forceDelete($id)
    {
        Task::withTrashed()
        ->findOrFail($id)
        ->forceDelete();

        return redirect()
        ->route('tasks.trash')
        ->with('success', 'Task Permanently Deleted');
    }
}