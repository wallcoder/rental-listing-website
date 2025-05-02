<script setup>
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'
import {ref} from 'vue'
const floors =ref(['Ground Floor', 'First Floor', 'Second Floor', 'Third Floor', 'Forth Floor', 'Fifth Floor', 'Sixth Floor', 'Seventh Floor', 'Eighth Floor', 'Ninth Floor'])
const createPost = useCreatePostStore()
const { category, shopDetails } = storeToRefs(createPost)

</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300" v-if="category == 'shop'">
        <h1 class="text-xl">Shop Details</h1>
      
        <div>

            <div class="flex gap-10 ">
                <div class="flex flex-col w-full">
                    <label for="description">Description</label>
                    <textarea v-model="shopDetails.description" name="description" id="description" class="border rounded-lg p-2" cols="100" rows="4"></textarea>

                </div>



            </div>

            <div class="flex gap-10 ">
                <div class="flex flex-col w-[150px]">
                    <label for="price ">Price(per month)</label>
                    <div class="flex items-center gap-2">
                        <span>₹</span>
                        <input type="number" name="price" id="price" v-model="shopDetails.price"
                            class="border p-2 rounded-lg w-full outline-none" min="0" required>
                    </div>

                </div>



            </div>
            <div class="flex gap-7  items-center">
                <div class="flex flex-col w-[60px]">
                    <label for="bathroom">Area(sq.m)</label>
                    <input v-model="shopDetails.area" type="number" name="Area" id="Area" class="border p-2 rounded-lg w-full outline-none" min="0"
                        required>

                </div>
                <div class="flex flex-col">
                    <label for="floor">Floor</label>
                    <select v-model="shopDetails.floor" name="floor" id="floor" class="p-2">
                        <option v-for="f in floors" :value="f" :key="f">{{f}}</option>
                        
                    </select>

                </div>

            </div>
            <div class="flex gap-10 items-center">
                <div class="flex flex-col">
                    <span>Electricity</span>
                    <div class="flex gap-1 items-center">
                        <input v-model="shopDetails.electricity" type="radio" name="electricity" id="electricityYes" value="yes">
                        <label for="electricityYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input v-model="shopDetails.electricity" type="radio" name="electricity" id="electricityNo" value="no">
                        <label for="electricityNo">No</label>
                    </div>
                </div>

                <div class="flex flex-col">
                    <span>Water Supply</span>
                    <div class="flex gap-1 items-center">
                        <input v-model="shopDetails.water" type="radio" name="water" id="waterYes" value="yes">
                        <label for="waterYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input v-model="shopDetails.water" type="radio" name="water" id="waterNo" value="no">
                        <label for="waterNo">No</label>
                    </div>

                </div>

                <div class="flex flex-col">
                    <span>Attached Bathroom</span>
                    <div class="flex gap-1 items-center">
                        <input  v-model="shopDetails.bathroom" type="radio" name="bathroom" id="bathroomYes" value="yes">
                        <label for="bathroomYes">Yes</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input  v-model="shopDetails.bathroom" type="radio" name="bathroom" id="bathroomNo" value="no">
                        <label for="bathroomNo">No</label>
                    </div>

                </div>


            </div>
        </div>


    </div>
</template>