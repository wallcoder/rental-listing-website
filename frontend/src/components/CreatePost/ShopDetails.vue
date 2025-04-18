<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'
const createPost = useCreatePostStore()
const { category } = storeToRefs(createPost)
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300" v-if="category == 'shop'">
        <h1 class="text-xl">Shop Details</h1>
        <div>
            <div class="flex gap-7  items-center">
                <div class="flex flex-col w-[60px]">
                    <label for="bathroom">Area(sq.m)</label>
                    <input type="number" name="Area" id="Area" class="border p-2 rounded-lg w-full outline-none" min="0"
                        required>

                </div>
                <div class="flex flex-col">
                    <label for="floor">Floor</label>
                    <select name="floor" id="floor" class="p-2">
                        <option value="ground-floor">Ground Floor</option>
                        <option value="ground-floor">First Floor</option>
                        <option value="ground-floor">Second Floor</option>
                        <option value="ground-floor">Third Floor</option>
                        <option value="ground-floor">Forth Floor</option>
                        <option value="ground-floor">Fifth Floor</option>
                        <option value="ground-floor">Sixth Floor</option>
                        <option value="ground-floor">Seventh Floor</option>
                    </select>

                </div>

            </div>
            <div class="flex gap-10 items-center">
                <div class="flex flex-col">
                    <span>Electricity</span>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="balcony" id="balconyYes" value="yes">
                        <label for="balconyYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="balcony" id="balconyNo" value="no">
                        <label for="balconyNo">No</label>
                    </div>
                </div>

                <div class="flex flex-col">
                    <span>Water Supply</span>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="parking" id="parkingYes" value="yes">
                        <label for="parkingYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="parking" id="parkingNo" value="no">
                        <label for="parkingNo">No</label>
                    </div>

                </div>

                <div class="flex flex-col">
                    <span>Attached Bathroom</span>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="furnished" id="furnishedYes" value="yes">
                        <label for="furnishedYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="radio" name="furnished" id="furnishedNo" value="no">
                        <label for="furnishedNo">No</label>
                    </div>

                </div>


            </div>
        </div>


    </div>
</template>