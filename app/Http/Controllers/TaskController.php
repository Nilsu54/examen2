<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
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
        $task = task::with(relations: 'categoria')->get();

        return Inertia::render('Tareas', [
            'tasks' => $task
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categoria::all();

        return Inertia::render('CreateTask',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'categoria_id' => 'required'

        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('task', 'public');
            $data['image'] = $imagePath; // Aquí guardas el hashname
        }
    
        Task::create($data); // Asegúrate de tener el modelo importado
    
        return redirect()->route('task.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        return Inertia::render('ShowTask',[
            'task' => $task->load('categoria'),
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
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'categoria_id' => 'required'
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('task', 'public');
            $data['image'] = $imagePath; // Aquí guardas el hashname
        }
    
        $task->update($data); // Actualiza la tarea con los nuevos datos
    
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
