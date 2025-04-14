<script setup>
import ButtonLink from '@/components/ButtonLink.vue'
import MapView from '@/components/MapView.vue'
import { useMapStore } from '@/stores/map'
import { ref, onMounted } from 'vue'
import {storeToRefs} from 'pinia'
import axios from 'axios'
import {useRouter} from 'vue-router'
import ItemCard from '@/components/ItemCard.vue';
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
// https://maps.googleapis.com/maps/api/geocode/json?latlng=LATITUDE,LONGITUDE&key=YOUR_API_KEY

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
    <section class="min-h-[90vh] bg-white px-[2%] lg:px-[12%] py-16">
        <div class="flex justify-center items-center flex-col gap-6 w-full">
            <div class="flex justify-center items-center flex-col gap-4 ">
                <h1 class="text-3xl"><span class="font-semibold text-center">Find house rentals</span><span class="font"> in
                        Mizoram</span>
                </h1>
                <!-- SEARCH BAR -->
                
                <div class="flex items-center border-2 rounded-lg border-accent bg-accen   sm:w-[500px] lg:w-[600px]">
                    <i class="bx bxs-map text-accent text-2xl px-2"></i>
                    <input v-model="searchLoc" type="search"  id="autocomplete" ref="autocompleteInput" name="" placeholder="Search Location"
                        class="w-36 py-3  px-2 flex-1 outline-none">
                    <ButtonLink content="Search" extraStyle=" h-12 rounded-r-md rounded-l-none px-4"
                        icon="bx bx-search text-lg" />
                </div>
            </div>


            <!-- MAP -->
            <!-- <div class="bg-gray-200 w-full h-[50vh] rounded-xl">
                <button @click="detect()">LOCATION</button>
            </div> -->
            <div class="w-full h-[50vh]">
                <MapView />
            </div>


            <!-- <div class="flex flex-col items-center mt-20">
                <h1 class="text-3xl"><span class="font-semibold text-center">Find house rentals</span><span class="font"> in
                        Mizoram</span>
                </h1>
                <div
                    class="py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                    <ItemCard />
                </div>
                <div class="flex items-center justify-center ">

                    <ButtonLink content="Load More" :isLink="false" />

                </div>
            </div> -->

        </div>

    </section>
</template>
<style>
h3 {
    color: #d30303;
}
</style>
