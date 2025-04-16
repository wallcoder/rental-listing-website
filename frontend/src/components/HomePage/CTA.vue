<script setup>
import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
<div class="flex items-center justify-center py-10 ">
            <div class="flex flex-col gap-4  p-8 lg:px-32 rounded-xl items-center bg-gray-100 ">
                <h1 class="text-3xl font-semibold text-center ">Have a Property to <span class="text-accent">Rent?</span>
                </h1>

                <p class=" text-center">List your house or shop and reach thousands across Mizoram.</p>


                <ButtonLink content="Add Your Property" icon="bx bx-right-arrow-alt text-xl" link="/create-post"
                    extraStyle="" />
            </div>

        </div>
</template>