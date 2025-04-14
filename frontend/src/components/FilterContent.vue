<script setup>
import { useUtilStore } from '@/stores/util';
import { storeToRefs } from 'pinia';
import {ref} from 'vue'
const util = useUtilStore();
const { isOpenFilterSidebar } = storeToRefs(util);
const { toggleFilterSidebar } = util;
import ButtonLink from './ButtonLink.vue';
import FormInput from './FormInput.vue';

const test = ref('');

</script>
<template>
    <div class="  w-full h-full  flex flex-col gap-4 ">
        <div class="flex justify-end md:hidden">
            <i class='bx bx-x text-3xl cursor-pointer' @click="toggleFilterSidebar()"></i>
        </div>
        <div class="flex flex-col gap-1">
            <h1 class="font-semibold text-base">Location</h1>
            <FormInput label="District" placeholder="District" v-model="test" :required="false" id="district"  />
            <FormInput label="Street/Veng" placeholder="Street/Veng" v-model="test" :required="false" id="street-veng"  />
            
        </div>
        <!-- <div class="flex flex-col gap-1">
            <h1 class="font-semibold text-base">Category</h1>
            
            <div class="flex gap-2">
                <input type="checkbox" class="cursor-pointer" >
                <label for="check">Rental House</label>
            </div>
            
           

        </div> -->
        <div class="flex flex-col gap-1">
            <h1 class="font-semibold text-base">Type</h1>
            <div class="flex gap-2">
                <input type="checkbox" class="cursor-pointer"  >
                <label for="check">Assam-Type</label>
            </div>
            <div class="flex gap-2">
                <input type="checkbox" class="cursor-pointer" >
                <label for="check">Concrete</label>
            </div>
            
           

        </div>
        <div class="flex flex-col gap-2 w-full ">
            <h1 class="font-semibold text-base">Budget</h1>
            <div class="flex w-full gap-2 items-center">
                <div class="flex flex-col flex-1">
                    <label for="min">Min</label>
                    <input type="text" id="min" class="p-2 border border-gray-300 outline-none w-full">
                </div>

                <div class="flex flex-col flex-1">
                    <label for="max">Max</label>
                    <input type="text" id="max" class="p-2 border border-gray-300 outline-none w-full">
                </div>
            </div>
            <ButtonLink :isLink="false" content="Apply" :fun="() => { }" />
            <!-- <button
                class="cursor-pointer p-2 px-3   bg-accent hover:brightness-110 active:brightness-100  text-white">Apply</button> -->

        </div>
        <div class="flex flex-col gap-2 w-full ">
            <h1 class="font-semibold text-base">Attributes</h1>
            <div class="flex w-full gap-2 items-center">
                <div class="flex flex-col flex-1">
                    <label for="min">Bathroom</label>
                    <input type="text" id="min" class="p-2 border border-gray-300 outline-none w-full">
                </div>

                <div class="flex flex-col flex-1">
                    <label for="max">Kitchen</label>
                    <input type="text" id="max" class="p-2 border border-gray-300 outline-none w-full">
                </div>
            </div>

            <div class="flex w-full gap-2 items-center">
                <div class="flex flex-col flex-1">
                    <label for="min">Living Room</label>
                    <input type="text" id="min" class="p-2 border border-gray-300 outline-none w-full">
                </div>

                <div class="flex flex-col flex-1">
                    <label for="max">Bedroom</label>
                    <input type="text" id="max" class="p-2 border border-gray-300 outline-none w-full">
                </div>
                
            </div>
            <div class="flex w-full gap-2 items-center">
                <div class="flex flex-col flex-1">
                    <label for="min">Floor</label>
                    <input type="text" id="min" class="p-2 border border-gray-300 outline-none w-full">
                </div>

                
                
            </div><ButtonLink :isLink="false" content="Apply" :fun="() => { }" />

            <!-- <button
                class="cursor-pointer p-2 px-3   bg-accent hover:brightness-110 active:brightness-100  text-white">Apply</button> -->

        </div>
    </div>
</template>

<style scoped></style>