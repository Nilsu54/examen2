<script setup>
// Importaciones de Vue y otras dependencias
import { ref, computed } from 'vue'; // ref y computed son funciones de Vue para manejar variables reactivas y valores calculados
import { Head, Link, router } from '@inertiajs/vue3'; // Head cambia el título de la página, Link se usa para enlaces, router se usa para navegación
import Navbar from '@/Components/NavBar.vue'; // Importa el componente de la barra de navegación

// Definición de una variable reactiva para el índice de la imagen que se está mostrando
const currentIndex = ref(0);

// Función para cambiar la imagen mostrada al hacer clic en los indicadores
const goToImage = (index) => {
    if (props.tasks.length > 0) { // Si hay tareas disponibles
        currentIndex.value = index; // Cambia el índice de la imagen
    }
};

// Función para generar la URL de la imagen a partir de la ruta proporcionada
const getImageUrl = (imagePath) => {
    return `/storage/${imagePath}`; // Devuelve la URL de la imagen
};

// Variable reactiva para el texto de búsqueda
const search = ref('');

// Definición de las propiedades que el componente espera recibir (en este caso, un array de tareas)
const props = defineProps({
    tasks: {
        type: Array,
        required: true, // Es obligatorio recibir el array de tareas
    },
});

// Función para eliminar una tarea utilizando la ruta proporcionada
function deletetask(id) {
    router.delete(route('task.destroy', id)); // Elimina la tarea usando InertiaJS
}

// Computed que filtra las tareas según el texto que el usuario escribe en la barra de búsqueda
const filteredtask = computed(() =>
    props.tasks.filter(task =>
        task.title.toLowerCase().includes(search.value.toLowerCase()) || // Filtra por título
        (task.category && task.category.name &&
            task.category.name.toLowerCase().includes(search.value.toLowerCase())) // Filtra por categoría si existe
    )
);
</script>

<template>
    <!-- Cambia el título de la página -->
    <Head title="task" />
    <div class="max-w-screen min-w-screen bg-gray-100 text-black">
        <!-- Barra de navegación -->
        <Navbar />
        <div class="relative flex mx-auto min-h-screen flex-col items-center justify-center selection:bg-[#252850 ] selection:text-white">
            <!-- Muestra la imagen de la tarea si hay tareas disponibles -->
            <img v-if="props.tasks.length > 0" :src="getImageUrl(props.tasks[currentIndex].image)" :alt="props.tasks[currentIndex].title"
                class="mt-4 w-96 h-auto rounded-lg shadow-lg" alt="imagen de la tarea" />
            
            <!-- Contenedor principal con estilo de diseño responsivo -->
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                
                <!-- Indicadores para cambiar la imagen -->
                <div class="flex justify-center mt-4 space-x-2">
                    <span v-for="(task, index) in props.tasks" :key="task.id" @click="goToImage(index)"
                        class="w-4 h-4 rounded-full cursor-pointer transition-all duration-300" :class="{
                            'bg-black': index === currentIndex,
                            'bg-gray-400': index !== currentIndex
                        }" />
                </div>
                
                <!-- Botón para crear una nueva tarea -->
                <Link :href="route('task.create')" class="inline-flex items-center justify-center mb-4 rounded-md border border-transparent bg-[#252850 ] px-6 py-3 text-lg font-medium text-white shadow-sm bg-[#252850]/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#252850] focus-visible:ring-offset-2">
                    Crear Nueva Tarea
                </Link>
                
                <!-- Campo de búsqueda -->
                <div class="search-container mb-4">
                    <input type="text" v-model="search" placeholder="Buscar..." class="px-4 py-2 border rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-[#252850]" />
                </div>

                <!-- Tabla que muestra las tareas -->
                <h2 class="mt-10 text-2xl font-bold text-[#333]">Tareas</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full mt-4 mb-4 border border-[#ddd] bg-white shadow-md rounded-lg">
                        <thead class="bg-[#252850 ] text-white">
                            <tr>
                                <th class="border border-gray-300 px-6 py-4">Título</th>
                                <th class="border border-gray-300 px-6 py-4">Descripción</th>
                                <th class="border border-gray-300 px-6 py-4">Imagen</th>
                                <th class="border border-gray-300 px-6 py-4">Categoría</th>
                                <th class="border border-gray-300 px-6 py-4">Fecha de Creación</th>
                                <th class="border border-gray-300 px-6 py-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iteración sobre las tareas filtradas -->
                            <tr v-for="task in filteredtask" :key="task.id" class="hover:bg-[#f0f0f0]">
                                <td class="border border-gray-300 px-6 py-4 text-black">{{ task.title }}</td>
                                <td class="border border-gray-300 px-6 py-4 text-black">{{ task.description }}</td>
                                <td class="border border-gray-300 px-6 py-4 text-black">
                                    <!-- Muestra la imagen de la tarea -->
                                    <img class="w-20" :src="`/storage/${task.image}`" :alt="task.title" />
                                </td>
                                <td class="border border-gray-300 px-6 py-4 text-black">{{ task.categoria_id }}</td>
                                <td class="border border-gray-300 px-6 py-4 text-black">{{ task.created_at }}</td>
                                <td class="border border-gray-300 px-6 py-4">
                                    <!-- Enlaces para ver, editar o eliminar la tarea -->
                                    <Link :href="route('task.show', task.id)" class="text-[#252850]-600 hover:underline">Ver</Link>
                                    <Link :href="route('task.edit', task.id)" class="text-blue-600 hover:underline">Editar</Link>
                                    <button @click="deletetask(task.id)" class="text-red-600 hover:underline">Eliminar</button>
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
/* Estilos para el cuerpo de la página */
body {
    background-color: #f5f5f5; /* Fondo gris claro */
}

/* Estilos para la tabla */
table {
    border-collapse: collapse;
    width: 100%; /* Ocupa el 100% del contenedor */
}

th, td {
    text-align: left; /* Alineación de texto a la izquierda */
    padding: 12px; /* Espaciado en celdas */
}

th {
    background-color: #252850; /* Color de fondo para los encabezados */
    color: white; /* Texto blanco en los encabezados */
}

/* Estilo para el hover sobre las filas de la tabla */
tbody tr:hover {
    background-color: #f0f0f0; /* Color de fondo cuando se pasa el ratón sobre una fila */
}

/* Estilos generales para el input y los botones */
input, button {
    font-size: 16px;
}

/* Estilo para los títulos */
h1, h2 {
    color: #333; /* Color oscuro para los títulos */
}

/* Estilo para el campo de búsqueda */
.search-container input {
    border: 2px solid #252850; /* Borde oscuro para el input de búsqueda */
}

/* Estilos para los botones */
button {
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
}

button:hover {
    background-color: #252850; /* Fondo oscuro cuando se pasa el ratón */
    color: white; /* Texto blanco cuando se pasa el ratón */
}
</style>
