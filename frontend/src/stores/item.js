import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
export const useItemStore = defineStore('item', ()=>{

    const isLoadingItem = ref(false)
    const item = ref({});
    const isOpenSlideshow = ref(false);
    const getItem = async (slug)=>{
        try{
            isLoadingItem.value = true
            const response = await axios.get(`/item/${slug}`)
            item.value  = response.data.data[0]  

        }catch(err){
            console.log(err)
        }finally{
            isLoadingItem.value = false
        }
    }


    return {isLoadingItem, item, isOpenSlideshow, getItem}



})