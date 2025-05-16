<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public static function index(Request $request)
    {
        $authUser = Auth::user();
        $users = User::all();
        $tasksQuery = Task::query();

        if ($authUser->role != 'admin') {
            $tasksQuery->whereHas('user', function ($query) {
                $query->where('users.id', '=', Auth::id());
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $tasksQuery->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('user')) {
            $userId = $request->input('user');
            $tasksQuery->whereHas('user', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        }

        if ($request->filled('status')) {
            $tasksQuery->where('status', $request->input('status'));
        }

        $tasks = $tasksQuery->get();
        return view('tasks.my_tasks', compact('tasks', 'users'));
    }

    public static function create() {}

    public static function edit() {}

    public static function show(int $id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public static function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);

        $selectedUsers = $data['users'] ?? [];

        if (!in_array(Auth::id(), $selectedUsers)) {
            $selectedUsers[] = Auth::id();
        }

        $task->user()->attach($selectedUsers);
        return back()->with('success', 'Task created successfully');
    }

    public static function update(TaskStoreRequest $request, int $id)
    {
        $data = $request->validated();

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);


        $selectedUsers[] = $data['users'] ?? [];
        if (!in_array(Auth::id(), $data['users'])) {
            $selectedUsers[] = Auth::id();
        }

        $task->user()->sync($selectedUsers);
        return back()->with('success', 'Task updated successfully');
    }

    public static function destroy(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return back()->with('success', 'Task deleted successfully');
    }
}
