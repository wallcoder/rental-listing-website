import { defineStore } from "pinia";
import {ref} from 'vue'
import axios from 'axios'
import { storeToRefs } from "pinia";
import { useAuthStore } from "./auth";
import { push } from "notivue";
import { useMapStore } from "./map";
export const usePostStore = defineStore('store', ()=>{
    const {isLoggedin, user} = storeToRefs(useAuthStore())
    const {searchAddress} = storeToRefs(useMapStore());
    const isLoading = ref(false)
    const isLoadingBrowse = ref(false);
    const saves  = ref(null)
    const rentals = ref(null)
    const featuredRentals = ref([]);

    const getFeaturedRentals = async (force=false) => {
    try {
        if(featuredRentals.value.length > 0 && !force){
            console.log("not refetch")
            return
        }
        isLoading.value = true;
        const response = await axios.get('/posts?loc=&pag=8');
        featuredRentals.value = response.data.data.data;


    } catch (err) {
        console.log(err.response.data)

    } finally {
        isLoading.value = false
    }
}

    const getRentals = async (street, locality, city, state, pincode, country, page = 1) => {
    try {
        isLoadingBrowse.value = true;
        const response = await axios.get(`/browse?street=${street}&locality=${locality}&city=${city}&state=${state}&pincode=${pincode}&country=${country}&page=${page}`);
        rentals.value = response.data.data;
        console.log("LISTING: ", rentals.value)
    } catch (e) {
        console.log("error: ", e);
    } finally {
        isLoadingBrowse.value = false;
    }
};



    const getSaved = async()=>{

        try{
            isLoading.value = true;
            if(!isLoggedin && !user){
                console.log("NOTTOTOT")
                return
            }

            const response = await axios.get('/saves')
            saves.value = response.data.data
            console.log("SAVES: ", saves.value)
        }catch(e){
            console.log(e.response.data)
            
        }finally{
            isLoading.value = false
        }
    }

    const savePost = async(id)=>{
        try{
            const response = await axios.post(`/save/create/${id}`)

            push.success(response.data.message)
        }catch(err){
            console.log(err.response.data)
        }

    }

return {isLoading, featuredRentals, getFeaturedRentals, getSaved, saves, savePost, getRentals, isLoadingBrowse, rentals}


})