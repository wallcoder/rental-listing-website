<script setup>
import {useCreatePostStore} from '@/stores/createPost'
import {storeToRefs} from 'pinia'
const createPost = useCreatePostStore()
const {category} = storeToRefs(createPost)
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300" v-if="category == 'house'">
        <h1 class="text-xl">House Details</h1>
        <div >
            <div class="flex gap-5 ">
                <div class="flex flex-col w-[60px]">
                    <label for="bathroom">Bathroom</label>
                    <input type="number" name="bathroom" id="bathroom" class="border p-2 rounded-lg w-full outline-none"
                        min="0" required>

                </div>
                <div class="flex flex-col w-[60px]">
                    <label for="bedrrom">Bedroom</label>
                    <input type="number" name="bedroom" id="bedroom" class="border p-2 rounded-lg w-full outline-none"
                        min="0" required>

                </div>

            </div>
            <div class="flex gap-10 items-center">
                <div class="flex flex-col">
                    <span>Balcony</span>
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
                    <span>Parking</span>
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
                    <span>Furnished</span>
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