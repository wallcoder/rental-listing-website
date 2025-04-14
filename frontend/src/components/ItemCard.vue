<script setup>
import { ref } from 'vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import {RouterLink} from 'vue-router';
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
    
]);
</script>
<template>
    <RouterLink to="/rental-properties/asdsdfgasdsad" class="flex  relative flex-col cursor-pointer p-2 border-2 hover:shadow-lg transition-shadow duration-300 bg-white rounded-lg overflow-hidden gap-1"
        v-for="n in rentalListings" :key="n">
        <div class="group">
            <Swiper :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="1" :loop="true" class="w-full h-48 "
                :hideOnClick=true  :navigation="false"
                :pagination="{ clickable: true }" >
                <SwiperSlide>
                    <img class="w-full h-48 object-cover"
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>
                <SwiperSlide>
                    <img class="w-full h-48 object-cover"
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>
                <SwiperSlide>
                    <img class="w-full h-48 object-cover"
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>
                <SwiperSlide>
                    <img class="w-full h-48 object-cover"
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>

            </Swiper>
            <div
                class="absolute inset-0 flex items-end justify-center pb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="swiper-pagination"></div>
            </div>
        </div>


        <div class=" flex flex-col p-3">
            <h2 class="font-semibold text-lg">{{ n.price }}</h2>
            <!-- <span class="flex items-center gap-1">
                <i class='bx bxs-star text-yellow-400 text-sm'></i> <span class="text-gray-600">4.3 (10)</span>
            </span> -->
            <div class="flex gap-3  text-gray-600 text-sm">
                <span class="flex items-center gap-1">
                    <i class='bx bxs-bed text-accent'></i> <span>{{ n.bedrooms }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <i class='bx bxs-bath text-accent'></i> <span>{{ n.bathrooms }}</span>
                </span>
                <!-- <span class="flex items-center gap-1">
                    <i class='bx bxs-home text-accent'></i> <span>{{ n.livingRooms }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <i class='bx bxs-map text-accent'></i> <span>2</span>
                </span> -->

            </div>

            <span class=" flex items-center"> <i class="bx text-accent bxs-phone"></i><span>7628063215</span> </span>
            <span class=" text-gray-500">{{ n.location }}</span>
            <span class="text-gray-500 text-sm">Posted {{ n.posted }}</span>

        </div>
        <i
            class='bx bxs-heart absolute top-2 right-2 opacity-80 hover:text-accent hover:opacity-100  text-3xl'></i>
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