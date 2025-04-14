<script setup>
import { ref, onMounted } from 'vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { push } from 'notivue'

const autocompleteInput = ref(null)
let autocompleteInstance = null
const zoom = 15
const MAX_FILE_SIZE_MB = 2
const ALLOWED_TYPES = ['image/jpeg']
const api = ref(import.meta.env.VITE_MAP_API)
const images = ref([])
const previews = ref([])
const markers = ref([])
const category = ref("house");
const type = ref("concrete");

const location = ref({
    lat: 40.689247,
    lng: -74.044502
})

const loader = new Loader({
    apiKey: import.meta.env.VITE_MAP_API,
    version: 'weekly',
    libraries: ['places', 'geocoding']
})

const removePreview = (i) => {
    previews.value.splice(i, 1)
    images.value.splice(i, 1)
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
        <div class="flex flex-col gap-2 w-full">
            <h1 class="text-2xl">Create a Post</h1>
            <div class="rounded-xl bg-white p-4 flex flex-col gap-2">
                <h2 class="text-xl">Property Information</h2>
                <div class="flex flex-col">
                    <h2 class="mb-1">Category</h2>
                    <div class="flex gap-1">
                        <div class="flex flex-col">
                            <label for="house" :class="category === 'house' ? 'bg-accent text-white' : 'bg-green-100'"
                            class="cursor-pointer p-1 hover:bg-accent hover:text-white  rounded-2xl px-4  "
                                required>House</label>

                            <input v-model="category" type="radio" hidden name="category" value="house" id="house">
                        </div>
                        <div class="flex flex-col">
                            <label for="shop" :class="category === 'shop' ? 'bg-accent text-white' : 'bg-green-100'"
                                class="cursor-pointer p-1 hover:bg-accent hover:text-white rounded-2xl px-4 ">Shop</label>
                            <input v-model="category" type="radio" hidden name="category" value="shop" id="shop" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <h2 class="mb-1">Type</h2>
                    <div class="flex gap-1">
                        <div class="flex flex-col">
                            <label for="concrete" :class="type === 'concrete' ? 'bg-accent text-white' : 'bg-green-100'"
                                class="cursor-pointer p-1 hover:bg-accent hover:text-white  rounded-2xl px-4  "
                                required>Concrete</label>

                            <input v-model="type" type="radio" hidden name="type" value="concrete" id="concrete">
                        </div>
                        <div class="flex flex-col">
                            <label for="assamType" :class="type === 'assam-type' ? 'bg-accent text-white' : 'bg-green-100'"
                                class="cursor-pointer p-1 hover:bg-accent hover:text-white rounded-2xl px-4 ">Assam-Type</label>
                            <input v-model="type" type="radio" hidden name="type" value="assam-type" id="assamType"
                                required>
                        </div>
                    </div>
                </div>
            </div>



            <div>


            </div>

            <div class="rounded-xl bg-white p-4 flex flex-col gap-2">
                <h1 class="text-xl">Add Images</h1>
                <div>
                    <label class="block mb-1">Upload Gallery Images (JPG only)</label>
                    <input type="file" accept=".jpg, .jpeg" multiple @change="handleImageUpload"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white cursor-pointer hover:file:bg-accent/80" />
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 mt-4">
                    <div v-for="(src, index) in previews" :key="index" class="rounded border overflow-hidden relative">
                        <img :src="src" alt="Preview"
                            class="object-cover w-full h-40 hover:scale-[1.1] brightness-[85%] hover:brightness-100 cursor-pointer" />
                        <i @click="removePreview(index)"
                            class="bx bx-x text-2xl text-white absolute top-1 right-1 opacity-50 cursor-pointer hover:opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- ATTRIBUTES -->
            <div class="rounded-xl bg-white p-4 flex flex-col gap-2">
                <h1 class="text-xl">Property Details</h1>
                <div v-if="category == 'house'">
                    <div class="flex gap-5 ">
                        <div class="flex flex-col w-[60px]">
                            <label for="bathroom">Bathroom</label>
                            <input type="number" name="bathroom" id="bathroom"
                                class="border p-2 rounded-lg w-full outline-none" min="0" required>

                        </div>
                        <div class="flex flex-col w-[60px]">
                            <label for="bedrrom">Bedroom</label>
                            <input type="number" name="bedroom" id="bedroom"
                                class="border p-2 rounded-lg w-full outline-none" min="0" required>

                        </div>

                    </div>
                    <div class="flex gap-10 items-center">
                        <div class="flex flex-col">
                            <span>Balcony</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="balcony" id="balconyYes" value="yes">
                                <label for="balconyYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="balcony" id="balconyNo" value="no">
                                <label for="balconyNo">No</label>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <span>Parking</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="parking" id="parkingYes" value="yes">
                                <label for="parkingYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="parking" id="parkingNo" value="no">
                                <label for="parkingNo">No</label>
                            </div>

                        </div>

                        <div class="flex flex-col">
                            <span>Furnished</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="furnished" id="furnishedYes" value="yes">
                                <label for="furnishedYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="furnished" id="furnishedNo" value="no">
                                <label for="furnishedNo">No</label>
                            </div>

                        </div>


                    </div>
                </div>
                <div v-else>
                    <div class="flex gap-7  items-center">
                        <div class="flex flex-col w-[60px]">
                            <label for="bathroom">Area(sq.m)</label>
                            <input type="number" name="Area" id="Area"
                                class="border p-2 rounded-lg w-full outline-none" min="0" required>

                        </div>
                        <div class="flex flex-col">
                            <label for="floor">Floor</label>
                            <select name="floor" id="floor" class="p-2">
                                <option value="ground-floor">Ground Floor</option>
                                <option value="ground-floor">First Floor</option>
                                <option value="ground-floor">Second Floor</option>
                                <option value="ground-floor">Third Floor</option>
                                <option value="ground-floor">Forth Floor</option>
                                <option value="ground-floor">Fifth Floor</option>
                                <option value="ground-floor">Sixth Floor</option>
                                <option value="ground-floor">Seventh Floor</option>
                            </select>

                        </div>

                    </div>
                    <div class="flex gap-10 items-center">
                        <div class="flex flex-col">
                            <span>Electricity</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="balcony" id="balconyYes" value="yes">
                                <label for="balconyYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="balcony" id="balconyNo" value="no">
                                <label for="balconyNo">No</label>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <span>Water Supply</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="parking" id="parkingYes" value="yes">
                                <label for="parkingYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="parking" id="parkingNo" value="no">
                                <label for="parkingNo">No</label>
                            </div>

                        </div>

                        <div class="flex flex-col">
                            <span>Attached Bathroom</span>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="furnished" id="furnishedYes" value="yes">
                                <label for="furnishedYes">Yes</label>
                            </div>
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="furnished" id="furnishedNo" value="no">
                                <label for="furnishedNo">No</label>
                            </div>

                        </div>


                    </div>
                </div>

            </div>

            <div class="rounded-xl bg-white p-4 flex flex-col gap-2">
                <h2 class="text-xl">Contact Details</h2>
                <div class="flex gap-4">
                    <FormInput label="Phone" />
                    <FormInput label="Email" />
                </div>


            </div>


            <div class="rounded-xl bg-white p-4 flex flex-col gap-2">
                <div>
                    <label for="autocomplete" class="block mb-1">Location</label>
                    <input id="autocomplete" ref="autocompleteInput" type="text" placeholder="Enter address"
                        class="input w-full px-4 py-2 border rounded" />
                </div>

                <GoogleMap :api-key="api" style="width:100%; height:50vh;" :center="location" :zoom="zoom"
                    @click="addMarker">
                    <Marker v-for="(marker, index) in markers" :key="index" :options="marker" @click="removeMarker()" />
                </GoogleMap>
            </div>

            <div class="border-2 border-accent rounded-lg bg-white p-4 flex flex-col gap-2 mt-6">
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
            </div>
        </div>
    </section>
</template>

  
<style scoped></style>