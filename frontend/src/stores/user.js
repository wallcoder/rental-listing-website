import { createSharedComposable } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { push } from 'notivue'


export const useUserStore = defineStore('user', () => {

    const savedListings = ref([])
    const isLoadingSavedListings = ref(false)
    const isLoadingUserPosts = ref(false)
    const userPosts = ref([])
    const userTransactions = ref([])
    const isLoadingUserTransactions = ref(false)
    const userPlans = ref([])
    const isLoadingUserPlans = ref(false)
    const getUserPosts = async (refresh=false) => {
        try {
            if(userPosts.value.length > 0 && !refresh){
                return
            }
            isLoadingUserPosts.value = true
            const response = await axios.get('/user/posts')
            userPosts.value = response.data.data
        } catch (err) {
            console.log(err)

        } finally {
            isLoadingUserPosts.value = false
        }
    }

    const getSavedListings = async () => {
        try {
            if(savedListings.value.length > 0){
                return
            }

            isLoadingSavedListings.value = true
            const response = await axios.get('/saves/listings')
            savedListings.value = response.data.data
        } catch (err) {
            console.log(err)

        } finally {
            isLoadingSavedListings.value = false
        }
    }


    const saveListing = async(id)=>{
        try{
            
            const response = await axios.post(`/save/create/${id}`)
            push.success(response.data.message)
            getSavedListings()

        }catch(err){
            console.log(err)
        }
    }


    const getUserTransactions = async()=>{
        try{
            isLoadingUserTransactions.value = true
            const response = await axios.get('/user/payments')

            userTransactions.value = response.data.data
        }catch(err){
            console.log(err)
        }finally{
            isLoadingUserTransactions.value = false
        }
    }

     const getUserPlans = async()=>{
        try{
            isLoadingUserPlans.value = true
            const response = await axios.get('/user/plans')

            userPlans.value = response.data.data
            console.log("res: ", )
        }catch(err){
            console.log(err)
        }finally{
            isLoadingUserPlans.value = false
        }
    }





    return {
        savedListings, isLoadingSavedListings, userPosts, isLoadingUserPosts, userTransactions, isLoadingUserTransactions,
        userPlans, isLoadingUserPlans,
        getSavedListings, saveListing,  getUserPosts, getUserTransactions, getUserPlans


    }

})
