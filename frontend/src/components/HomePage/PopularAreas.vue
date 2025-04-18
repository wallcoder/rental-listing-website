<script setup>
</script>
<template>
    <!-- POPULAR AREAS -->
    <div class="flex flex-col gap-4 py-10 border-b-2 border-gray-300 ">
        <div>
            <h1 class="text-3xl font-semibold text-center">Popular <span class="text-accent">Areas</span></h1>
            <p class="text-center text-gray-500">Some of our popular areas</p>
        </div>
        <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 md:px-18 lg:px-24">
            <RouterLink v-for="n in 3" :key="n" class=" rounded-lg overflow-hidden relative group">
                <img src="@/assets/house.jpg" alt=""
                    class="object-cover rounded-lg brightness-[0.6] group-hover:brightness-[0.7] group-hover:scale-110 transition-all duration-500 ">

                <div class="flex flex-col absolute bottom-0 justify-center items-center z-20  text-white  w-full h-full ">
                    <div class="flex flex-col items-center">
                        <h3 class="  text-xl font-semibold  ">
                            Aizawl</h3>
                        <span class="text-xs">30 Posts</span>
                    </div>
                </div>
            </RouterLink>


        </div>

    </div>
</template>