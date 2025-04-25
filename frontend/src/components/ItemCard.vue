<script setup>

import { RouterLink } from 'vue-router';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
const api = import.meta.env.VITE_SERVER

const props = defineProps({
    items: {
        type: Array,
        default: () => []
    }
})

function timeAgo(timestamp) {
    const nowUTC = new Date().getTime(); // local time in ms
    const postedUTC = new Date(timestamp).getTime(); // UTC timestamp in ms
    const diffInSeconds = Math.floor((nowUTC - postedUTC) / 1000);

    const secondsInMinute = 60;
    const secondsInHour = 3600;
    const secondsInDay = 86400;
    const secondsInWeek = 604800;
    const secondsInMonth = 2629800; // ~30.44 days
    const secondsInYear = 31557600; // ~365.25 days

    if (diffInSeconds < secondsInMinute) {
        return 'Just Now';
    } else if (diffInSeconds < secondsInHour) {
        const mins = Math.floor(diffInSeconds / secondsInMinute);
        return `${mins} minute${mins !== 1 ? 's' : ''} ago`;
    } else if (diffInSeconds < secondsInDay) {
        const hours = Math.floor(diffInSeconds / secondsInHour);
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
    } else if (diffInSeconds < secondsInWeek) {
        const days = Math.floor(diffInSeconds / secondsInDay);
        return `${days} day${days !== 1 ? 's' : ''} ago`;
    } else if (diffInSeconds < secondsInMonth) {
        const weeks = Math.floor(diffInSeconds / secondsInWeek);
        return `${weeks} week${weeks !== 1 ? 's' : ''} ago`;
    } else if (diffInSeconds < secondsInYear) {
        const months = Math.floor(diffInSeconds / secondsInMonth);
        return `${months} month${months !== 1 ? 's' : ''} ago`;
    } else {
        const years = Math.floor(diffInSeconds / secondsInYear);
        return `${years} year${years !== 1 ? 's' : ''} ago`;
    }
}



</script>
<template>
    <RouterLink :to="`/rental-properties/${n.slug}`" v-motion-fade-visible-once
        class="flex flex-col relative cursor-pointer  border hover:shadow-lg transition-shadow duration-300 bg-white rounded-lg overflow-hidden gap-1"
        v-for="n in items" :key="n.id">
        <!-- IMAGE -->
        
        <div class="relative">
            <img :src="`${api}/${n.thumbnail}`" class="w-full h-[250px] object-cover" :alt="n.id">

            <div v-if="n?.category == 'house'"
                class="bg-green-400 absolute rounded-full text-2xl -bottom-4 right-4 bx bx-home-alt-2 text-white p-2">

            </div>
            <div v-else class="bg-accent absolute rounded-full text-2xl -bottom-4 right-4 bx bx-store-alt text-white p-2">

            </div>
        </div>
        <!-- ATTRIBUTES -->
        <div v-if="n?.category == 'house'" class="px-4 py-2 flex flex-col">
            <span class="text-sm text-gray-600" v-if="n?.location?.city || n?.location?.locality">{{ n.location?.locality }},
                 {{
                    n.location.city }}</span>
            <span class="text-sm text-gray-600" v-else>Location Unavilable</span>

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
                <span class="text-accent font-semibold"><span>₹{{ n.house?.price }}</span><span
                        class="text-xs">/m</span></span>
                <!-- BOOKMARK -->
                <i class='bx bx-bookmark p-2  rounded-full border hover:bg-gray-100'></i>


            </div>
            <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>

        </div>
        <div v-else class="px-4 py-2 flex flex-col">
            <span class="text-sm text-gray-600" v-if="n?.location?.city || n?.location?.locality">{{ n.location?.locality }},
                 {{
                    n.location.city }}</span>
            <span class="text-sm text-gray-600" v-else>Location Unavilable</span>

            <div class="flex gap-2 items-center">
                <div class="flex  text-sm items-center">
                    <i class='bx bx-water'></i>
                    <span class=" text-gray-600"> <span v-if="n.shop?.water_supply == 'yes'"
                            class="bx bx-check text-lg text-green-500"></span> <span class="bx bx-x text-lg text-red-500"
                            v-else></span></span>
                </div>
                <div class="flex  text-sm items-center">
                    <i class='bx bx-bulb'></i>
                    <span class=" text-gray-600"> <span v-if="n.shop?.electricity == 'yes'"
                            class="bx bx-check text-lg text-green-500"></span> <span class="bx bx-x text-lg  text-red-500"
                            v-else></span></span>
                </div>
            </div>

            <div class="flex justify-between w-full">
                <span class="text-accent font-semibold"><span>₹{{ n.shop?.price }}</span><span
                        class="text-xs">/m</span></span>
                <!-- BOOKMARK -->
                <i class='bx bx-bookmark p-2  rounded-full border hover:bg-gray-100'></i>


            </div>
            <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>

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