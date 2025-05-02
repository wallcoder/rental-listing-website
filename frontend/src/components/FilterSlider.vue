<script setup>
import FilterContent from '@/components/FilterContent.vue';
import { useUtilStore } from '@/stores/util';
import { storeToRefs } from 'pinia';
import {ref} from 'vue'
const util = useUtilStore();
const { isOpenFilterSidebar } = storeToRefs(util);
const { toggleFilterSidebar } = util;

const scrollValue = ref(null);
window.addEventListener('scroll', ()=>{
    scrollValue.value = window.scrollY;
}
)
</script>
<template>
    <div class=" ">
        
        <div class="fixed  z-10 cursor-pointer md:hidden left-2 " :class="scrollValue >= 100 ? 'top-2':'top-20'" @click="toggleFilterSidebar()">
            
            <i class='bx bx-filter text-3xl bg-accent rounded-full p-2 opacity-60 hover:opacity-100 text-white'></i>
        </div>
        <section :class="isOpenFilterSidebar ? 'translate-x-0':'-translate-x-80'"
            class="transition-all duration-250 ease-in-out border-r w-[220px] p-4 flex flex-col gap-6 overflow-y-auto text-sm py-6 h-[100vh] fixed z-20 bg-white md:hidden top-0 ">
            <FilterContent />


        </section>
    </div>
</template>
<style scoped></style>