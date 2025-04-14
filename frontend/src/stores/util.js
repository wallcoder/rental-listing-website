import { defineStore } from "pinia";
import { ref } from "vue";

export const useUtilStore = defineStore('util',()=>{
    const isOpenFilterSidebar = ref(false);
    const isBrowsePage = ref(false);
    const toggleFilterSidebar = ()=>{
        isOpenFilterSidebar.value = !isOpenFilterSidebar.value
    }
    return {isOpenFilterSidebar, isBrowsePage, toggleFilterSidebar}
})