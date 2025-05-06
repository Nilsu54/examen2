<template>

    <Head title="editar task" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Tarea</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="title" class="block mb-1">title:</label>
                    <input type="text" id="title" v-model="form.title" class="w-full border p-2 rounded" required />
                </div>
                <div class="mb-3">
                    <label for="description" class="block mb-1">description:</label>
                    <input type="text" id="description" v-model="form.description" class="w-full border p-2 rounded" required />
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('task.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    task: Object,
});

const form = useForm({
    title: '',
    description: '',
    _method: 'put',
});

onMounted(() => {
    if (props.task) {
        form.title = props.task.title;
        form.description = props.task.description;

    }
});

function submit() {
    form.post(route('task.update', props.task.id));
}
</script>