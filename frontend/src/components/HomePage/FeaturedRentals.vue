<script setup>
import ItemCard from '@/components/ItemCard.vue';
import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    <!-- FEATURED RENTALS -->
    <div class="flex flex-col gap-4 py-10 border-b-2 border-gray-300">
        <h1 class="text-3xl font-semibold text-center">Featured <span class="text-accent">Rentals</span></h1>

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 md:px-18 lg:px-24">
            <ItemCard />


        </div>
        <div class="flex items-center justify-center min-h-20">
            <ButtonLink content="More Rentals" icon="bx bx-right-arrow-alt text-xl" link="/browse"
                extraStyle="bg-white border-2 border-gray-400 hover:bg-accent hover:border-none hover:text-white" />
        </div>

    </div>
</template>