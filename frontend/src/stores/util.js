import { defineStore } from "pinia";
import { ref } from "vue";

export const useUtilStore = defineStore('util',()=>{
    

    // progress loader
    const width = ref(0);
    const isVisible = ref(false);
    let interval = null;
    const isOpen = ref(true);

    const startLoading = () => {
       
        isVisible.value = true;
        width.value = 0;

    
        interval = setInterval(() => {
            if (width.value < 80) {
                width.value += Math.random() * 5; 
            }
        }, 300); 
    };

    const finishLoading = () => {
        clearInterval(interval);
        width.value = 100;

    
        setTimeout(() => {
            isVisible.value = false;
            width.value = 0;
        }, 300); 
    };

    const isOpenFilterSidebar = ref(false);
    const isBrowsePage = ref(false);
    const toggleFilterSidebar = ()=>{
        isOpenFilterSidebar.value = !isOpenFilterSidebar.value
    }
    return {isOpenFilterSidebar, startLoading, finishLoading, isOpen, isVisible, width, isBrowsePage, toggleFilterSidebar}
})