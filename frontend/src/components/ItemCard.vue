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
    <div class="flex flex-col relative   transition-shadow duration-300 bg-white rounded-lg overflow-hidden gap-1"
        v-for="n in items" :key="n.id">
        <!-- IMAGE -->

        <RouterLink :to="`/rental-properties/${n.slug}`" class="relative ">
            <img :src="`${api}/${n.thumbnail}`" class="w-full  rounded-xl h-[250px] object-cover" :alt="n.id">

            <div class="flex justify-between absolute -bottom-4 right-4 gap-2">
                <div v-if="n?.category == 'house'"
                    class="bg-green-400  rounded-full text-2xl -bottom-4 right-4 bx bx-home-alt-2 text-white p-2">

                </div>
                <div v-else class="bg-accent  rounded-full text-2xl -bottom-4 right-4 bx bx-store-alt text-white p-2">

                </div>
                <div v-if="n?.is_boosted" class="bg-blue-500 rounded-full text-2xl   text-white  p-2 lamp-glow bx bx-rocket">
                </div>

            </div>
        </RouterLink>


        <!-- ATTRIBUTES -->
        <div v-if="n?.category == 'house'" class="py-2 flex flex-col p-2">
            <h1 v-if="n?.location?.city || n?.location?.locality" class="text-sm text-gray-600"><span
                    v-if="n.location?.locality">{{ n?.location?.locality }},</span> <span v-if="n.location?.city">{{
                        n?.location?.city }}</span> </h1>
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
                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span class="text-xs text-gray-700">/mo</span></span>
                <!-- BOOKMARK -->
                <i class='bx bx-bookmark p-2  rounded-full border cursor-pointer hover:bg-gray-100'></i>


            </div>
            <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>

        </div>
        <div v-else class="py-2 flex flex-col p-2">
            <span class="text-sm text-gray-600" v-if="n?.location?.city || n?.location?.locality">{{ n.location?.locality
            }},
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
                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span class="text-xs text-gray-700">/mo</span></span>
                <!-- BOOKMARK -->
                <i class='bx bx-bookmark p-2 cursor-pointer  rounded-full border hover:bg-gray-100'></i>


            </div>
            <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>

        </div>

    </div>
</template>
<style scoped>
.swiper-button-next:after {
    display: none;
}

@keyframes lamp-glow {

    0%,
    100% {
        box-shadow: 0 0 1px 1px rgba(58, 118, 248, 0.9);
        opacity: 1;
    }

    50% {
        box-shadow: 0 0 1px 2px rgba(58, 118, 248, 0.9);
        opacity: 0.9;
    }
}

.lamp-glow {
    animation: lamp-glow 2s ease-in-out infinite;
}

.swiper-pagination-bullet-active {
    background-color: #000 !important;
}
</style>