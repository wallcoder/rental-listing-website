<script setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useCreatePostStore } from '@/stores/createPost'

const createPost = useCreatePostStore()
const { thumbnailPreview } = storeToRefs(createPost)
const { removeThumbnailPreview, handleThumbnailUpload } = createPost

// For drag-over state styling
const isDragging = ref(false)


function handleDrop(event) {
    event.preventDefault()
    isDragging.value = false
    const files = event.dataTransfer.files
    if (files.length === 0) return

    // Only accept jpg/jpeg files
    const file = files[0]
    if (!file.type.match('image/jpeg')) {
        alert('Only JPG files are allowed!')
        return
    }

    // Create a fake "change" event for handleThumbnailUpload to reuse
    const fakeEvent = { target: { files: [file] } }
    handleThumbnailUpload(fakeEvent)
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
        <h1 class="text-xl font-semibold">Add Thumbnail</h1>

        <div>
            <label class="block mb-1">
                Upload Thumbnail (JPG only) <span class="text-accent">*</span>
            </label>

            <!-- Show drag-drop only if no thumbnailPreview -->
            <div v-if="!thumbnailPreview" @drop="handleDrop" @dragover="handleDragOver" @dragleave="handleDragLeave" :class="[
                'border-2 border-dashed rounded-lg p-4 text-center cursor-pointer transition-colors relative',
                isDragging ? 'border-accent bg-accent/20' : 'border-gray-300 bg-transparent'
            ]">
                Drag & drop your JPG file here, or click to select.

                <!-- Invisible file input over the drop zone for clicking -->
                <input type="file" accept=".jpg, .jpeg" @change="handleThumbnailUpload" required
                    class="absolute inset-0 opacity-0 cursor-pointer" />
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 mt-4" v-if="thumbnailPreview">
            <div class="rounded border overflow-hidden relative">
                <img :src="thumbnailPreview" alt="Preview"
                    class="object-cover w-full h-40 hover:scale-[1.1] brightness-[85%] hover:brightness-100 cursor-pointer" />
                <i @click="removeThumbnailPreview()"
                    class="bx bx-x text-2xl text-white absolute top-1 right-1 opacity-50 cursor-pointer hover:opacity-80"></i>
            </div>
        </div>
    </div>
</template>
