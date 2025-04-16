import { defineStore } from "pinia";
import { Loader } from '@googlemaps/js-api-loader'

import { ref } from "vue";
import { push } from 'notivue'

export const useCreatePostStore = defineStore('createPost', ()=>{
    const category  = ref('house')
    const type = ref('concrete')
    const images = ref([])
    const previews = ref([])
    const MAX_FILE_SIZE_MB = 2
    const ALLOWED_TYPES = ['image/jpeg']

    const autocompleteInput = ref(null)
    let autocompleteInstance = ref(null)
    
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
    

    const removePreview = (i) => {
        previews.value.splice(i, 1)
        images.value.splice(i, 1)
    }

    

    const handleImageUpload = (event) => {
        const files = Array.from(event.target.files)
        images.value = []
        previews.value = []
    
        files.forEach(file => {
            if (!ALLOWED_TYPES.includes(file.type)) {
                push.error(`${file.name} is not a JPG file.`)
                return
            }
    
            if (file.size > MAX_FILE_SIZE_MB * 1024 * 1024) {
                push.error(`${file.name} exceeds the ${MAX_FILE_SIZE_MB}MB limit.`)
                return
            }
    
            images.value.push(file)
    
            const reader = new FileReader()
            reader.onload = (e) => {
                previews.value.push(e.target.result)
            }
            reader.readAsDataURL(file)
        })
    }
    
    return {category, type, images, previews, loader, autocompleteInput, autocompleteInstance, markers, location,
         removePreview, handleImageUpload, addMarker, removeMarker}
})