<script setup>
import ItemCard from '@/components/ItemCard.vue';
import ButtonLink from '@/components/ButtonLink.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { storeToRefs } from 'pinia'
import { usePostStore } from '@/stores/post'


const { isLoading, featuredRentals, saves } = storeToRefs(usePostStore());
const { getFeaturedRentals, getSaved,savePost } = usePostStore()


onMounted(() => {
    getFeaturedRentals()
    getSaved()
})

</script>
<template>
    <section>
        
        <div v-if="isLoading" class="flex flex-col gap-4 py-10 border-b-2 border-gray-200 bg-white">
            <!-- Title Skeleton -->
            <div class="flex flex-col gap-2 items-center">
                <div class="relative overflow-hidden h-8 w-48 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 md:px-18 ">
                <div v-for="n in 8" :key="n" class="rounded-lg overflow-hidden bg-gray-100 h-56 relative">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>

            <!-- Button Skeleton -->
            <div class="flex items-center justify-center min-h-20">
                <div class="relative overflow-hidden h-10 w-48 bg-gray-100 rounded-full">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>
        </div>

        <div  v-else class="flex flex-col gap-4 v-else py-10 border-b-2 border-gray-200">
            
            <h1 class="text-3xl font-semibold text-center">Recent <span class="text-accent">Listings</span></h1>
            <div v-if="featuredRentals.length > 0">
               
                <div
                    class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:px-18 ">
                    <ItemCard :items="featuredRentals" />


                </div>
                <div class="flex items-center justify-center min-h-20">
                    <ButtonLink content="More Rentals" icon="bx bx-right-arrow-alt text-xl" link="/browse?street=&locality=&city=&state=Mizoram&pincode=&country=India"
                        extraStyle="bg-white border-2 border-gray-400 hover:bg-accent hover:border-none hover:text-white" />
                </div>

            </div>
            <div v-else class="flex flex-col gap-6 items-center justify-center py-6">

               
                <h1 class="text-lg  text-center text-gray-500">No Listing is available yet. Come back later.</h1>

            </div>

        </div>


    </section>
    <!-- FEATURED RENTALS -->
</template>