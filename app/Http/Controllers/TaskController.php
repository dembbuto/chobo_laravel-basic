<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        // $tasks = Task::latest()->where('user_id', auth()->id())->get();

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->input('title');
        $request->input('body');

        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $values = request(['title', 'body']);

        $values['user_id'] = auth()->id();

        $task = Task::create($values);
        // $task = Task::create([
        //     'title' => $request->input('title'),
        //     'body' => $request->input('body')
        // ]);

        return redirect('/tasks/'.$task->id);
    }

    public function show(Task $task)
    {
        abort_unless(auth()->user()->owns($task), 403);
        // abort_if(!auth()->user()->owns($task), 403);
        // abort_if(auth()->id() != $task->user_id, 403);
        // if(auth()->id() != $task->user_id) {
        //     abort(403);
        // }

        return view ('tasks.show', [
            'task' => $task
        ]);
    }

    public function edit(Task $task)
    {
        abort_unless(auth()->user()->owns($task), 403);

        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    public function update(Task $task)
    {
        abort_unless(auth()->user()->owns($task), 403);

        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $task->update(request(['title', 'body']));
        // $task->update([
        //     'title' => request('title'),
        //     'body' => request('body')
        // ]);

        return redirect('/tasks/'.$task->id);
    }

    public function destroy(Task $task)
    {
        abort_unless(auth()->user()->owns($task), 403);

        $task->delete();

        return redirect('/tasks');
    }
}
