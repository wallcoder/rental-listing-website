<script setup>
import { ref, watch } from 'vue';
import { onMounted, onUnmounted } from 'vue'
import FilterSidebar from '@/components/FilterSidebar.vue';
import ButtonLink from '@/components/ButtonLink.vue';
import FilterSlider from '@/components/FilterSlider.vue';
import { storeToRefs } from 'pinia';
import ItemCard from '@/components/ItemCard.vue';
import MapView from '@/components/MapView.vue';
import { useMapStore } from '@/stores/map'
import { useUtilStore } from '@/stores/util';
import { usePostStore } from '@/stores/post'

const mapStore = useMapStore()
const { rentals, isLoadingBrowse } = storeToRefs(usePostStore());
const { getRentals } = usePostStore();
const { isBrowsePage } = storeToRefs(useUtilStore())
const { autocompleteInput, searchLoc, autocompleteInstance, markers, location } = storeToRefs(mapStore)
const { loader } = mapStore;
const suggestions = ref([]);
const showSuggestions = ref(false);

const props = defineProps({
   street: { type: String },
   locality: { type: String },
   city: { type: String },
   state: { type: String },
   pincode: { type: String },
   country: { type: String },
})




onMounted(async () => {

   getRentals(props.street, props.locality, props.city, props.state, props.pincode, props.country)
   const placesLib = await loader.importLibrary('places')
   // isBrowsePage.value = true;
   const { Autocomplete } = placesLib

   if (autocompleteInput.value) {
      autocompleteInstance.value = new Autocomplete(autocompleteInput.value, {
         types: ['geocode'],
         // componentRestrictions: { country: 'in' },
      })

      autocompleteInstance.value.addListener('place_changed', () => {
         const place = autocompleteInstance.value.getPlace()
         searchLoc.value = place.formatted_address
         if (place.geometry && place.geometry.location) {
            const lat = place.geometry.location.lat()
            const lng = place.geometry.location.lng()

            location.value = { lat, lng }
            console.log("LOCATION: ", location.value)
            // markers.value = [{
            //    position: { lat, lng },
            //    title: place.formatted_address || `Marker at ${lat}, ${lng}`
            // }]
         }
      })
   }
})

onUnmounted(() => {
   // isBrowsePage.value = false
})
</script>

<template>
   <section class="flex flex-col bg-white ">

    

      <!-- Search and filters -->
      <div class=" py-2 bg-bg flex gap-2 items-center relative px-[4%]  lg:px-[8%]">
         <!-- Location Search -->

         <div class="relative flex items-center bg-white rounded-3xl border w-[350px]">
            <i class="bx bxs-map text-accent text-2xl px-2"></i>
            <input v-model="searchLoc" type="search" id="autocomplete" ref="autocompleteInput"
               placeholder="Location in Mizoram" class="w-36 py-1 px-2 flex-1 outline-none" />
            <button class="flex items-center justify-center">
               <i class="bx bx-search px-4 text-xl"></i>
            </button>


         </div>

         <!-- Sort Filter -->
         <div class=" items-center gap-2 bg-white py-1 px-3 rounded-3xl hidden md:flex">
            <label for="sort">Sort by</label>
            <select name="sort" id="sort" class="outline-none">
               <option value="0">Recommended</option>
               <option value="0">New</option>
               <option value="0">Price High to Low</option>
               <option value="0">Price Low to High</option>
            </select>
         </div>

         <!-- Filters button -->
         <div class="flex items-center gap-2 bg-white py-1 px-3 rounded-3xl cursor-pointer hover:bg-gray-100">
            <span>Filters</span>
            <i class="bx bx-filter text-xl "></i>
         </div>
      </div>

      <!-- Content Section -->

      <!-- Catalog -->
      <section v-if="isLoadingBrowse" class="flex flex-col bg-white">
         <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 py-6 px-[4%] lg:px-[8%]">
            <div v-for="n in 8" :key="n" class="h-64 bg-gray-100 rounded-lg relative overflow-hidden">
               <div
                  class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
               </div>
            </div>
         </div>
      </section>
      <div v-else>
         <div v-if="rentals?.data.length > 0">
            <div
               class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4  py-6 px-[4%]  lg:px-[8%]">

               <ItemCard :items="rentals?.data" />


            </div>
            <!-- Pagination -->
            <div class="flex items-center justify-center py-8">
               
            </div>

         </div>

         <div v-else class="flex flex-col gap-6 items-center justify-center py-10">

            <img src="/bg_mt.png" class="w-60" alt="">
            <h1 class="text-2xl  text-center text-gray-500">No Items Found!! Come back later</h1>

         </div>
      </div>






   </section>
</template>

<style scoped>
/* Optional: Add styling for scrollbars or dropdown */
</style>
