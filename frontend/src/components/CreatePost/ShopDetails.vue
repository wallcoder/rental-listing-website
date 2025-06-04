<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

const floors = ref([
    'Ground Floor', 'First Floor', 'Second Floor', 'Third Floor',
    'Fourth Floor', 'Fifth Floor', 'Sixth Floor',
    'Seventh Floor', 'Eighth Floor', 'Ninth Floor'
])

const createPost = useCreatePostStore()
const { category, shopDetails, area, price } = storeToRefs(createPost)
</script>

<template>
    <div v-if="category == 'shop'" class="rounded-xl bg-white p-6 border border-gray-300 shadow-sm flex flex-col gap-6">
        <h1 class="text-2xl font-semibold text-gray-800">Shop Details</h1>

        <!-- Description -->
        <div class="flex flex-col gap-2">
            <label for="description" class="font-medium text-gray-700">Description <span class="text-accent">*</span></label>
            <textarea id="description" v-model="shopDetails.description" rows="4"
                class="border rounded-lg p-3 resize-none w-full outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter shop description"></textarea>
        </div>

        <!-- Price -->
        <div class="flex flex-col gap-2 max-w-xs">
            <label for="price" class="font-medium text-gray-700">Price (per month)<span class="text-accent">*</span></label>
            <div
                class="flex items-center border rounded-lg px-3 py-2 bg-white focus-within:ring-2 focus-within:ring-blue-500">
                <span class="text-gray-600">₹</span>
                <input id="price" type="number" v-model="price" min="0" required class="w-full ml-2 outline-none"
                    placeholder="0" />
            </div>
        </div>

        <!-- Area & Floor -->
        <div class="flex flex-wrap gap-6">
            <div class="flex flex-col gap-2 w-32">
                <label for="area" class="font-medium text-gray-700">Area (sq.m) <span class="text-accent">*</span></label>
                <input id="area" type="number" v-model="area" min="0" required
                    class="border rounded-lg p-2 outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex flex-col gap-2 w-48">
                <label for="floor" class="font-medium text-gray-700">Floor <span class="text-accent">*</span></label>
                <select id="floor" v-model="shopDetails.floor"
                    class="border rounded-lg p-2 outline-none focus:ring-2 focus:ring-blue-500">
                    <option v-for="f in floors" :key="f" :value="f">{{ f }}</option>
                </select>
            </div>
        </div>

        <!-- Radio Groups -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Electricity -->
            <div class="flex flex-col gap-2">
                <span class="font-medium text-gray-700">Electricity <span class="text-accent">*</span></span>
                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="yes" v-model="shopDetails.electricity" />
                        <span>Yes</span>
                    </label>
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="no" v-model="shopDetails.electricity" />
                        <span>No</span>
                    </label>
                </div>
            </div>

            <!-- Water Supply -->
            <div class="flex flex-col gap-2">
                <span class="font-medium text-gray-700">Water Supply <span class="text-accent">*</span></span>
                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="yes" v-model="shopDetails.water" />
                        <span>Yes</span>
                    </label>
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="no" v-model="shopDetails.water" />
                        <span>No</span>
                    </label>
                </div>
            </div>

            <!-- Attached Bathroom -->
            <div class="flex flex-col gap-2">
                <span class="font-medium text-gray-700">Attached Bathroom <span class="text-accent">*</span></span>
                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="yes" v-model="shopDetails.bathroom" />
                        <span>Yes</span>
                    </label>
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" value="no" v-model="shopDetails.bathroom" />
                        <span>No</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
