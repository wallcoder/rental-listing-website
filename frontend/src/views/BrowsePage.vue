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
import { useRouter } from 'vue-router'
import { useRoute } from 'vue-router'
const route = useRoute()
const router = useRouter()
const mapStore = useMapStore()
const { rentals, isLoadingBrowse, filter } = storeToRefs(usePostStore());
const { getRentals, resetFilter } = usePostStore();
const { isBrowsePage } = storeToRefs(useUtilStore())
const { autocompleteInput, searchLoc, autocompleteInstance, autocompleteService, mizoramBounds, markers, location, predictions, placesService, searchAddress } = storeToRefs(mapStore)
const { loader, extractSearchAddress, onEnterSearch } = mapStore;
const suggestions = ref([]);
const showSuggestions = ref(false);
const isOpenFilter = ref(false);

const applyFilter = () => {
   getRentals(props.street, props.locality, props.city, props.state, props.pincode, props.country)
}


const props = defineProps({
   name: 'browse',
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
   const { AutocompleteService, PlacesService } = placesLib

   autocompleteService.value = new AutocompleteService()

   if (autocompleteInput.value) {
      autocompleteInstance.value = new window.google.maps.places.Autocomplete(autocompleteInput.value, {
         types: ['geocode'],
         componentRestrictions: { country: 'IN' },
         bounds: mizoramBounds.value,
         strictBounds: true
      })

      const mapDiv = document.createElement('div') // dummy div for PlacesService
      placesService.value = new PlacesService(mapDiv)

      autocompleteInstance.value.addListener('place_changed', () => {
         const place = autocompleteInstance.value.getPlace()
         if (place.geometry && place.geometry.location) {
            const lat = place.geometry.location.lat()
            const lng = place.geometry.location.lng()
            location.value = { lat, lng }
            searchLoc.value = place.formatted_address
            extractSearchAddress(place)
            console.log(searchAddress.value)
            router.push(`/browse?street=${searchAddress.value.street}&locality=${searchAddress.value.locality}&city=${searchAddress.value.city}&state=${searchAddress.value.state}&pincode=${searchAddress.value.pincode}&country=${searchAddress.value.country}`)
         }
      })
   }
})

onUnmounted(() => {

})


watch(searchLoc, async (val) => {
   if (val && autocompleteService) {
      autocompleteService.value.getPlacePredictions({
         input: val,
         componentRestrictions: { country: 'IN' },
         bounds: mizoramBounds.value,
         strictBounds: true,
      }, (preds, status) => {
         if (status === 'OK' && preds?.length) {
            predictions.value = preds
         }
      })
   }
})


watch(
   () => route.query,
   () => {
      resetFilter()
      getRentals(props.street, props.locality, props.city, props.state, props.pincode, props.country)
   }
)


const goToPage = (url) => {
   if (!url) return;
   const urlObj = new URL(url);
   const page = urlObj.searchParams.get("page");

   if (page) {
      getRentals(props.street, props.locality, props.city, props.state, props.pincode, props.country, page);
   }
};

</script>

<template>
   <section class="flex flex-col bg-white ">



      <!-- Search and filters -->
      <div class=" py-2 bg-bg flex gap-2 items-center relative px-[4%]  lg:px-[8%]">
         <!-- Location Search -->

         <div class="relative flex items-center bg-white rounded-3xl border w-[350px]">
            <i class="bx bxs-map text-accent text-2xl px-2"></i>
            <input @keyup.enter="onEnterSearch" v-model="searchLoc" type="search" id="autocomplete" ref="autocompleteInput"
               placeholder="Location in Mizoram" class="w-36 py-1 px-2 flex-1 outline-none" />
            <button class="flex items-center justify-center">
               <i class="bx bx-search px-4 text-xl" @click="onEnterSearch()"></i>
            </button>


         </div>

         <!-- Sort Filter -->
         <!-- <div class=" items-center gap-2 bg-white py-1  rounded-3xl hidden md:flex">
            <label for="sort">Sort by</label>
            <select name="sort" id="sort" class="outline-none   rounded-lg cursor-pointer">
               <option value="0">Recommended</option>
               <option value="0">New</option>
               <option value="0">Price High to Low</option>
               <option value="0">Price Low to High</option>
            </select>
         </div> -->

         <!-- Filters button -->
         <div class="flex items-center gap-2 bg-white py-1  p-3 rounded-3xl  cursor-pointer hover:bg-gray-100"
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
            <div v-for="n in 8" :key="n" class="h-[300px] bg-gray-100 rounded-lg relative overflow-hidden">
               <div
                  class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
               </div>
            </div>
         </div>
      </section>
      <div v-else>
         <div v-if="rentals?.data.length > 0" class="py-2 flex flex-col gap-2">
            <p class="px-[4%] lg:px-[8%] text- text-gray-500">
               Showing {{ rentals.data.length }} out of {{ rentals.total }} results
            </p>
            <div
               class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4   px-[4%]  lg:px-[8%]">

               <ItemCard :items="rentals?.data" />


            </div>
            <!-- Pagination -->
            <div class="flex items-center justify-center py-8">
               <div class="flex space-x-1">
                  <button v-for="(link, index) in rentals.links" :key="index" :disabled="!link.url"
                     @click="goToPage(link.url)" v-html="link.label" class="px-3 py-1 rounded-lg border " :class="{

                        'bg-accent text-white': link.active,
                        'bg-gray-200 hover:bg-gray-300': !link.active,
                        'opacity-50 ': !link.url
                     }"></button>
               </div>
            </div>

         </div>

         <div v-else class="flex flex-col gap-6 items-center justify-center py-10 h-[40vh]">


            <h1 class="text-xl  text-center text-gray-500">No listing found in this area</h1>

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
                        <select v-model="filter.sort" id="category"
                           class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="latest">Latest</option>
                           <option value="price_asc">Price Low to High</option>
                           <option value="price_desc">Price High to Low</option>
                           <option value="area_asc">Area Low to High</option>
                           <option value="area_desc">Area High to Low</option>

                        </select>
                     </div>


                  </div>

                  <!-- Category & Type -->
                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label for="category">Category</label>
                        <select v-model="filter.category" id="category"
                           class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="">All</option>
                           <option value="house">House</option>
                           <option value="shop">Shop</option>
                        </select>
                     </div>

                     <div class="flex flex-col flex-1">
                        <label for="type">Type</label>
                        <select v-model="filter.type" id="type"
                           class="outline-none bg-gray-100 p-2 rounded-lg cursor-pointer">
                           <option value="">All</option>
                           <option value="concrete">Concrete</option>
                           <option value="assam-type">Assam-Type</option>
                        </select>
                     </div>
                  </div>

                  <!-- Price & Area -->
                  <div class="flex flex-col sm:flex-row gap-4">
                     <div class="flex flex-col flex-1">
                        <label>Price (₹)</label>
                        <div class="flex gap-2">
                           <!-- Min Price -->
                           <select v-model="filter.minPrice"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="0">0</option>
                              <option value="2500">2,500</option>
                              <option value="5000">5,000</option>
                              <option value="7500">7,500</option>
                              <option value="10000">10,000</option>
                              <option value="15000">15,000</option>
                              <option value="20000">20,000</option>
                              <option value="25000">25,000</option>
                              <option value="30000">30,000</option>
                              <option value="35000">35,000</option>
                              <option value="40000">40,000</option>
                              <option value="45000">45,000</option>
                              <option value="50000">50,000</option>
                              <option value="60000">60,000</option>
                              <option value="70000">70,000</option>
                              <option value="80000">80,000</option>
                              <option value="90000">90,000</option>
                              <option value="100000">1,00,000</option>
                           </select>

                           <span class="self-center">to</span>

                           <!-- Max Price -->
                           <select v-model="filter.maxPrice"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="2500">2,500</option>
                              <option value="5000">5,000</option>
                              <option value="7500">7,500</option>
                              <option value="10000">10,000</option>
                              <option value="15000">15,000</option>
                              <option value="20000">20,000</option>
                              <option value="25000">25,000</option>
                              <option value="30000">30,000</option>
                              <option value="35000">35,000</option>
                              <option value="40000">40,000</option>
                              <option value="45000">45,000</option>
                              <option value="50000">50,000</option>
                              <option value="60000">60,000</option>
                              <option value="70000">70,000</option>
                              <option value="80000">80,000</option>
                              <option value="90000">90,000</option>
                              <option value="100000">1,00,000</option>
                           </select>
                        </div>
                     </div>


                     <div class="flex flex-col flex-1">
                        <label>Area (sq.m)</label>
                        <div class="flex gap-2">
                           <!-- Min Area -->
                           <select v-model="filter.minArea"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="0">0</option>
                              <option value="500">500</option>
                              <option value="1000">1000</option>
                              <option value="1500">1500</option>
                              <option value="2000">2000</option>
                              <option value="2500">2500</option>
                              <option value="3000">3000</option>
                              <option value="3500">3500</option>
                              <option value="4000">4000</option>
                              <option value="4500">4500</option>
                              <option value="5000">5000</option>
                              <option value="7500">7500</option>
                              <option value="10000">10000</option>

                           </select>

                           <span class="self-center">to</span>

                           <!-- Max Area -->
                           <select v-model="filter.maxArea"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="500">500</option>
                              <option value="1000">1000</option>
                              <option value="1500">1500</option>
                              <option value="2000">2000</option>
                              <option value="2500">2500</option>
                              <option value="3000">3000</option>
                              <option value="3500">3500</option>
                              <option value="4000">4000</option>
                              <option value="4500">4500</option>
                              <option value="5000">5000</option>
                              <option value="7500">7500</option>
                              <option value="10000">10000</option>

                           </select>
                        </div>
                     </div>

                  </div>

                  <div v-if="filter.category == 'house'" class="flex flex-col sm:flex-row gap-4">
                     <!-- Bedrooms -->
                     <div class="flex flex-col flex-1">
                        <label>Bedrooms</label>
                        <div class="flex gap-2">
                           <select v-model="filter.minBed"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="0">0</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6+</option>
                           </select>
                           <span class="self-center">to</span>
                           <select v-model="filter.maxBed"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6+</option>
                           </select>
                        </div>
                     </div>

                     <!-- Bathrooms -->
                     <div class="flex flex-col flex-1">
                        <label>Bathrooms</label>
                        <div class="flex gap-2">
                           <select v-model="filter.minBath"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="0">0</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6+</option>
                           </select>
                           <span class="self-center">to</span>
                           <select v-model="filter.maxBath"
                              class="w-1/2 min-w-[80px] bg-gray-100 p-2 rounded-lg outline-none cursor-pointer">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6+</option>
                           </select>
                        </div>
                     </div>
                  </div>


                  <!-- Apply Button -->
                  <div class="mt-2 flex justify-end gap-2">

                     <ButtonLink content="Reset" :isLink="false" :fun="() => { resetFilter(); }" />
                     <ButtonLink content="Apply" :isLink="false" :fun="() => { applyFilter(); isOpenFilter = false }" />
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
