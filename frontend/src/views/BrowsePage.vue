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
const isOpenFilter = ref(false);
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
         <div class=" items-center gap-2 bg-white py-1  rounded-3xl hidden md:flex">
            <label for="sort">Sort by</label>
            <select name="sort" id="sort" class="outline-none   rounded-lg cursor-pointer">
               <option value="0">Recommended</option>
               <option value="0">New</option>
               <option value="0">Price High to Low</option>
               <option value="0">Price Low to High</option>
            </select>
         </div>

         <!-- Filters button -->
         <div class="flex items-center gap-2 bg-white py-1  rounded-3xl  cursor-pointer hover:bg-gray-100"
            @click="isOpenFilter = true">
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


      <!-- SEARCH FILTER -->
      <div class="fixed  w-full  top-0 left-0 z-30 pointer-events-none">
         <Transition>
            <div class="w-full bg-black/60  h-[100vh] pointer-events-auto" @click="isOpenFilter = false"
               v-if="isOpenFilter">

            </div>


         </Transition>
         <Transition>
            <div v-if="isOpenFilter"
               class="absolute p-4 top-1/2 left-1/2 overflow-auto  w-[90vw] sm:w-[500px] rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg flex flex-col gap-4 pointer-events-auto transition-all duration-500 ease-out">
               <!-- Header -->
               <div class="flex justify-between items-center">
                  <h2 class="text-lg font-semibold">Search Filters</h2>
                  <i class="bx bx-x text-2xl cursor-pointer" @click="isOpenFilter = false"></i>
               </div>

               <!-- Filters Container -->
               <div class="flex flex-col gap-4">

                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label for="category">Sort by</label>
                        <select id="category" class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="0">Newest</option>
                           <option value="1">Price Low to High</option>
                           <option value="3">Price High to Low</option>
                           
                        </select>
                     </div>

                     
                  </div>

                  <!-- Category & Type -->
                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label for="category">Category</label>
                        <select id="category" class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="0">All</option>
                           <option value="1">House</option>
                           <option value="2">Shop</option>
                        </select>
                     </div>

                     <div class="flex flex-col flex-1">
                        <label for="type">Type</label>
                        <select id="type" class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="0">All</option>
                           <option value="1">Concrete</option>
                           <option value="2">Assam-Type</option>
                        </select>
                     </div>
                  </div>

                  <!-- Price & Area -->
                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label>Price(₹)</label>
                        <div class="flex gap-2">
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>0</option>
                              <option>500</option>
                           </select>
                           <span class="self-center">to</span>
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>1000</option>
                              <option>500</option>
                           </select>
                        </div>
                     </div>

                     <div class="flex flex-col flex-1">
                        <label>Area(sq.m)</label>
                        <div class="flex gap-2">
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>0</option>
                              <option>500</option>
                           </select>
                           <span class="self-center">to</span>
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>1000</option>
                              <option>500</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- Bedrooms & Bathrooms -->
                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label>Bedrooms</label>
                        <div class="flex gap-2">
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>0</option>
                              <option>2</option>
                           </select>
                           <span class="self-center">to</span>
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>3</option>
                              <option>5</option>
                           </select>
                        </div>
                     </div>

                     <div class="flex flex-col flex-1">
                        <label>Bathrooms</label>
                        <div class="flex gap-2">
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>0</option>
                              <option>1</option>
                           </select>
                           <span class="self-center">to</span>
                           <select class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option>2</option>
                              <option>4</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- Apply Button -->
                  <div class="mt-2 flex justify-end">
                     <ButtonLink content="Apply" />
                  </div>
               </div>
            </div>

         </Transition>
      </div>






   </section>
</template>

<style scoped>
/* Optional: Add styling for scrollbars or dropdown */
</style>
