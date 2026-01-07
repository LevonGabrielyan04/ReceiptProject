<template>
    <div class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-50 to-indigo-100">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Upload File
            </h1>

            <div class="space-y-4">
                <FileInput :handleFileChange="handleFileChange" />

                <div v-if="selectedFile" class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Selected file:</span> {{ selectedFile.name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import FileInput from "../ui/FileInput.vue";

const selectedFile = ref(null);
const config = useRuntimeConfig()

const handleFileChange = async (event) => {
    const file = event.target.files[0]
    if (!file) return

    selectedFile.value = file

    const formData = new FormData()
    formData.append('photo', file)

    const { data } = await useFetch('/api/convert', {
        method: 'POST',
        body: formData,
        baseURL: config.public.apiBase,
    });
}
</script>
