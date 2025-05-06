<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;
use Inertia\Inertia;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = task::all();
      
        return Inertia::render('Tareas', [
            'tasks' => $task
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateTask');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task= $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        task::create($task);
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        return Inertia::render('ShowTask', [
            'task' => $task, // Pasa el evento a la vista
        ]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task)
    {
        return Inertia::render('EditTask', [
            'task' => $task, // Pasa el evento a la vista
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $task->update($validated);
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task)
    {
        $task->delete();
        return redirect()->route('task.index');
    }
}
