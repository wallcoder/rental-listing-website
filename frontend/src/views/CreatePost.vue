<script setup>
import { ref, onMounted } from 'vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { push } from 'notivue'
import {storeToRefs} from 'pinia'
import PropertyInformation from '@/components/CreatePost/PropertyInformation.vue'
import GalleryImages from '@/components/CreatePost/GalleryImages.vue'
import HouseDetails from '@/components/CreatePost/HouseDetails.vue'
import ShopDetails from '@/components/CreatePost/ShopDetails.vue'
import ContactDetails from '@/components/CreatePost/ContactDetails.vue'
import LocationDetails from '@/components/CreatePost/LocationDetails.vue'
import PlanDetails from '@/components/CreatePost/PlanDetails.vue'
import {useCreatePostStore} from '@/stores/createPost'

const createPost = useCreatePostStore()

const autocompleteInput = ref(null)
let autocompleteInstance = null
const zoom = 15

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


onMounted(async () => {
    const placesLib = await loader.importLibrary('places')
    const { Autocomplete } = placesLib

    if (autocompleteInput.value) {
        autocompleteInstance = new Autocomplete(autocompleteInput.value, {
            types: ['geocode'],
            componentRestrictions: { country: 'in' },
        })

        autocompleteInstance.addListener('place_changed', () => {
            const place = autocompleteInstance.getPlace()

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
    <section class="items-center justify-center px-[2%] lg:px-[16%] py-10 flex gap-4">
        <form class="flex flex-col gap-2 w-full">
            <h1 class="text-2xl">Create a Post</h1>
 
            <PropertyInformation />
            <GalleryImages />
            <HouseDetails />
            <ShopDetails />
            <ContactDetails />
            <LocationDetails />
            <PlanDetails />



            

           

           
          


           

            <!-- <div class="border-2 border-accent rounded-lg bg-white p-4 flex flex-col gap-2 mt-6">
                <span class="flex items-center gap-1">
                    <i class='bx bx-circle text-accent text-xl pt-1'></i>
                    <h1 class="text-lg font-semibold p-2 bg-green-100 rounded-2xl px-3">₹50/Post</h1>
                </span>
                <span class="flex items-center">
                    <i class='bx bx-check text-2xl text-accent'></i>
                    <span>List Your Property - Only ₹50</span>
                </span>
                <span class="flex items-center">
                    <i class='bx bx-check text-2xl text-accent'></i>
                    <span>Post stays active for 30 full days</span>
                </span>
                <span class="flex items-center">
                    <i class='bx bx-check text-2xl text-accent'></i>
                    <span>Reach a wide local audience instantly</span>
                </span>
                <ButtonLink content="Create Post" extraStyle="w-32" :isLink="false" />
            </div> -->
        </form>
    </section>
</template>

  
<style scoped></style>