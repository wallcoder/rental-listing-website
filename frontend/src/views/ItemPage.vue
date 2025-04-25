<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { RouterLink } from 'vue-router';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import MapView from '@/components/MapView.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import {useItemStore} from '@/stores/item'
import {storeToRefs} from 'pinia'

// const isOpenSlideshow = ref(false);
// const isLoadingItem = ref(false);
const {isLoadingItem, item, isOpenSlideshow} = storeToRefs(useItemStore());
const {getItem} = useItemStore() 
const props = defineProps({
    slug: {
        type: String,
        required: true
    }
})
onMounted(() => {
    getItem(props.slug)
})

</script>
<template>
    <div>
        <div v-if="isLoadingItem">
            <div class="px-[4%] lg:px-[8%]">
                <!-- Desktop Image Grid Skeleton -->
                <div class="w-full hidden md:flex gap-1 py-4">
                    <div class="relative overflow-hidden w-[50%] h-72 bg-gray-100 rounded">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>
                    <div class="w-[50%] flex flex-wrap gap-1">
                        <div v-for="n in 4" :key="n" class="relative overflow-hidden w-[49%] h-36 bg-gray-100 rounded">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Swiper Skeleton -->
                <div class="md:hidden py-4">
                    <div v-for="n in 1" :key="n" class="relative overflow-hidden h-64 bg-gray-100 rounded">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>
                </div>

                <!-- Info Section Skeleton -->
                <section class="py-6 flex flex-col gap-3">
                    <!-- Title -->
                    <div class="relative overflow-hidden h-8 w-60 bg-gray-100 rounded">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>

                    <!-- Date Info -->
                    <div class="flex flex-col gap-1">
                        <div class="relative overflow-hidden h-4 w-32 bg-gray-100 rounded">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                        <div class="relative overflow-hidden h-3 w-24 bg-gray-100 rounded">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <div v-for="n in 4" :key="n" class="relative overflow-hidden h-4 bg-gray-100 rounded w-full">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-2 py-4">
                        <div v-for="n in 4" :key="n" class="relative overflow-hidden h-20 bg-gray-100 rounded-lg">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Map Skeleton -->
                    <div class="relative overflow-hidden w-full h-[60vh] bg-gray-100 rounded-lg">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>
                </section>

                <!-- Contact Card Skeleton -->

            </div>
        </div>
        <section class="px-[4%]  lg:px-[8%] " v-else>
            <section>
                <!-- {{item}} -->

                <div class="w-full hidden gap-1 md:flex" @click="isOpenSlideshow = true">
                    <div class="w-[50%] cursor-pointer overflow-hidden ">
                        <img src="@/assets/house.jpg"
                            class="brightness-[0.8] hover:brightness-[1] hover:scale-105 transition-all ease-out duration-500"
                            alt="">
                    </div>
                    <div class="w-[50%] flex flex-wrap gap-1 ">
                        <div class="w-[49%] cursor-pointer overflow-hidden" v-for="n in 4" :key="n"><img
                                src="@/assets/house.jpg" alt=""
                                class="brightness-[0.8] hover:brightness-[1] hover:scale-105 transition-all ease-out duration-500">
                        </div>


                    </div>
                </div>

                <div class="md:hidden">
                    <Swiper :modules="[Pagination]" :pagination="{ clickable: true }">
                        <SwiperSlide v-for="n in 5" :key="n">
                            <img src="@/assets/house.jpg"
                                class="brightness-[0.8] hover:brightness-[1] hover:scale-105 transition-all ease-out duration-500"
                                alt="">

                        </SwiperSlide>

                    </Swiper>
                </div>
            </section>
            <section class="py-6 flex flex-col gap-1 w-full ">
                <h1 class="text-3xl"><span>{{ item.location?.street }}, </span><span>{{ item.location?.locality }}</span><span>{{ item.location?.city }}</span></h1>
                <div class="flex flex-col md:flex-row gap-2 ">
                    <div class="flex-1 flex flex-col gap-2">
                        <div class="flex flex-col ">
                            <span class="text-gray-500">Posted 2 days ago</span>
                            <span class="text-gray-500 text-xs">12 December 2025</span>
                        </div>
                        <p class="text-gray-700 ">{{ item.house?.description }}
                        </p>

                        <div
                            class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4  gap-2 text-xl  py-4   rounded-lg ">
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg" v-for="n in 4"
                                :key="n">
                                <h3 class="text-gray-500">Monthly Rent</h3>
                                <span>₹12,000</span>
                            </div>


                        </div>
                        <div class="w-full h-[60vh] rounded-lg">
                            <MapView />

                        </div>


                    </div>
                    <!-- CONTACT-->
                    <div id="contact" class="w-full md:w-[40%] lg:w-1/3 self-start sticky top-8">
                        <div class="rounded-lg border border-gray-200 p-4 flex flex-col gap-2">
                            <h3 class="text-xl">Contact this Property</h3>
                            <ul class="flex flex-col ">
                                <li class="flex items-center gap-2"><i class='bx bxs-phone text-accent'></i> <span
                                        class="text-gray-700">Phone: 876123****</span></li>
                                <li class="flex items-center gap-2"><i class='bx bx-envelope text-accent'></i> <span
                                        class="text-gray-700">Email: abcd@gmail.com</span></li>

                            </ul>
                            <div class="flex flex-col gap-2">
                                <ButtonLink content="Send Email" icon="bx bx-envelope text-xl"
                                    link="/browse?street=&locality=&city=&state=Mizoram&pincode=&country=India"
                                    extraStyle="bg-white border-2 border-gray-400 hover:bg-accent hover:border-transparent hover:text-white" />
                                <ButtonLink content="Send Message" icon="bx bx-message-dots" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="fixed top-0 w-full  left-0 z-30">
                <Transition>
                    <div @click="isOpenSlideshow = false" v-if="isOpenSlideshow"
                        class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto">

                    </div>
                </Transition>
                <Transition>


                    <div v-if="isOpenSlideshow"
                        class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2  w-[65%] ">

                        <Swiper :modules="[Pagination]" :pagination="{ clickable: true }">
                            <SwiperSlide v-for="n in 5" :key="n">
                                <img src="@/assets/house.jpg" class="" alt="">

                            </SwiperSlide>

                        </Swiper>
                    </div>
                </Transition>

            </div>

            <!-- CONTACT BUTTON LINK -->
            <RouterLink to="#contact"
                class="md:hidden fixed bg-accent bottom-4 right-2 opacity-70 hover:opacity-100 p-4 z-30 rounded-full flex items-center justify-center">
                <i class="bx bxs-phone text-xl text-white"></i>
            </RouterLink>



        </section>
    </div>
</template>
<style scoped></style>