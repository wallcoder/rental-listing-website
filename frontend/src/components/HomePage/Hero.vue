<script setup>
import { useMapStore } from '@/stores/map'
import { ref, onMounted, watch } from 'vue'
import { storeToRefs } from 'pinia'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const mapStore = useMapStore()
const mapApi = ref(import.meta.env.VITE_MAP_API)

const { autocompleteInput, autocompleteInstance, searchLoc, location, autocompleteService,  mizoramBounds, placesService, predictions, searchAddress
} = storeToRefs(mapStore)
const { loader, onEnterSearch, extractSearchAddress } = mapStore;




watch(searchLoc, async (val) => {
    if (val && autocompleteService) {
        autocompleteService.value.getPlacePredictions({
            input: val,
            componentRestrictions: { country: 'IN' },
            bounds: mizoramBounds.value,
            strictBounds: true,
        }, (preds, status) => {
            if (status === 'OK' && preds?.length) {
                predictions.value = preds
            }
        })
    }
})




onMounted(async () => {
    const placesLib = await loader.importLibrary('places')
    const { AutocompleteService, PlacesService } = placesLib

    autocompleteService.value = new AutocompleteService()

    if (autocompleteInput.value) {
        autocompleteInstance.value = new window.google.maps.places.Autocomplete(autocompleteInput.value, {
            types: ['geocode'],
            componentRestrictions: { country: 'IN' },
            bounds: mizoramBounds.value,
            strictBounds: true
        })

        const mapDiv = document.createElement('div') // dummy div for PlacesService
        placesService.value = new PlacesService(mapDiv)

        autocompleteInstance.value.addListener('place_changed', () => {
            const place = autocompleteInstance.value.getPlace()
            if (place.geometry && place.geometry.location) {
                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()
                location.value = { lat, lng }
                searchLoc.value = place.formatted_address
                extractSearchAddress(place)
                console.log(searchAddress.value)
                router.push(`/browse?street=${searchAddress.value.street}&locality=${searchAddress.value.locality}&city=${searchAddress.value.city}&state=${searchAddress.value.state}&pincode=${searchAddress.value.pincode}&country=${searchAddress.value.country}`)
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
                <input v-model="searchLoc" type="search" id="autocomplete" ref="autocompleteInput"
                    placeholder="Search Location" class="w-36 py-3 px-2 flex-1 outline-none bg-gray-100 rounded-lg"
                    @keyup.enter="onEnterSearch" />
                <button class="flex items-center">
                    <i class="bx bx-search p-3 text-xl" @click="onEnterSearch()"></i>

                </button>
            </div>

        </div>




    </div>
</template>