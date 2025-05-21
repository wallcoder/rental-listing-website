import { defineStore } from "pinia";
import { ref } from 'vue'
import axios from 'axios'
import { storeToRefs } from "pinia";
import { useAuthStore } from "./auth";
import { push } from "notivue";
import { useMapStore } from "./map";
export const usePostStore = defineStore('store', () => {
    const { isLoggedin, user } = storeToRefs(useAuthStore())
    const { searchAddress } = storeToRefs(useMapStore());
    const isLoading = ref(false)
    const isLoadingBrowse = ref(false);
    const saves = ref(null)
    const rentals = ref(null)
    const featuredRentals = ref([]);
    let lastRequest = null;
    const filter = ref({
        sort: 'latest',
        category: '',
        type: '',
        minPrice: '0',
        maxPrice: '100000',
        minArea: '0',
        maxArea: '100000',
        minBed: '0',
        maxBed: '6',
        minBath: '0',
        maxBath: '6',
    })

    const resetFilter = () => {
        filter.value = {
            sort: 'latest',
            category: '',
            type: '',
            minPrice: '0',
            maxPrice: '100000',
            minArea: '0',
            maxArea: '100000',
            minBed: '0',
            maxBed: '6',
            minBath: '0',
            maxBath: '6',

        }
    }

    const getFeaturedRentals = async (force = false,) => {
        try {
            if (featuredRentals.value.length > 0 && !force) {
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

    const getRentals = async (street, locality, city, state, pincode, country, page = 1, limit = 20) => {
        const currentRequest = {
            street, locality, city, state, pincode, country, page, limit,
            sort: filter.value.sort,
            category: filter.value.category,
            type: filter.value.type,
            minPrice: filter.value.minPrice,
            maxPrice: filter.value.maxPrice,
            minArea: filter.value.minArea,
            maxArea: filter.value.maxArea,
            minBed: filter.value.minBed,
            maxBed: filter.value.maxBed,
            minBath: filter.value.minBath,
            maxBath: filter.value.maxBath,
        };

        
        if (JSON.stringify(currentRequest) === JSON.stringify(lastRequest)) {
            console.log("Skipping fetch: same request");
            return;
        }

        lastRequest = currentRequest;
        resetFilter()
        try {
            isLoadingBrowse.value = true;
            const response = await axios.get('/browse', { params: currentRequest });
            rentals.value = response.data.data;
            console.log("LISTING: ", rentals.value);
        } catch (e) {
            console.log("error: ", e);
        } finally {
            isLoadingBrowse.value = false;
        }
    };




    const getSaved = async () => {

        try {
            isLoading.value = true;
            if (!isLoggedin && !user) {
                console.log("NOTTOTOT")
                return
            }

            const response = await axios.get('/saves')
            saves.value = response.data.data
            console.log("SAVES: ", saves.value)
        } catch (e) {
            console.log(e.response.data)

        } finally {
            isLoading.value = false
        }
    }

    const savePost = async (id) => {
        try {
            const response = await axios.post(`/save/create/${id}`)

            push.success(response.data.message)
        } catch (err) {
            console.log(err.response.data)
        }

    }

    return { isLoading, filter, featuredRentals, getFeaturedRentals, getSaved, saves, savePost, getRentals, resetFilter, isLoadingBrowse, rentals }


})