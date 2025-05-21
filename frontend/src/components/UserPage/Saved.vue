<script setup>

import { ref, onMounted } from 'vue'
import { useUserStore } from '@/stores/user';
import { storeToRefs } from 'pinia'
import { useUtilStore } from '@/stores/util';
const { savedListings, isLoadingSavedListings } = storeToRefs(useUserStore())
const { getSavedListings, saveListing } = useUserStore()
const {timeAgo} = useUtilStore()
const api = import.meta.env.VITE_SERVER
onMounted(() => {
    getSavedListings()
})




</script>
<template>
    <div>
        <div v-if="isLoadingSavedListings" class="w-full flex flex-col animate-pulse">
            <!-- Title -->
            <div class="flex justify-center py-4">
                <div class="relative overflow-hidden h-8 w-32 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>

            <!-- Listings -->
            <div class="flex flex-col py-8 gap-4">
                <div v-for="n in 5" :key="n"
                    class="flex-col flex md:flex-row gap-4 rounded-lg  p-2 relative overflow-hidden">
                    <!-- Image Placeholder -->
                    <div class="overflow-hidden min-w-[300px] rounded-lg h-[200px] bg-gray-200 relative">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>

                    <!-- Textual Content Placeholder -->
                    <div class="flex flex-col gap-2 flex-1">
                        <div class="flex justify-between items-center">
                            <div class="h-6 w-48 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                            <div class="h-6 w-6 bg-gray-200 rounded-full relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="h-4 w-24 bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="h-4 w-12 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                            <div class="h-4 w-12 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="h-5 w-32 bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>

                        <div class="h-10 w-full bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-else class="w-full flex flex-col">
            <h1 class="text-3xl text-center">Saved</h1>
          
            <div class="flex flex-col   py-8 gap-4" v-if="savedListings.length > 0">

                <div v-for="n in savedListings" :key="n.id"
                    class="flex-col flex md:flex-row gap-4  rounded-lg hover:bg-gray-100  p-2">
                    <RouterLink :to="`/rental-properties/${n.slug}`" v-if="n?.thumbnail"
                        class="overflow-hidden min-w-[300px]  rounded-lg h-[250px] md:h-[200px]">
                        <img :src="`${api}/${n?.thumbnail}`" class="w-full h-full object-cover" alt="">

                    </RouterLink>
                   
                    <div class="flex flex-col gap-2 w-full" v-if="n.location">
                        <div class="flex justify-between ">
                            <h1 class="text-2xl"><span v-if="n.location?.locality">{{ n?.location?.locality }},</span> <span
                                    v-if="n.location?.locality">{{ n?.location?.city }}</span> </h1>
                            <i @click="saveListing(n.id )" class='bx bx-bookmark p-2 cursor-pointer rounded-full border bg-gray-200 '></i>

                        </div>


                        <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>
                        <div v-if="n?.category == 'shop'">
                            <div class="flex gap-2 items-center">
                                <div class="flex  text-sm items-center">
                                    <i class='bx bx-water'></i>
                                    <span class=" text-gray-600"> <span v-if="n.shop?.water_supply == 'yes'"
                                            class="bx bx-check text-lg text-green-500"></span> <span
                                            class="bx bx-x text-lg text-red-500" v-else></span></span>
                                </div>
                                <div class="flex  text-sm items-center">
                                    <i class='bx bx-bulb'></i>
                                    <span class=" text-gray-600"> <span v-if="n.shop?.electricity == 'yes'"
                                            class="bx bx-check text-lg text-green-500"></span> <span
                                            class="bx bx-x text-lg  text-red-500" v-else></span></span>
                                </div>

                            </div>
                            <div class="flex justify-between w-full">
                                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span
                                        class="text-xs">/m</span></span>




                            </div>
                            <p class="w-[100%] line-clamp-2 ">
                                {{ n?.shop?.description }}
                            </p>
                        </div>
                        <div v-else>
                            <div class="flex gap-2 items-center">
                                <div class="flex gap-1 text-sm items-center">
                                    <i class='bx bxs-bed '></i>
                                    <span class=" text-gray-600">{{ n.house?.bedroom }}</span>
                                </div>
                                <div class="flex gap-1 text-sm items-center">
                                    <i class='bx bxs-bath'></i>
                                    <span class=" text-gray-600">{{ n.house?.bathroom }}</span>
                                </div>

                            </div>
                            <div class="flex justify-between w-full">
                                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span
                                        class="text-xs">/m</span></span>




                            </div>
                            <p class="w-[100%] line-clamp-2 ">
                                {{ n?.house?.description }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>
            <div v-else class="text-center py-6 text-lg text-gray-600 ">
                You have no saved listings

            </div>

        </div>
    </div>
</template>