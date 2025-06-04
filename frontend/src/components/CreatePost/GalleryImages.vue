<script setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useCreatePostStore } from '@/stores/createPost'

const createPost = useCreatePostStore()
const { previews } = storeToRefs(createPost)
const { handleImageUpload, removePreview } = createPost

const isDragging = ref(false)

function handleDrop(event) {
    event.preventDefault()
    isDragging.value = false
    const files = event.dataTransfer.files
    if (files.length === 0) return

    // Filter only JPG/jpeg files
    const jpgFiles = Array.from(files).filter(file =>
        file.type.match('image/jpeg')
    )
    if (jpgFiles.length === 0) {
        alert('Only JPG files are allowed!')
        return
    }

    const fakeEvent = { target: { files: jpgFiles } }
    handleImageUpload(fakeEvent)
}

function handleDragOver(event) {
    event.preventDefault()
    isDragging.value = true
}

function handleDragLeave(event) {
    event.preventDefault()
    isDragging.value = false
}
</script>

<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <h1 class="text-xl font-semibold">Add Gallery Images </h1>

        <div>
            <label class="block mb-1">
                Upload Gallery Images (JPG only) <span class="text-accent">*</span>
            </label>

            <!-- Show drag-drop only when previews is empty -->
            <div v-if="previews.length === 0" @drop="handleDrop" @dragover="handleDragOver" @dragleave="handleDragLeave"
                :class="[
                    'border-2 border-dashed rounded-lg p-4 text-center cursor-pointer transition-colors relative',
                    isDragging ? 'border-accent bg-accent/20' : 'border-gray-300 bg-transparent'
                ]">
                Drag & drop your JPG files here, or click to select.

                <!-- Invisible file input over drop zone for clicking -->
                <input type="file" accept=".jpg, .jpeg" multiple @change="handleImageUpload" required
                    class="absolute inset-0 opacity-0 cursor-pointer" />
            </div>

            <!-- If previews exist, show previews and a button to add more files -->
            <div v-else>
                <div class="grid grid-cols-2 md:grid-cols-3 mt-4 mb-2">
                    <div v-for="(src, index) in previews" :key="index" class="rounded border overflow-hidden relative">
                        <img :src="src" alt="Preview"
                            class="object-cover w-full h-40 hover:scale-[1.1] brightness-[85%] hover:brightness-100 cursor-pointer" />
                        <i @click="removePreview(index)"
                            class="bx bx-x text-2xl text-white absolute top-1 right-1 opacity-50 cursor-pointer hover:opacity-80"></i>
                    </div>
                </div>

                <!-- Label styled as a button to add more files -->
                <!-- <label for="gallery-upload"
                    class="inline-block px-4 py-2 rounded-full bg-accent text-white font-semibold cursor-pointer hover:bg-accent/80">
                    Add More JPG Files
                </label> -->
                <input id="gallery-upload" type="file" accept=".jpg, .jpeg" multiple @change="handleImageUpload"
                    class="hidden" />
            </div>
        </div>
    </div>
</template>
