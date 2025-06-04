<script setup>
import { GoogleMap, Marker } from 'vue3-google-map'
import { onMounted, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useCreatePostStore } from '@/stores/createPost'

const createPost = useCreatePostStore()
const { autocompleteInput, autocompleteInstance, markers, location, address } = storeToRefs(createPost)
const { addMarker, removeMarker, loader, extractAddress } = createPost

const zoom = 15
const api = ref(import.meta.env.VITE_MAP_API)

// ✅ Define Mizoram bounds
const mizoramBounds = {
    north: 24.6,
    south: 21.9,
    east: 93.5,
    west: 91.5,
}

// ✅ Configure map options with restriction
const mapOptions = ref({
    restriction: {
        latLngBounds: mizoramBounds,
        strictBounds: true,
    },
    mapTypeControl: false,
    streetViewControl: false,
})

onMounted(async () => {
    const placesLib = await loader.importLibrary('places')
    const { Autocomplete } = placesLib

    if (autocompleteInput.value) {
        autocompleteInstance.value = new Autocomplete(autocompleteInput.value, {
            types: ['geocode'],
            bounds: new google.maps.LatLngBounds(
                { lat: mizoramBounds.south, lng: mizoramBounds.west },
                { lat: mizoramBounds.north, lng: mizoramBounds.east }
            ),
            strictBounds: true,
            componentRestrictions: { country: 'IN' },
        })

        autocompleteInstance.value.addListener('place_changed', () => {
            const place = autocompleteInstance.value.getPlace()
            console.log("place: ", place)

            if (place.geometry && place.geometry.location) {
                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()

                // ✅ Check if selected place is within Mizoram bounds
                const { north, south, east, west } = mizoramBounds
                if (lat > north || lat < south || lng > east || lng < west) {
                    alert("Please select a location within Mizoram.")
                    return
                }

                location.value = { lat, lng }

                markers.value = [{
                    position: { lat, lng },
                    title: place.formatted_address || `Marker at ${lat}, ${lng}`,
                }]

                extractAddress(place)
            }
        })

        // ✅ Listen for Enter key to trigger place selection
        autocompleteInput.value.addEventListener('keydown', (e) => {
            const suggestionSelected = document.querySelector('.pac-item-selected')
            if (e.key === 'Enter' && !suggestionSelected) {
                e.preventDefault()
                const downArrowEvent = new KeyboardEvent('keydown', {
                    key: 'ArrowDown',
                    code: 'ArrowDown',
                    keyCode: 40,
                    which: 40,
                    bubbles: true
                })
                autocompleteInput.value.dispatchEvent(downArrowEvent)
            }
        })
    }
})
</script>

<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <div>
            <label for="autocomplete" class="block mb-1">
                Location<span class="text-accent">*</span>
            </label>

            <input id="autocomplete" ref="autocompleteInput" type="text" placeholder="Enter address"
                class="input w-full px-4 py-2 border rounded" />
        </div>

        <GoogleMap :api-key="api" style="width:100%; height:50vh;" :center="location" :zoom="zoom" :options="mapOptions"
            @click="addMarker">
            <Marker v-for="(marker, index) in markers" :key="index" :options="marker" @click="removeMarker()" />
        </GoogleMap>
    </div>
</template>
