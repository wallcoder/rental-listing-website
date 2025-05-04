<script setup>

import Hero from '@/components/HomePage/Hero.vue'
import PopularAreas from '@/components/HomePage/PopularAreas.vue'
import FeaturedRentals from '@/components/HomePage/FeaturedRentals.vue'
import WhyChooseUs from '@/components/HomePage/WhyChooseUs.vue'
import Whatsapp from '@/components/Whatsapp.vue'
import CTA from '@/components/HomePage/CTA.vue'
import {onMounted, ref} from 'vue'
import { push } from "notivue";

onMounted(()=>{
    const message = localStorage.getItem('message')
    if(message){
        push.success(message)
        localStorage.removeItem('message')
    }
})


</script>
<template>
    <section class=" bg-white px-[4%] lg:px-[8%] py-6 ">
        <Hero />
        <PopularAreas />
        <FeaturedRentals />
        <WhyChooseUs />
        <CTA />
        <Whatsapp />
    </section>
</template>
<style></style>
