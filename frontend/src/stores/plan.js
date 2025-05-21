import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
export const usePlanStore = defineStore('plan', ()=>{
    const plans = ref([])
    const isLoadingPlans = ref(false)
    const getPlans = async ()=>{
        try{
            isLoadingPlans.value = true
            const response = await axios.get('/plans');
            plans.value = response.data.data

        }catch(err){
            console.log(err)
        }finally{
            isLoadingPlans.value = false;
        }
    }

    return {
        plans, isLoadingPlans,

        getPlans
    }


})
