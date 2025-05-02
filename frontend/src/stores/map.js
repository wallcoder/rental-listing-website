// stores/mapStore.js
import { defineStore } from 'pinia'
import { ref, onMounted, watch } from 'vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'
import { useRouter } from 'vue-router'
import { push } from 'notivue'
export const useMapStore = defineStore('map', () => {
 
    
// Search
const predictions = ref([]) 
const autocompleteService = ref(null)
const placesService = ref(null)
const router = useRouter()
const mizoramBounds = ref({
    north: 24.6,
    south: 21.9,
    east: 93.5,
    west: 91.5,
})

const searchAddress = ref({
    street: '',
        locality: '',
        city: '',
        state: '',
        pincode: '',
        country: ''
})

// Fetch predictions when searchLoc changes



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


const extractSearchAddress = async (place) => {

    searchAddress.value = {
        street: '',
        locality: '',
        city: '',
        state: '',
        pincode: '',
        country: ''
    }
    if (!place.address_components){
        console.log("NOOO")
        return}
  
    let streetNumber = ''
    let route = ''
  
    place.address_components.forEach(component => {
      const types = component.types
  
      if (types.includes('street_number')) {
        streetNumber = component.long_name
      }
  
      if (types.includes('route')) {
        route = component.long_name
      }
  
      if (types.includes('sublocality') || types.includes('sublocality_level_1')) {
        searchAddress.value.locality = component.long_name
      }
  
      if (types.includes('locality')) {
        searchAddress.value.city = component.long_name
      }
  
      if (types.includes('administrative_area_level_1')) {
        searchAddress.value.state = component.long_name
      }
  
      if (types.includes('postal_code')) {
        searchAddress.value.pincode = component.long_name
      }
  
      if (types.includes('country')) {
        searchAddress.value.country = component.long_name
      }
    })
  
    
    searchAddress.value.street = [streetNumber, route].filter(Boolean).join(' ')
  }
const onEnterSearch = async () => {
    
    if (predictions.value.length > 0 && placesService) {
        const placeId = predictions.value[0].place_id
        placesService.value.getDetails({ placeId }, (place, status) => {
            if (status === 'OK' && place.geometry) {
                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()
                location.value = { lat, lng }
                searchLoc.value = place.formatted_address
                extractSearchAddress(place)
                router.push(`/browse?street=${searchAddress.value.street}&locality=${searchAddress.value.locality}&city=${searchAddress.value.city}&state=${searchAddress.value.state}&pincode=${searchAddress.value.pincode}&country=${searchAddress.value.country}`)
            }
        })
    }
}
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
    autocompleteInput, searchLoc, autocompleteInstance, zoom, api, markers, location, userDragged, predictions, autocompleteService, placesService, mizoramBounds, searchAddress,
    extractSearchAddress,
    loader, removeMarker, addMarker, onEnterSearch
   
  }
})
