<script setup>
  import { Link } from '@inertiajs/vue3'

  </script>
<template>
    <nav class="bg-white shadow p-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-gray-700">Mi Aplicación</h1>
      <div class="space-x-4">
        <Link
          href="/events"
          class="px-4 py-2 bg-[#252850] text-white rounded hover:bg-[#252850]-500 transition"
        >
          Ir a Events
        </Link>
        <Link
          href="/task"
          class="px-4 py-2 bg-[#252850] text-white rounded hover:bg-[#252850]-500 transition"
        >
          Ir a Task
        </Link>
      </div>
    </nav>
  </template>
  
  
  