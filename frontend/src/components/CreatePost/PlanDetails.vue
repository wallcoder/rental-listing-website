<script setup>
    import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    <div class="border-2 border-accent rounded-lg bg-white p-4 flex flex-col gap-2 mt-6">
        <span class="flex items-center gap-1">
            <i class='bx bx-circle text-accent text-xl pt-1'></i>
            <h1 class="text-lg font-semibold p-2 bg-green-100 rounded-2xl px-3">₹50/Post</h1>
        </span>
        <span class="flex items-center">
            <i class='bx bx-check text-2xl text-accent'></i>
            <span>List Your Property - Only ₹50</span>
        </span>
        <span class="flex items-center">
            <i class='bx bx-check text-2xl text-accent'></i>
            <span>Post stays active for 30 full days</span>
        </span>
        <span class="flex items-center">
            <i class='bx bx-check text-2xl text-accent'></i>
            <span>Reach a wide local audience instantly</span>
        </span>
        <ButtonLink content="Create Post" extraStyle="w-32" :isLink="false" />
    </div>
</template>