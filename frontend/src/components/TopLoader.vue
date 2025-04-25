<script setup>
import { ref, onMounted } from 'vue';
import { useUtilStore } from '@/stores/util';
import {storeToRefs} from 'pinia'

const {startLoading, finishLoading} = useUtilStore()
const {isVisible, width} = storeToRefs(useUtilStore())
// const width = ref(0);
// const isVisible = ref(false);
// let interval = null;

// const startLoading = () => {
//     isVisible.value = true;
//     width.value = 0;

    
//     interval = setInterval(() => {
//         if (width.value < 80) {
//             width.value += Math.random() * 5; 
//         }
//     }, 300); 
// };

// const finishLoading = () => {
//     clearInterval(interval);
//     width.value = 100;

    
//     setTimeout(() => {
//         isVisible.value = false;
//         width.value = 0;
//     }, 300); 
// };


// onMounted(() => {
//     startLoading();

    
//     setTimeout(() => {
//         finishLoading();
//     }, 3000); 
// });
</script>

<template>
    <div v-if="isVisible" class="bg-accent h-1 fixed top-0 left-0 z-50 transition-all duration-300"
        :style="{ width: `${width}%` }"></div>
        
        
</template>
