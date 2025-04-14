<script setup>
import Logo from '@/components/Logo.vue'
import { useUtilStore } from '@/stores/util';
import {storeToRefs} from 'pinia'
const {isBrowsePage} = storeToRefs(useUtilStore())
</script>
<template>
   <footer class="min-h-[30vh] py-8 px-[2%] flex flex-col  bg-bg" v-if="!isBrowsePage">
      <div class="flex gap-2 items-center">
         <Logo />
         <span>&copy;2025</span>
      </div>

   </footer>
</template>
<style scoped>
 a{
   color: #f5f5f5
 }
</style>