<script setup>
import { ref } from 'vue'
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { RouterLink } from 'vue-router';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
</script>
<template>
    <section class="px-[2%]">
        <div class="py-8 w-[500px]">
            <Swiper :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="1" :loop="true" class=""
                :hideOnClick=true :navigation="false" :pagination="{ clickable: true }" :type="progressbar">
                <SwiperSlide>
                    <img class=" w-full object-cover "
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>
                <SwiperSlide>
                    <img class=" w-full object-cover "
                        src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                        alt="House Image">
                </SwiperSlide>
               

            </Swiper>
        </div>
    </section>
</template>
<style scoped></style>