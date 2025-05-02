<script setup>
import {storeToRefs} from 'pinia'
import { useCreatePostStore } from '@/stores/createPost'
const createPost = useCreatePostStore()
const {previews} = storeToRefs(createPost)
const {handleImageUpload, removePreview} = createPost
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <h1 class="text-xl">Add Gallery Images </h1>
        <div>
            <label class="block mb-1">Upload Gallery Images (JPG only) <span class="text-accent">*</span></label>
            <input type="file" accept=".jpg, .jpeg" multiple @change="handleImageUpload" required
                class="block  w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white cursor-pointer hover:file:bg-accent/80" />
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 mt-4">
            <div v-for="(src, index) in previews" :key="index" class="rounded border overflow-hidden relative">
                <img :src="src" alt="Preview"
                    class="object-cover w-full h-40 hover:scale-[1.1] brightness-[85%] hover:brightness-100 cursor-pointer" />
                <i @click="removePreview(index)"
                    class="bx bx-x text-2xl text-white absolute top-1 right-1 opacity-50 cursor-pointer hover:opacity-80"></i>
            </div>
        </div>
    </div>
</template>