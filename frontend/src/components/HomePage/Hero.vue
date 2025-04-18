<script setup>

import { useMapStore } from '@/stores/map'
import { ref, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import axios from 'axios'
import { useRouter, } from 'vue-router'


const router = useRouter()
const mapStore = useMapStore()
const mapApi = ref(import.meta.env.VITE_MAP_API)
const { autocompleteInput, autocompleteInstance, markers, searchLoc, location } = storeToRefs(mapStore)
const { loader } = mapStore;
const detect = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            console.log("hello")
            getAddress(position.coords.latitude, position.coords.longitude)

        },
            error => {
                console.log(error.message)
            })
    } else {
        console.log('Your browser does not support geolocation API')
    }

}


const getAddress = async (lat, long) => {
    try {
        const response = await axios.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${long}&key=${mapApi.value}`)
        console.log(response.data.results[0].formatted_address)
        console.log(response.data.results)
    } catch (err) {
        console.log(err)
    }

}

onMounted(async () => {
    const placesLib = await loader.importLibrary('places')

    const { Autocomplete } = placesLib

    if (autocompleteInput.value) {
        autocompleteInstance.value = new Autocomplete(autocompleteInput.value, {
            types: ['geocode'],
            //  componentRestrictions: { country: 'in' },
        })

        autocompleteInstance.value.addListener('place_changed', () => {
            const place = autocompleteInstance.value.getPlace()
            console.log('place: ', place)
            searchLoc.value = place.formatted_address
            if (place.geometry && place.geometry.location) {
                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()
                searchLoc.value = place.formatted_address
                location.value = { lat, lng }
                console.log("LOCATION: ", location.value)
                router.push('/browse')

                // markers.value = [{
                //    position: { lat, lng },
                //    title: place.formatted_address || `Marker at ${lat}, ${lng}`
                // }]
            }
        })
    }
})

</script>
<template>
    <div class="  flex justify-center items-center   flex-col gap-6 py-10 w-full min-h-[30vh]">
        <div class="flex justify-center items-center flex-col gap-2 ">
            <h1 class="text-3xl  text-center"><span class=" ">Find Houses & Shops for Rent across
                    Mizoram </span>
            </h1>
            <h1 class="text-center ">

                <span class="font italic text-gray-500">"Find the right space — for living or for launching — right here
                    in Mizoram."</span>
            </h1>
            <!-- SEARCH BAR -->

            <div class="flex items-center rounded-xl bg-gray-100 w-full  sm:w-[500px] lg:w-[600px]">
                <i class="bx bxs-map text-accent text-2xl px-2"></i>
                <input v-model="searchLoc" type="search" id="autocomplete" ref="autocompleteInput" name=""
                    placeholder="Search Location" class="w-36 py-3  px-2 flex-1 outline-none bg-gray-100 rounded-lg">
                <button class="flex items-center">
                    <i class="bx bx-search p-3 text-xl"></i>

                </button>
            </div>

        </div>




    </div>
</template>