<script setup>
import Logo from '@/components/Logo.vue'
import { useUtilStore } from '@/stores/util';
import { storeToRefs } from 'pinia'
import { RouterLink } from 'vue-router'
const { isBrowsePage } = storeToRefs(useUtilStore())
</script>
<template>
   <footer class="min-h-[30vh] py-8 px-[4%] lg:px-[8%] flex   bg-bg" v-if="!isBrowsePage">
      <div class="flex gap-2 flex-col">
         <Logo />

         <span class="text-sm text-gray-600 ">&copy;2025</span>
         <div class="flex gap-4 items-center text-gray-600">
            <RouterLink to="sad" class="text-sm hover:underline">Terms of Service</RouterLink>
            
            <RouterLink to="sad" class="text-sm hover:underline">Privacy Policy</RouterLink>
            <span></span>

         </div>

      </div>


   </footer>
</template>
<style scoped>

</style>