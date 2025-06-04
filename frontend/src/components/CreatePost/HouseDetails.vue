<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'

const createPost = useCreatePostStore()
const { category, houseDetails, area, price } = storeToRefs(createPost)
</script>

<template>
    <div v-if="category !== 'shop'" class="rounded-xl bg-white p-6 border border-gray-300 space-y-6">
        <h1 class="text-2xl font-semibold">House Details</h1>

        <!-- Description -->
        <div>
            <label for="description" class="block mb-1 font-medium">Description <span class="text-accent">*</span></label>
            <textarea v-model="houseDetails.description" id="description" required rows="4"
                class="w-full border rounded-lg p-3 outline-none resize-none"></textarea>
        </div>

        <!-- Price -->
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="flex flex-col w-full sm:max-w-xs">
                <label for="price" class="mb-1 font-medium">Price <span v-if="category === 'house'">(per month)</span> <span v-else-if="category === 'home_stay'">(per day)</span> <span class="text-accent">*</span></label>
                <div class="flex items-center gap-2 border rounded-lg px-3 py-2">
                    <span>₹</span>
                    <input v-model="price" id="price" type="number" min="0" required class="w-full outline-none"
                        placeholder="Enter price" />
                </div>
            </div>

            <!-- Area -->
            <div class="flex flex-col w-full sm:max-w-xs">
                <label for="area" class="mb-1 font-medium">Area (sq.m) <span class="text-accent">*</span></label>
                <input v-model="area" id="area" type="number" min="0" required
                    class="w-full border rounded-lg p-2 outline-none" placeholder="e.g., 100" />
            </div>
        </div>

        <!-- Rooms -->
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="flex flex-col w-full sm:max-w-[120px]">
                <label for="bathroom" class="mb-1 font-medium">Bathrooms <span class="text-accent">*</span></label>
                <input v-model="houseDetails.bathroom" id="bathroom" type="number" min="0" step="1" required
                    class="w-full border rounded-lg p-2 outline-none" />
            </div>

            <div class="flex flex-col w-full sm:max-w-[120px]">
                <label for="bedroom" class="mb-1 font-medium">Bedrooms <span class="text-accent">*</span></label>
                <input v-model="houseDetails.bedroom" id="bedroom" type="number" min="0" required
                    class="w-full border rounded-lg p-2 outline-none" />
            </div>
        </div>

        <!-- Radio Groups -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <span class="block mb-1 font-medium">Balcony <span class="text-accent">*</span></span>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.balcony" value="yes" name="balcony" />
                        Yes
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.balcony" value="no" name="balcony" />
                        No
                    </label>
                </div>
            </div>

            <div>
                <span class="block mb-1 font-medium">Parking <span class="text-accent">*</span></span>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.parking" value="yes" name="parking" />
                        Yes
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.parking" value="no" name="parking" />
                        No
                    </label>
                </div>
            </div>

            <div>
                <span class="block mb-1 font-medium">Furnished <span class="text-accent">*</span></span>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.furnished" value="yes" name="furnished" />
                        Yes
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" v-model="houseDetails.furnished" value="no" name="furnished" />
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
