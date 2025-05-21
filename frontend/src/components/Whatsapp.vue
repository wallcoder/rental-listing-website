<script setup>

    import {ref} from 'vue'
    import {storeToRefs} from 'pinia'
    import { useUtilStore } from '@/stores/util';

    const {isOpen} = storeToRefs(useUtilStore())



</script>
<template>
    <div class="fixed bottom-4 right-7 z-20 flex items-center opacity-70 gap-2 hover:opacity-100" >
        <div class="bg-gray-100 rounded-lg flex flex-col p-2" v-if="isOpen">
            <div class="w-full flex cursor-pointer justify-start"><i class="bx bx-x text-lg" @click="isOpen=false"></i></div>
            <p class="p-2">Hi, how can we help you?</p>
        </div>
        
        <a href="https://wa.me/917628063215?text=Hello%2C%20I%27d%20like%20to%20know%20more!" target="_blank" class=" bg-accent rounded-full p-1 w-12 h-12 flex items-center cursor-pointer justify-center">
            <i class='bx bxl-whatsapp text-4xl text-white'></i>
        </a>

    </div>
</template>