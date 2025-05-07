<script setup>
import { ref } from 'vue'
import Navbar from '@/Components/NavBar.vue';


// Índice de la imagen actual del carrusel
const currentIndex = ref(0)

// Lista de imágenes estáticas (rutas locales)
const images = [
  { src: '/storage/task/2opYrKsSqnhhPeRaFPTZXhKn7Icl8bDbMDA8r8H9.png' },
  { src: '/storage/task/5cJXDG8Nm7arRRKxPwA3u96aQxY1VvkMFMjfP4qn.jpg' }
]

// Cambia a la imagen según el índice elegido
const goToImage = (index) => {
  currentIndex.value = index
}

// Props recibidas: una tarea con título y descripción
const props = defineProps({
  task: {
    type: Array,
    required: true
  }
})
</script>

<template>
  <Navbar />

  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <!-- Imagen del carrusel -->
    <img
      :src="images[currentIndex].src"
      :alt="'Imagen ' + (currentIndex + 1)"
      class="w-96 h-auto rounded-lg shadow-lg"
    />

    <!-- Puntos de navegación del carrusel -->
    <div class="flex space-x-2 mt-4">
      <span
        v-for="(img, index) in images"
        :key="index"
        @click="goToImage(index)"
        class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
        :class="{
          'bg-gray-800': index === currentIndex,
          'bg-gray-400': index !== currentIndex
        }"
      />
    </div>

  <!-- Datos de la tarea -->
  <div class="task">
    <h1>{{ task.title }}</h1>
    <p>{{ task.description }}</p>
  </div>
</div>

</template>

<style scoped>
.task {
  padding: 1rem;
  max-width: 600px;
  margin: auto;
  font-family: sans-serif;
}
h1 {
  color: #333;
}
</style>
