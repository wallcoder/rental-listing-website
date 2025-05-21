<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'

const createPost = useCreatePostStore()
const { category, houseDetails, area, price } = storeToRefs(createPost)
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300" v-if="category == 'house'">
        <h1 class="text-xl">House Details</h1>
        <div class="flex flex-col gap-4">
            <div class="flex gap-10 ">
                <div class="flex flex-col w-full">
                    <label for="description">Description<span class="text-accent">*</span></label>
                    <textarea v-model="houseDetails.description" required name="description" id="description" class="border rounded-lg p-2" cols="100" rows="4"></textarea>

                </div>



            </div>
            <div class="flex gap-10 ">
                <div class="flex flex-col w-[150px]">
                    <label for="price ">Price(per month) <span class="text-accent">*</span></label>
                    <div class="flex items-center gap-2">
                        <span class="">₹</span>
                        <input type="number" name="price" id="price" v-model="price"
                            class="border p-2 rounded-lg w-full outline-none" min="0" required>
                    </div>

                </div>



            </div>
            <div class="flex gap-10 ">
                <div class="flex flex-col w-[60px]">
                    <label for="bathroom">Area(sq.m)<span class="text-accent">*</span></label>
                    <input type="number" name="Area" id="Area" v-model="area"
                        class="border p-2 rounded-lg w-full outline-none" min="0" required>

                </div>

                <div class="flex flex-col w-[60px]">
                    <label for="bathroom">Bathroom<span class="text-accent">*</span></label>

                    <input type="number" name="bathroom" id="bathroom" v-model="houseDetails.bathroom" step="1"
                        class="border p-2 rounded-lg w-full outline-none" min="0" required>

                </div>
                <div class="flex flex-col w-[60px]">
                    <label for="bedrrom">Bedroom<span class="text-accent">*</span></label>
                    <input type="number" name="bedroom" id="bedroom" v-model="houseDetails.bedroom"
                        class="border p-2 rounded-lg w-full outline-none" min="0" required>

                </div>

            </div>
            <div class="flex gap-10 items-center">
                <div class="flex flex-col">
                    <span>Balcony<span class="text-accent">*</span></span>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.balcony" type="radio" name="balcony" id="balconyYes" value="yes">
                        <label for="balconyYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.balcony" type="radio" name="balcony" id="balconyNo" value="no">
                        <label for="balconyNo">No</label>
                    </div>
                </div>

                <div class="flex flex-col">
                    <span>Parking<span class="text-accent">*</span></span>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.parking" type="radio" name="parking" id="parkingYes" value="yes">
                        <label for="parkingYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.parking" type="radio" name="parking" id="parkingNo" value="no">
                        <label for="parkingNo">No</label>
                    </div>

                </div>

                <div class="flex flex-col">
                    <span>Furnished<span class="text-accent">*</span></span>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.furnished" type="radio" name="furnished" id="furnishedYes" value="yes">
                        <label for="furnishedYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input v-model="houseDetails.furnished" type="radio" name="furnished" id="furnishedNo" value="no">
                        <label for="furnishedNo">No</label>
                    </div>

                </div>


            </div>
        </div>


    </div>
</template>