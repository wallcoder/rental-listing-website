<script setup>
import { ref, onMounted, computed } from 'vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { RouterLink } from 'vue-router';
import "swiper/css";

import "swiper/css/navigation";
import "swiper/css/pagination";
import MapView from '@/components/MapView.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { useItemStore } from '@/stores/item'
import { storeToRefs } from 'pinia'
import { GoogleMap, AdvancedMarker, Marker } from 'vue3-google-map'
const mapId = import.meta.env.VITE_MAP_ID
// const isOpenSlideshow = ref(false);
// const isLoadingItem = ref(false);
const zoom = 15
const mapRef = ref(null);
const imageApi = import.meta.env.VITE_SERVER;
const api = ref(import.meta.env.VITE_MAP_API)
const location = ref({
    lat: 40.689247,
    lng: -74.044502
})
const markers = ref([]
)
function recenterMap() {
    if (mapRef.value && mapRef.value.map) {
        mapRef.value.map.panTo(location.value);
    }
}

function openInGoogleMaps() {
    const { lat, lng } = location.value;
    const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    window.open(url, '_blank');
}
const { isLoadingItem, item, isOpenSlideshow } = storeToRefs(useItemStore());
const { getItem } = useItemStore()
const props = defineProps({
    slug: {
        type: String,
        required: true
    }
})
onMounted(async () => {
    await getItem(props.slug)
    location.value = {
        lat: Number(item.value.location.latitude),
        lng: Number(item.value.location.longitude),
    };

    markers.value = [{
        position: { lat: Number(item.value.location.latitude), lng: Number(item.value.location.longitude) },
        title: `Marker at ${Number(item.value.location.latitude)}, ${Number(item.value.location.longitude)}`
    }]
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

function formatDate(dateString) {
    const date = new Date(dateString);

    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'long' }); // e.g., "April"
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

const filteredImages = computed(() => {
    if (!item.value?.image) return []
    return item.value.image.filter((_, i) => i !== 0 && i < 5)
})
</script>
<template>
    <div>

        <!-- {{ item.location }} -->
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

                <div class="w-full hidden gap-1 lg:flex h-[450px]" v-if="item?.image">
                    <div class="w-[50%] cursor-pointer overflow-hidden h-[450px]"  @click="isOpenSlideshow = true">
                        <img :src="`${imageApi}/${item.image[0].image}`"
                            class="brightness-[0.8] hover:brightness-[1] hover:scale-105 transition-all ease-out duration-500 w-full h-full object-cover"
                            alt="">
                    </div>
                    <!-- SECOND BLOCK -->

                    <div class="w-[50%] grid grid-cols-2 grid-rows-2 gap-1">
                        <div v-for="(img, i) in filteredImages" :key="i"  @click="isOpenSlideshow = true"
                            class="w- cursor-pointer bg-red- overflow-hidden  ">
                            <img :src="`${imageApi}/${img.image}`" alt=""
                                class="brightness-[0.8] hover:brightness-[1] hover:scale-105 h-full w-full  transition-all ease-out duration-500 object-cover">
                        </div>
                        <div class="bg-gray-100" v-for="n in (4-filteredImages.length)" :key="n">

                        </div>



                    </div>

                </div>

                <div class="lg:hidden w-full h-[320px]"  >
                    <Swiper :modules="[Pagination]" :pagination="{ clickable: true }" class="w-full h-full">
                        <SwiperSlide v-for="i in item.image" :key="i" class="w-full h-full">
                            <img :src="`${imageApi}/${i.image}`"
                                class="brightness-[0.8] hover:brightness-[1] w-full h-full hover:scale-105 transition-all ease-out duration-500 object-cover"
                                alt="">

                        </SwiperSlide>

                    </Swiper>
                </div>
            </section>
            <section class="py-6 flex flex-col gap-1 w-full ">

                <h1 class="text-3xl" v-if="item?.location?.street || item?.location?.locality || item?.location?.city">
                    <span v-if="item.location?.street">{{ item.location?.street }}, </span>
                    <span v-if="item.location?.locality">{{ item.location?.locality }}, </span>
                    <span v-if="item.location?.city">{{ item.location?.city }} </span>

                </h1>
                <h1 v-else class="text-gray-500 text-3xl">
                    Location Unavailable

                </h1>

                <div class="flex flex-col md:flex-row gap-2 ">
                    <div class="flex-1 flex flex-col gap-2">
                        <div class="flex flex-col ">
                            <span class="text-gray-500">{{ timeAgo(item.created_at) }}</span>
                            <span class="text-gray-500 text-xs">Posted {{ formatDate(item.created_at) }}</span>
                        </div>
                        <p class="text-gray-700 " v-if="item.category == 'house'"> {{ item.house?.description }}
                        </p>
                        <p class="text-gray-700 " v-else> {{ item.shop?.description }}
                        </p>
                        <div v-if="item.category == 'house'"
                            class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4  gap-2 text-xl  py-4   rounded-lg ">
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Monthly Rent</h3>
                                <span>₹{{ item.house?.price }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Area</h3>
                                <span>{{ item.house?.area }} sq.m</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Bedrooms</h3>
                                <span class="capitalize">{{ item.house?.bedroom }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Bathrooms</h3>
                                <span class="capitalize">{{ item.house?.bathroom }}</span>
                            </div>


                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Balcony</h3>
                                <span class="capitalize">{{ item.house?.balcony }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Parking Space</h3>
                                <span class="capitalize">{{ item.house?.parking }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Furnished</h3>
                                <span class="capitalize">{{ item.house?.furnished }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Category</h3>
                                <span class="capitalize">{{ item.category }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Type</h3>
                                <span class="capitalize">{{ item.type }}</span>
                            </div>
                        </div>
                        <div v-else
                            class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4  gap-2 text-xl  py-4   rounded-lg ">


                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Monthly Rent</h3>
                                <span>₹{{ item.shop?.price }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Area</h3>
                                <span>{{ item.shop?.area }} sq.m</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Electricity</h3>
                                <span class="capitalize">{{ item.shop?.electricity }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Water Supply</h3>
                                <span class="capitalize">{{ item.shop?.water_supply }}</span>
                            </div>


                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Attached Bathroom</h3>
                                <span class="capitalize">{{ item.shop?.attached_bathroom }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Floor</h3>
                                <span class="capitalize">{{ item.shop?.floor }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Category</h3>
                                <span class="capitalize">{{ item.category }}</span>
                            </div>
                            <div class="flex flex-col items-center px-6 bg-gray-100 py-2 rounded-lg">
                                <h3 class="text-gray-500 text-center">Type</h3>
                                <span class="capitalize">{{ item.type }}</span>
                            </div>

                        </div>
                        <div class="flex flex-col gap-2 py-4">
                            <div class=" top-3 right-16 flex gap-2">
                                <button @click="recenterMap()"
                                    class="p-1 px-2   bg-accent hover:brightness-[1.2] active:brightness-100 rounded-lg cursor-pointer text-white">Recenter</button>
                                <button @click="openInGoogleMaps"
                                    class="p-1 px-2  flex items-center gap-2 bg-accent hover:brightness-[1.2] active:brightness-100 rounded-lg cursor-pointer text-white"><span
                                        class="bx bx-current-location"></span><span>Waypoint</span></button>
                            </div>
                            <div class="w-full h-[60vh] rounded-lg">

                                <section class="relative w-full h-full">

                                    <GoogleMap ref="mapRef" :api-key="api" style="width:100%; height:100%;"
                                        :center="location" :zoom="zoom" :mapId="mapId">
                                        <Marker v-for="(marker, index) in markers" :key="index" :options="marker" />
                                        <!-- <AdvancedMarker :position="marker" /> -->
                                    </GoogleMap>

                                </section>

                            </div>
                        </div>



                    </div>
                    <!-- CONTACT-->
                    <div id="contact" class="w-full md:w-[40%] lg:w-1/3 self-start sticky top-8">
                        <div class="rounded-lg border border-gray-200 p-4 flex flex-col gap-2">
                            <h3 class="text-xl">Contact this Property</h3>
                            <ul class="flex flex-col ">
                                <li class="flex items-center gap-2"><i class='bx bxs-phone text-accent'></i> <span
                                        class="text-gray-700">Phone: {{ item.phone }}</span></li>
                                <li class="flex items-center gap-2"><i class='bx bx-envelope text-accent'></i> <span
                                        class="text-gray-700">Email: {{ item.email }}</span></li>

                            </ul>
                            <div class="flex flex-col gap-2">
                                <a :href="`mailto:${item.email}`" class="flex items-center border-2  border-gray-400 hover:border-transparent hover:text-white justify-center gap-2 cursor-pointer p-[8px] px-5 text-center rounded-3xl hover:bg-accent">
                                    <i class='bx bx-envelope'></i><span>Send Email</span></a>
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
                        class="absolute top-[50%]  left-[50%] -translate-x-1/2 -translate-y-1/2  w-[65%] ">

                        <Swiper  loop :modules="[Navigation]" navigation class="h-[90vh]">
                            <SwiperSlide v-for="i in item.image" :key="i">
                                <img :src="`${imageApi}/${i.image}`" class="object-cover h-full w-full" alt="">
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