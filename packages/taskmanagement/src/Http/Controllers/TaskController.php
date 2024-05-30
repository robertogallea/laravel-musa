<?php

namespace MusaFormazione\TaskManager\Http\Controllers;

use Illuminate\Http\Request;
use MusaFormazione\TaskManager\Models\Task;

class TaskController
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks::index', compact('tasks'));
    }

    public function show($task)
    {
        $task = Task::find($task);

        return view('tasks::show', compact('task'));
    }

    public function create()
    {
        $task = new Task();
        return view('tasks::edit', compact('task'));
    }

    public function edit($task)
    {
        $task = Task::find($task);
        return view('tasks::edit', compact('task'));
    }

    public function store(Request $request)
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect(route('tasks.index'));
    }

    public function update(Request $request, $task)
    {
        $task = Task::find($task);

        $task->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect(route('tasks.index'));
    }

    public function destroy($task)
    {

    }
}
