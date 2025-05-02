<script setup>
import { ref } from 'vue'

const why = ref([
    {
        heading: 'Built for Mizoram',
        description: 'We understand the local needs — every listing is from your neighborhood, not some far-off city.',
        icon: 'bxs-tree'
    },
    {
        heading: 'No Middlemen, No Extra Fees',
        description: 'Connect directly with property owners. Transparent, simple, and commission-free.',
        icon: 'bxs-tree'
    },
    {
        heading: 'Fast & Easy Experience',
        description: 'Clean design, instant filters, and quick contact options make finding your next space effortless.',
        icon: 'bxs-tree'
    }


])
</script>
<template>
    <!-- FEATURED RENTALS -->
    <div class="flex flex-col gap-8 py-10 border-gray-300">
        <h1 class="text-3xl font-semibold text-center " v-motion-fade-visible-once >Why Use Our <span class="text-accent">Platform?</span></h1>

        <div class="w-full  grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 md:px-18 lg:px-24">
            <div v-motion-fade-visible-once class="bg-gray-100 relative rounded-lg p-6 flex flex-col gap-2" v-for="(n, i) of why" :key="i">
                <div class="rounded-full ">
                    <i :class="n.icon" class='bx  bg-white p-2 text-3xl shadow-lg text-green-500 rounded-full'></i>
                </div>
                <h2 class="text-md font-semibold">{{ n.heading }}</h2>
                <p class="text-gray-700 text-sm">
                    {{ n.description }}

                </p>
                <div class="text-8xl cursor-default font-semibold text-white absolute -top-8 right-3 ">
                    0{{ i + 1 }}
                </div>
            </div>


        </div>



    </div>
</template>