<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="input"
    />
</template>


<!-- 🧠 Guía paso a paso para hacer un CRUD con Laravel + Vue (Inertia)
1. 🛠 Crear modelo, migración, controlador y recurso
bash
Copiar
Editar
sail artisan make:model Task -mcr
Esto genera:

app/Models/Task.php → modelo

database/migrations/xxxx_create_tasks_table.php → migración

app/Http/Controllers/TaskController.php → controlador

Registra automáticamente las rutas (-r)

2. 🧱 Editar la migración (database/migrations/...create_tasks_table.php)
Agregamos los campos que necesitemos, por ejemplo:

title (string)

description (text)

image (string nullable)

categoria_id (unsignedBigInteger nullable)

Ejecutamos la migración:

bash
Copiar
Editar
sail artisan migrate
3. 📁 Modelo (app/Models/Task.php)
Podés definir qué campos son asignables:

php
Copiar
Editar
protected $fillable = ['title', 'description', 'image', 'categoria_id'];
Si usás relaciones, por ejemplo con Categoria, lo agregás:

php
Copiar
Editar
public function categoria() {
    return $this->belongsTo(Categoria::class);
}
4. 🌐 Rutas (routes/web.php)
Agregamos el recurso:

php
Copiar
Editar
Route::resource('task', TaskController::class);
5. 📋 Controlador (app/Http/Controllers/TaskController.php)
Cada método tiene su función:

index()
php
Copiar
Editar
return Inertia::render('Task/Index', [
    'tasks' => Task::with('categoria')->latest()->get()
]);
create()
php
Copiar
Editar
return Inertia::render('Task/Create', [
    'categories' => Categoria::all()
]);
store()
php
Copiar
Editar
$task = Task::create($request->all());
return redirect()->route('task.index');
show($id)
php
Copiar
Editar
$task = Task::findOrFail($id);
return Inertia::render('Task/Show', ['task' => $task]);
edit($id)
php
Copiar
Editar
$task = Task::findOrFail($id);
return Inertia::render('Task/Edit', [
    'task' => $task,
    'categories' => Categoria::all()
]);
update(Request $request, Task $task)
php
Copiar
Editar
$task->update($request->all());
return redirect()->route('task.index');
destroy($id)
php
Copiar
Editar
Task::destroy($id);
return redirect()->route('task.index');
6. 🧩 Vista Vue: Task/Index.vue
Recibe las tareas con defineProps

Las muestra con v-for

Botones: Ver, Editar, Eliminar

js
Copiar
Editar
defineProps({ tasks: Array });
Usás <Link> de Inertia para navegar o router.delete() para eliminar.

7. ✏️ Vista Vue: Task/Create.vue y Task/Edit.vue
Usás useForm() para el formulario

Inputs enlazados con v-model

Botón con @submit.prevent="form.post(...)" o .put()

Si editás:

js
Copiar
Editar
const form = useForm({
    title: props.task.title,
    ...
});
8. 📦 Subida de imágenes
En store y update, usás $request->file('image')

Guardás con store('public') y guardás la ruta

En Vue, usás <input type="file" @change="handleFile">

9. 🧹 Extras
Agregar búsqueda, filtrado, paginación, etc.

Usar Tailwind para estilos rápidos

Mostrar alertas o redirecciones con onSuccess

📝 Resumen de pasos clave:
make:model Task -mcr

Editar migración → migrate

Modelo con $fillable

Rutas Route::resource(...)

Controlador: index, create, store, show, edit, update, destroy

Crear vistas Index.vue, Create.vue, Edit.vue, Show.vue

Formulario con useForm(), métodos post o put

Mostrar imágenes, inputs con v-model

Eliminar con router.delete -->