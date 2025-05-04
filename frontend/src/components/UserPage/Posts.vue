<script setup>
</script>
<template>
    <div class="w-full flex flex-col">
        <h1 class="text-3xl text-center">Posts</h1>

        <div class="flex flex-col   py-8 gap-4">

            <div class="flex-col flex md:flex-row gap-4  rounded-lg hover:bg-gray-100  p-2" v-for="n in 5" :key="n">
                <div class="overflow-hidden min-w-[300px]  rounded-lg h-[200px]">
                    <img src="../../assets/house.jpg" class="w-full h-full object-cover" alt="">

                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex justify-between">
                        <h1 class="text-2xl">Chaltlang, Aizawl </h1>

                        <div class="flex gap-2">
                            <i class='bx bx-edit p-2 cursor-pointer   rounded-full border hover:bg-gray-200'></i>
                            <i class='bx bx-x p-2 cursor-pointer   rounded-full border hover:bg-gray-200'></i>
                        </div>
                    </div>


                    <span class="text-xs text-gray-600 ">2 days ago</span>
                    <div class="flex gap-2 items-center">
                        <div class="flex gap-1 text-sm items-center">
                            <i class='bx bxs-bed '></i>
                            <span class=" text-gray-600">2</span>
                        </div>
                        <div class="flex gap-1 text-sm items-center">
                            <i class='bx bxs-bath'></i>
                            <span class=" text-gray-600">2</span>
                        </div>
                    </div>
                    <div class="flex justify-between w-full">
                        <span class="text-accent font-semibold"><span>₹20000</span><span class="text-xs">/m</span></span>




                    </div>
                    <p class="w-[100%] line-clamp-2 ">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem aspernatur saepe eum ipsam
                        distinctio nihil excepturi quasi ab? Similique eaque earum dolorum!
                    </p>

                </div>

            </div>

        </div>

    </div>
</template>