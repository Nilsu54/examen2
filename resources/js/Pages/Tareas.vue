<script setup>
// Importaciones de Vue y otras dependencias
import { ref, computed } from 'vue';  // ref: para declarar variables reactivas, computed: para valores derivados
import { Head, Link, router } from '@inertiajs/vue3';  // Head: para el título de la página, Link: para navegación, router: para rutas
import Navbar from '@/Components/NavBar.vue';

// Variables reactivas que controlan el índice de la imagen actual y el autoplay
const currentIndex = ref(0);  // Índice actual de la imagen mostrada


// Función para detener el autoplay (no se usa en el código proporcionado)


// Función que avanza a la siguiente imagen (cambia el índice)


// Función que cambia a una imagen específica al hacer clic en los indicadores
const goToImage = (index) => {
    if (props.tasks.length > 0) {
        currentIndex.value = index;
    }
};

// Función que obtiene la URL completa de la imagen almacenada
const getImageUrl = (imagePath) => {
    return `/storage/${imagePath}`;
};

// Variable reactiva para almacenar el valor de búsqueda
const search = ref('');

// Definición de las propiedades (propiedades pasadas al componente)
const props = defineProps({
    tasks: {
        type: Array,
        required: true,  // Requiere que la propiedad 'tasks' esté presente
    },
});

// Función para eliminar una tarea usando el router de Inertia
function deletetask(id) {
    router.delete(route('task.destroy', id));  // Hace una petición DELETE a la ruta 'task.destroy'
}

// Computed property para filtrar las tareas según el término de búsqueda
const filteredtask = computed(() =>
    props.tasks.filter(task =>
        task.title.toLowerCase().includes(search.value.toLowerCase()) ||  // Filtra por título
        (task.category && task.category.name &&
            task.category.name.toLowerCase().includes(search.value.toLowerCase()))  // Filtra por nombre de categoría (si existe)
    )
);
</script>


<template>

    <Head title="task" />
    <div class="max-w-screen min-w-screen bg-gray-50 text-black/50 ">
<Navbar />
        <div
            class="relative flex mx-auto min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-black">
            <img v-if="props.tasks.length > 0" :src="getImageUrl(props.tasks[currentIndex].image)"
                :alt="props.tasks[currentIndex].title" class="mt-4 w-96 h-auto rounded-lg shadow-lg" />
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <div class="flex justify-center mt-4 space-x-2">

                    <div class="mt-4 flex justify-center">


                    </div>
                    <span v-for="(task, index) in props.tasks" :key="task.id" @click="goToImage(index)"
                        class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300" :class="{
                            'bg-gray-800': index === currentIndex,
                            'bg-gray-400': index !== currentIndex
                        }" />
                </div>
                <!-- Botón para ir a crear un nuevo evento -->
                <Link :href="route('task.create')"
                    class="inline-flex items-center justify-center mb-4 rounded-md border border-transparent bg-[#FF2D20] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#FF2D20]/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] focus-visible:ring-offset-2">
                Crear Nueva Tarea
                </Link>
                <div class="search-container">
                    <input type="text" v-model="search" placeholder="Buscar..." class="px-4 py-2 border rounded text-black" />
                </div>

                <!-- Tabla para mostrar eventos -->
                <h2 class="mt-10 text-xl font-bold text-black">Tareas</h2>
                <div class="overflow-x-auto">
                <table class="min-w-full mt-4 mb-4 border border-gray-300 bg-white shadow-md rounded-lg overflow-x-auto">
                    <thead class="bg-[#FF2D20] text-white">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Título</th>
                            <th class="border border-gray-300 px-4 py-2">Descripción</th>
                            <th class="border border-gray-300 px-4 py-2">imagen</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha de Creación</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in filteredtask" :key="task.id" class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ task.title }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ task.description }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-black"> <img class="w-20"
                                    :src="`/storage/${task.image}`" :alt="task.name"></td>
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ task.created_at }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <Link :href="route('task.show', task.id)" class="text-green-500 hover:underline">
                                Ver
                                </Link>
                                <Link :href="route('task.edit', task.id)" class="text-blue-500 hover:underline">
                                Editar
                                </Link>
                                <button @click="deletetask(task.id)"
                                    class="text-red-500 hover:underline">Eliminar</button>

                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
body {
    background-color: #f5f5f5;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    text-align: left;
    padding: 12px;
}

th {
    background-color: #FF2D20;
    /* Color de fondo para el encabezado */
    color: white;
    /* Color del texto en el encabezado */
}

tbody tr:hover {
    background-color: #f5f5f5;
    /* Color de fondo al pasar el mouse */
}
</style>