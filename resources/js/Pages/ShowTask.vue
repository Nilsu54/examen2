<template>
    <div class="task">
      <h1>{{ task.title }}</h1>
      <p>{{ task.description }}</p>
    </div>
  </template>
  
  <script setup>
const props = defineProps({
    task: {
        type: Array,
        required: true,
    },
});
  </script>
  
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
  