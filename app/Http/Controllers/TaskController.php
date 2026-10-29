<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // ini gunanya buat kalo misalkan usernya 
    {
        return view('tasks.index', ['tasks' => Task::where('user_id', auth()->id())->get()]);
    }

    public function store(Request $request)
    {
        Task::create([
            'Title'=>$request->Title,
            'Status'=>0,
            'user_id'=> auth()->id()
        ]);
        return redirect()->route('tasks.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function toggle(Task $task)
    {
        $task->update(['Status'=>!$task->Status]);
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
    abort_unless($task->user_id == auth()->id(), 403);
    $task->delete();
    return redirect()->route('tasks.index');
    }
}
