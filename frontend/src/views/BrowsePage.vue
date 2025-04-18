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
const mapStore = useMapStore()
const { isBrowsePage } = storeToRefs(useUtilStore())
const { autocompleteInput, searchLoc, autocompleteInstance, markers, location } = storeToRefs(mapStore)
const { loader } = mapStore;
const suggestions = ref([]);
const showSuggestions = ref(false);





onMounted(async () => {
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
   <section class="flex flex-col bg-white">
      <!-- Search and filters -->
      <div class="px-[12%] py-2 bg-bg flex gap-2 items-center relative">
         <!-- Location Search -->

         <div class="relative flex items-center bg-white rounded-3xl border w-[350px]">
            <i class="bx bxs-map text-accent text-2xl px-2"></i>
            <input v-model="searchLoc" type="search" id="autocomplete" ref="autocompleteInput"
               placeholder="Location in Mizoram" class="w-36 py-1 px-2 flex-1 outline-none" />
            <button class="flex items-center justify-center">
               <i class="bx bx-search px-4 text-xl"></i>
            </button>

            <!-- Suggestions dropdown -->
            <ul v-if="showSuggestions && suggestions.length"
               class="absolute top-full mt-1 left-0 w-full bg-white border rounded-md z-50 shadow-md">
               <li v-for="(suggestion, index) in suggestions" :key="index"
                  class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="selectSuggestion(suggestion)">
                  {{ suggestion }}
               </li>
            </ul>
         </div>

         <!-- Sort Filter -->
         <div class="flex items-center gap-2 bg-white py-1 px-3 rounded-3xl">
            <label for="sort">Sort by</label>
            <select name="sort" id="sort" class="outline-none">
               <option value="0">Recommended</option>
               <option value="0">New</option>
               <option value="0">Price High to Low</option>
               <option value="0">Price Low to High</option>
            </select>
         </div>

         <!-- Filters button -->
         <div class="flex items-center gap-2 bg-white py-1 px-3 rounded-3xl ">
            <span>Filters</span>
            <i class="bx bx-filter text-xl cursor-pointer"></i>
         </div>
      </div>

      <!-- Content Section -->

      <!-- Catalog -->

      <div class="grid grid-cols-4 gap-4 px-[12%] py-2">
         <ItemCard />

      </div>





   </section>
</template>

<style scoped>
/* Optional: Add styling for scrollbars or dropdown */
</style>
