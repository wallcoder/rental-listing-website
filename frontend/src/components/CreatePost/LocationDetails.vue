<script setup>
    import { GoogleMap, Marker } from 'vue3-google-map'
    import {onMounted, ref} from 'vue'
    import {storeToRefs} from 'pinia'
    import {useCreatePostStore} from '@/stores/createPost'
    const createPost = useCreatePostStore()
    const { autocompleteInput, autocompleteInstance, markers, location, address} = storeToRefs(createPost)
    const {addMarker, removeMarker, loader, extractAddress} = createPost
    const zoom = 15
    const api = ref(import.meta.env.VITE_MAP_API)
    onMounted(async () => {
    const placesLib = await loader.importLibrary('places')
    const { Autocomplete } = placesLib

    if (autocompleteInput.value) {
        autocompleteInstance.value = new Autocomplete(autocompleteInput.value, {
            types: ['geocode'],
            componentRestrictions: { country: 'in' },
        })

        autocompleteInstance.value.addListener('place_changed', () => {
            const place = autocompleteInstance.value.getPlace()
            console.log("place: ", place)
            extractAddress(place)
            if (place.geometry && place.geometry.location) {
                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()

                location.value = { lat, lng }
                
                markers.value = [{
                    position: { lat, lng },
                    title: place.formatted_address || `Marker at ${lat}, ${lng}`
                }]
            }
        })
    }
})
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <div>
            <label for="autocomplete" class="block mb-1">Location<span class="text-accent">*</span></label>
           
            <input id="autocomplete" ref="autocompleteInput" type="text" placeholder="Enter address"
                class="input w-full px-4 py-2 border rounded" />
        </div>

        <GoogleMap :api-key="api" style="width:100%; height:50vh;" :center="location" :zoom="zoom" @click="addMarker">
            <Marker v-for="(marker, index) in markers" :key="index" :options="marker" @click="removeMarker()" />
        </GoogleMap>
    </div>
</template>