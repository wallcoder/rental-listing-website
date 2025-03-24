<script setup>
</script>
<template>
    <section class="border-r w-[250px] p-4 flex flex-col gap-6 text-sm py-6 h-[100vh] fixed z-10 bg-white md:sticky top-0 ">
        <div class="flex justify-end md:hidden">
            <i class='bx bx-x text-3xl cursor-pointer'  ></i>
        </div>
        <div class="flex flex-col gap-1">
            <h1 class="font-semibold text-base">Location</h1>
            <div class="flex   flex-col">
                <label for="district">District</label>
                <input type="search" id="district" class="p-2 border border-gray-300 outline-none ">
            </div>
            <div class="flex   flex-col">
                <label for="district">Street/Veng</label>
                <input type="search" id="district" class="p-2 border border-gray-300 outline-none ">
            </div>
        </div>
        <div class="flex flex-col gap-1">
            <h1 class="font-semibold text-base">Category</h1>
            <div class="flex   flex-col">
                <label for="district">Select Category</label>
                <input type="search" id="district" class="p-2 border border-gray-300 outline-none ">
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

            <button
                class="cursor-pointer p-2 px-3   bg-accent hover:brightness-110 active:brightness-100  text-white">Apply</button>

        </div>
        <div class="flex flex-col gap-2 w-full ">
            <h1 class="font-semibold text-base">Budget</h1>
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

            <!-- <button
                class="cursor-pointer p-2 px-3   bg-accent hover:brightness-110 active:brightness-100  text-white">Apply</button> -->

        </div>


    </section>
</template>
<style scoped></style>