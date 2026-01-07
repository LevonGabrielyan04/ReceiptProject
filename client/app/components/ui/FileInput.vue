<template>
    <label
        for="file-upload"
        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-all"
    >
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg
                class="w-10 h-10 mb-3 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                />
            </svg>
            <p class="mb-2 text-sm text-gray-500">
                <span class="font-semibold">Click to upload</span>
            </p>
            <p class="text-xs text-gray-400">Any file type</p>
        </div>
        <input
            id="file-upload"
            type="file"
            class="hidden"
            @change="props.handleFileChange"
        />
    </label>
</template>

<script setup>
    import { defineProps } from 'vue'

    const props = defineProps({
        handleFileChange: Function
    })
</script>
