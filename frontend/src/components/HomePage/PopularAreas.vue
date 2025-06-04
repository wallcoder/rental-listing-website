<script setup>
import { ref, onMounted } from 'vue'
import { useAreaStore } from '@/stores/area'
import { storeToRefs } from 'pinia'

const { area, isLoadingArea } = storeToRefs(useAreaStore())
const { getArea } = useAreaStore()



onMounted(() => {
    getArea()
})


</script>
<template>
    <!-- POPULAR AREAS -->
    <section>


        <!-- SKELETON -->
        <div class="flex flex-col gap-4  py-10 border-b-2 border-gray-200 bg-white" v-if="isLoadingArea">
            <div>
                <div class="relative overflow-hidden h-8 w-48 mx-auto bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/90 to-transparent">
                    </div>
                </div>
                <div class="relative overflow-hidden h-4 w-40 mx-auto mt-2 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/90 to-transparent">
                    </div>
                </div>
            </div>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 md:px-18 ">
                <div v-for="n in 4" :key="n" class="rounded-lg overflow-hidden bg-gray-100 h-56 relative">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/90 to-transparent">
                    </div>


                </div>
            </div>
        </div>

        <div v-else class="flex flex-col gap-4 py-10 border-b-2 border-gray-200 ">
            <div>
                <h1 class="text-3xl font-semibold text-center">Popular <span class="text-accent">Areas</span></h1>
                <p class="text-center text-gray-500">Some of our popular areas</p>
            </div>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 md:px-18  m-auto">
                <RouterLink :to="`/browse?street=&locality=&city=${n?.city}&state=Mizoram&pincode=&country=India`"
                    v-for="(n, i) in area" :key="i" class=" rounded-lg overflow-hidden relative group">
                    <img v-if="i == 0" src="@/assets/mizoram.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 1" src="@/assets/mizoram2.jpg" w-full alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 2" src="@/assets/mizoram3.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 3" src="@/assets/mizoram4.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 4" src="@/assets/mizoram3.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 5" src="@/assets/mizoram3.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 6" src="@/assets/mizoram3.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">
                    <img v-else-if="i == 7" src="@/assets/mizoram3.jpg" alt=""
                        class="object-cover rounded-lg brightness-[0.8] w-full h-[270px] group-hover:brightness-[0.9] group-hover:scale-110 transition-all duration-500 ">

                    <div
                        class="flex flex-col absolute bottom-0 justify-center items-center z-20  text-white  w-full h-full ">
                        <div class="flex flex-col items-center">
                            <h3 class="  text-xl font-semibold  ">
                                {{ n?.city }}</h3>
                            <span class="text-xs">{{ n?.post_count }} Posts</span>
                        </div>
                    </div>
                </RouterLink>


            </div>

        </div>
    </section>
</template>