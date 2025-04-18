<script setup>
import { ref } from 'vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { RouterLink } from 'vue-router';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const rentalListings = ref([
    {
        id: 1,
        price: "₹5000/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Chhinga Veng, Aizawl",
        posted: "1 day ago",
    },
    {
        id: 2,
        price: "₹7500/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Bairabi, Aizawl",
        posted: "3 days ago",
    },
    {
        id: 3,
        price: "₹4200/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "Bairabi, Aizawl",
        posted: "2 days ago",
    },
    {
        id: 4,
        price: "₹6800/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 2,
        location: "Chhimtuipui, Aizawl",
        posted: "1 week ago",
    },
    {
        id: 1,
        price: "₹5000/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Chhinga Veng, Aizawl",
        posted: "1 day ago",
    },
    {
        id: 2,
        price: "₹7500/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Bairabi, Aizawl",
        posted: "3 days ago",
    },
    

]);
</script>
<template>
    <RouterLink to="/rental-properties/asdsdfgasdsad"
        class="flex flex-col relative cursor-pointer  border hover:shadow-lg transition-shadow duration-300 bg-white rounded-lg overflow-hidden gap-1"
        v-for="n in rentalListings" :key="n">
        <div class="relative">
            <img src="../assets/house.jpg" class="w-full" alt="">
            <div class="bg-green-400 absolute rounded-full -bottom-4 right-4 bx bx-home-alt-2 text-white p-2">
              
            </div>
        </div>
        <div class="px-4 py-2 flex flex-col">
            <span class="text-sm text-gray-600">{{ n.location }}</span>

            <div class="flex gap-2 items-center">
                <div class="flex gap-1 text-sm items-center">
                    <i class='bx bxs-bed'></i>
                    <span class=" text-gray-600">{{ n.bedrooms }}</span>
                </div>
                <div class="flex gap-1 text-sm items-center">
                    <i class='bx bxs-bath'></i>
                    <span class=" text-gray-600">{{ n.bedrooms }}</span>
                </div>
            </div>

            <div class="flex justify-between w-full">
                <span class="text-accent font-semibold"><span>₹10000</span><span class="text-xs">/m</span></span>

                <i class='bx bx-bookmark p-2  rounded-full border hover:bg-gray-100'></i>


            </div>
            <span class="text-xs text-gray-600 ">{{ n.posted }}</span>

        </div>

    </RouterLink>
</template>
<style scoped>
.swiper-button-next:after {
    display: none;
}


.swiper-pagination-bullet-active {
    background-color: #000 !important;
}
</style>