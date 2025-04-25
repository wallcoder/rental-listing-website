<script setup>


import { ref, onMounted } from 'vue'
import { GoogleMap, AdvancedMarker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'
import { useMapStore } from '@/stores/map'
import { push } from 'notivue'
import { storeToRefs } from 'pinia'
const api = ref(import.meta.env.VITE_MAP_API)
const mapStore = useMapStore()
const { markers, location } = storeToRefs(mapStore)
const { zoom, addMarker } = mapStore
const mapId = import.meta.env.VITE_MAP_ID

</script>


<template>
    <section class="w-full h-full">
        
        <GoogleMap :api-key="api" style="width:100%; height:100%;" :center="location" :zoom="zoom" :mapId="mapId">
            <!-- <Marker v-for="(marker, index) in markers" :key="index" :options="marker"  /> -->
            <!-- <AdvancedMarker :options="markerOptions" :pin-options="pinOptions"/> -->
        </GoogleMap>
    </section>
</template>
