<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'

const createPost = useCreatePostStore()


const { category, type } = storeToRefs(createPost)


</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <h2 class="text-xl font-semibold">Property Information</h2>
        <div class="flex flex-col">
            <h2 class="mb-1">Category<span class="text-accent">*</span></h2>
            <div class="flex gap-1">
                <div class="flex flex-col">
                    <label for="house" :class="category === 'house' ? 'bg-accent text-white border-accent ' : 'bg-gray-100'"
                        class="cursor-pointer p-1 hover:bg-accent hover:text-white  rounded-2xl px-4  "
                        required>House</label>

                    <input v-model="category" type="radio" hidden name="category" value="house" id="house">
                </div>
                <div class="flex flex-col">
                    <label for="shop" :class="category === 'shop' ? 'bg-accent text-white border-accent ' : 'bg-gray-100'"
                        class="cursor-pointer p-1 hover:bg-accent hover:text-white rounded-2xl px-4 ">Shop</label>
                    <input v-model="category" type="radio" hidden name="category" value="shop" id="shop" required>
                </div>
                 <div class="flex flex-col">
                    <label for="home_stay" :class="category === 'home_stay' ? 'bg-accent text-white border-accent ' : 'bg-gray-100'"
                        class="cursor-pointer p-1 hover:bg-accent hover:text-white rounded-2xl px-4 ">Home Stay</label>
                    <input v-model="category" type="radio" hidden name="category" value="home_stay" id="home_stay" required>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <h2 class="mb-1">Type<span class="text-accent">*</span></h2>
            <div class="flex gap-1">
                <div class="flex flex-col">
                    <label for="concrete" :class="type === 'concrete' ? 'bg-accent text-white' : 'bg-gray-100'"
                        class="cursor-pointer p-1 hover:bg-accent hover:text-white  rounded-2xl px-4  "
                        required>Concrete</label>

                    <input v-model="type" type="radio" hidden name="type" value="concrete" id="concrete">
                </div>
                <div class="flex flex-col">
                    <label for="assamType" :class="type === 'assam-type' ? 'bg-accent text-white' : 'bg-gray-100'"
                        class="cursor-pointer p-1 hover:bg-accent hover:text-white rounded-2xl px-4 ">Assam-Type</label>
                    <input v-model="type" type="radio" hidden name="type" value="assam-type" id="assamType" required>
                </div>
            </div>
        </div>
    </div>
</template>