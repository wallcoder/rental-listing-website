<script setup>
import { ref, onMounted } from 'vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import { Loader } from '@googlemaps/js-api-loader'
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { push } from 'notivue'
import { storeToRefs } from 'pinia'
import PropertyInformation from '@/components/CreatePost/PropertyInformation.vue'
import GalleryImages from '@/components/CreatePost/GalleryImages.vue'
import HouseDetails from '@/components/CreatePost/HouseDetails.vue'
import ShopDetails from '@/components/CreatePost/ShopDetails.vue'
import ContactDetails from '@/components/CreatePost/ContactDetails.vue'
import LocationDetails from '@/components/CreatePost/LocationDetails.vue'
import PlanDetails from '@/components/CreatePost/PlanDetails.vue'
import Thumbnail from '@/components/CreatePost/Thumbnail.vue'
import SelectPlans from '@/components/CreatePost/SelectPlans.vue'
import { useCreatePostStore } from '@/stores/createPost'
const createPost = useCreatePostStore()
const { submit } = createPost

</script>



<template>
    <section class="items-center justify-center px-[2%] lg:px-[16%] py-10 flex gap-4">
        <form class="flex flex-col gap-2 w-full" @submit.prevent="submit">
            <h1 class="text-2xl">Create a Post</h1>

            <PropertyInformation />
            <Thumbnail />
            <GalleryImages />
            <HouseDetails />
            <ShopDetails />
            <ContactDetails />
            <LocationDetails />
            <div>
                <ButtonLink type="submit" content="Post this Property" :isLink="false" />
            </div>
            <!-- <SelectPlans /> -->















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