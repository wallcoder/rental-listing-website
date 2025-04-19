import { defineStore } from "pinia";
import { Loader } from '@googlemaps/js-api-loader'

import { ref } from "vue";
import { push } from 'notivue'

export const useCreatePostStore = defineStore('createPost', ()=>{
    const category  = ref('house')
    const type = ref('concrete')
    const images = ref([])
    const thumbnail = ref(null)
    const thumbnailPreview = ref(null)
    const previews = ref([])
    const MAX_FILE_SIZE_MB = 2
    const ALLOWED_TYPES = ['image/jpeg']
    const houseDetails = ref({
        area: null,
        bathroom: null,
        bedroom: null,
        balcony: 'no',
        parking: 'no',
        furnished: 'no',
        price: null,
        description: ''
    })

    const shopDetails = ref({
        price: null,
        area: null,
        floor: 'Ground Floor',
        electricity: 'no',
        water: 'no',
        bathroom: 'no',
        description: ''

    })

    const contactDetails = ref({
        phone: '',
        email: '',
        owner: ''
    })

    const address = ref({
        street: '',
        locality: '',
        city: '',
        state: '',
        pincode: '',
        country: ''
    })

    const extractAddress = (place) => {

        address.value = {
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
            address.value.locality = component.long_name
          }
      
          if (types.includes('locality')) {
            address.value.city = component.long_name
          }
      
          if (types.includes('administrative_area_level_1')) {
            address.value.state = component.long_name
          }
      
          if (types.includes('postal_code')) {
            address.value.pincode = component.long_name
          }
      
          if (types.includes('country')) {
            address.value.country = component.long_name
          }
        })
      
        
        address.value.street = [streetNumber, route].filter(Boolean).join(' ')
      }

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
                console.log("clicked: ", results[0])
                extractAddress(results[0])
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
    const removeThumbnailPreview = ()=>{
        thumbnail.value = null
        thumbnailPreview.value = null
    }
    

    const handleThumbnailUpload = (event) => {
        const file = event.target.files[0]
        thumbnail.value = null
        thumbnailPreview.value = null
    
        if (!file) return
    
        if (!ALLOWED_TYPES.includes(file.type)) {
            push.error(`${file.name} is not a JPG file.`)
            return
        }
    
        if (file.size > MAX_FILE_SIZE_MB * 1024 * 1024) {
            push.error(`${file.name} exceeds the ${MAX_FILE_SIZE_MB}MB limit.`)
            return
        }
    
        thumbnail.value = file
    
        const reader = new FileReader()
        reader.onload = (e) => {
            thumbnailPreview.value = e.target.result
        }
        reader.readAsDataURL(file)
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

    const submit = async () => {
        try {
            const formData = new FormData()
    
            formData.append('category', category.value)
            formData.append('type', type.value)
    
            
            if (thumbnail.value) {
                formData.append('thumbnail', thumbnail.value)
            } else {
                push.error('Please select a thumbnail.')
                return
            }
    
            
            if (images.value.length === 0) {
                push.error('Please upload at least one image.')
                return
            }
    
            images.value.forEach((img, i) => {
                formData.append(`images[${i}]`, img)
            })
    
            
            if (category.value === 'house') {
                Object.entries(houseDetails.value).forEach(([key, val]) => {
                    formData.append(`houseDetails[${key}]`, val ?? '')
                })
            } else if (category.value === 'shop') {
                Object.entries(shopDetails.value).forEach(([key, val]) => {
                    formData.append(`shopDetails[${key}]`, val ?? '')
                })
            }
    
            
            Object.entries(contactDetails.value).forEach(([key, val]) => {
                formData.append(`contactDetails[${key}]`, val ?? '')
            })
    
          
            Object.entries(address.value).forEach(([key, val]) => {
                formData.append(`address[${key}]`, val ?? '')
            })
    
           
            formData.append('location[lat]', location.value.lat)
            formData.append('location[lng]', location.value.lng)
    
            console.log(" FormData contents:");
        for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            const response = await fetch('https://your-api-url.com/api/posts', {
                method: 'POST',
                body: formData
            })
    
            if (!response.ok) {
                const errorData = await response.json()
                push.error(errorData.message || 'Failed to submit post.')
                return
            }
    
            push.success('Post submitted successfully.')
        } catch (error) {
            console.error('Submission Error:', error)
            push.error('Something went wrong while submitting.')
        }
    }
    
    
    return {category, type, images, previews, loader, autocompleteInput, autocompleteInstance, markers, location, houseDetails, contactDetails, 
        shopDetails, address, thumbnail, thumbnailPreview,submit,
         removePreview, handleImageUpload, addMarker, removeMarker, extractAddress, removeThumbnailPreview, handleThumbnailUpload}
})