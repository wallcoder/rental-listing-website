// stores/mapStore.js
import { defineStore } from 'pinia'
import { ref, onMounted } from 'vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'

import { push } from 'notivue'
export const useMapStore = defineStore('map', () => {
  
const autocompleteInput = ref(null)

let autocompleteInstance = ref(null)
const userDragged = ref(false)
const zoom = 15
const searchLoc = ref('')
const api = ref(import.meta.env.VITE_MAP_API)

const markers = ref([])


const location = ref({
    lat: 40.689247,
    lng: -74.044502
})

const loader = new Loader({
    apiKey: import.meta.env.VITE_MAP_API,
    version: 'weekly',
    libraries: ['places', 'geocoding']
})




const removeMarker = () => {
    markers.value = []
}
const addMarker = async (event) => {
    const latLng = event.latLng
    const lat = latLng.lat()
    const lng = latLng.lng()
   
    location.value = { lat, lng }
    markers.value = [{
        position: { lat, lng },
        title: `Marker at ${lat}, ${lng}`
    }]

    const geocoderLib = await loader.importLibrary('geocoding')
    const geocoder = new geocoderLib.Geocoder()

    geocoder.geocode({ location: { lat, lng } }, (results, status) => {
        if (status === 'OK' && results[0]) {
            const formattedAddress = results[0].formatted_address
            if (autocompleteInput.value) {
                autocompleteInput.value.value = formattedAddress
            }
        } else {
            push.error('Unable to fetch address for this location.')
        }
    })
}



  return {
    autocompleteInput, searchLoc, autocompleteInstance, zoom, api, markers, location, userDragged,
    loader, removeMarker, addMarker
   
  }
})
