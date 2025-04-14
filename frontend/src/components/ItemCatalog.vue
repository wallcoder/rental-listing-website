<script setup>
import { ref } from 'vue'
import ItemCard from './ItemCard.vue';
import ButtonLink from './ButtonLink.vue';
const rentalListings = ref([
    {
        id: 1,
        price: "₹5000/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Chhinga Veng, Aizawl",
        posted: "1 day ago",
        image: "https://via.placeholder.com/400x300?text=House+1"
    },
    {
        id: 2,
        price: "₹7500/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Bairabi, Aizawl",
        posted: "3 days ago",
        image: "https://via.placeholder.com/400x300?text=House+2"
    },
    {
        id: 3,
        price: "₹4200/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "Bairabi, Aizawl",
        posted: "2 days ago",
        image: "https://via.placeholder.com/400x300?text=House+3"
    },
    {
        id: 4,
        price: "₹6800/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 2,
        location: "Chhimtuipui, Aizawl",
        posted: "1 week ago",
        image: "https://via.placeholder.com/400x300?text=House+4"
    },
    {
        id: 5,
        price: "₹5500/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Zarkawt, Aizawl",
        posted: "5 hours ago",
        image: "https://via.placeholder.com/400x300?text=House+5"
    },
    {
        id: 6,
        price: "₹6000/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "Bawktlang, Aizawl",
        posted: "2 hours ago",
        image: "https://via.placeholder.com/400x300?text=House+6"
    },
    {
        id: 7,
        price: "₹8200/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Lalsingi, Aizawl",
        posted: "4 days ago",
        image: "https://via.placeholder.com/400x300?text=House+7"
    },
    {
        id: 8,
        price: "₹4800/month",
        bedrooms: 1,
        bathrooms: 1,
        livingRooms: 1,
        location: "Mission Veng, Aizawl",
        posted: "1 day ago",
        image: "https://via.placeholder.com/400x300?text=House+8"
    },
    {
        id: 9,
        price: "₹7200/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 2,
        location: "Zarkawt, Aizawl",
        posted: "6 days ago",
        image: "https://via.placeholder.com/400x300?text=House+9"
    },
    {
        id: 10,
        price: "₹6500/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Chawlhhmun, Aizawl",
        posted: "3 days ago",
        image: "https://via.placeholder.com/400x300?text=House+10"
    },
    {
        id: 11,
        price: "₹5100/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "North Hlimen, Aizawl",
        posted: "1 day ago",
        image: "https://via.placeholder.com/400x300?text=House+11"
    },
    {
        id: 12,
        price: "₹9000/month",
        bedrooms: 4,
        bathrooms: 3,
        livingRooms: 2,
        location: "Chawlhhmun, Aizawl",
        posted: "2 weeks ago",
        image: "https://via.placeholder.com/400x300?text=House+12"
    },
    {
        id: 13,
        price: "₹4700/month",
        bedrooms: 1,
        bathrooms: 1,
        livingRooms: 1,
        location: "Bawktlang, Aizawl",
        posted: "5 hours ago",
        image: "https://via.placeholder.com/400x300?text=House+13"
    },
    {
        id: 14,
        price: "₹8000/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Chhinga Veng, Aizawl",
        posted: "4 days ago",
        image: "https://via.placeholder.com/400x300?text=House+14"
    },
    {
        id: 15,
        price: "₹5600/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "Mission Veng, Aizawl",
        posted: "3 hours ago",
        image: "https://via.placeholder.com/400x300?text=House+15"
    },
    {
        id: 16,
        price: "₹7300/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "Lalsingi, Aizawl",
        posted: "2 days ago",
        image: "https://via.placeholder.com/400x300?text=House+16"
    },
    {
        id: 17,
        price: "₹6200/month",
        bedrooms: 2,
        bathrooms: 2,
        livingRooms: 1,
        location: "Zarkawt, Aizawl",
        posted: "1 day ago",
        image: "https://via.placeholder.com/400x300?text=House+17"
    },
    {
        id: 18,
        price: "₹8500/month",
        bedrooms: 3,
        bathrooms: 3,
        livingRooms: 2,
        location: "Bairabi, Aizawl",
        posted: "1 week ago",
        image: "https://via.placeholder.com/400x300?text=House+18"
    },
    {
        id: 19,
        price: "₹4900/month",
        bedrooms: 2,
        bathrooms: 1,
        livingRooms: 1,
        location: "Chhimtuipui, Aizawl",
        posted: "6 hours ago",
        image: "https://via.placeholder.com/400x300?text=House+19"
    },
    {
        id: 20,
        price: "₹7700/month",
        bedrooms: 3,
        bathrooms: 2,
        livingRooms: 1,
        location: "North Hlimen, Aizawl",
        posted: "2 days ago",
        image: "https://via.placeholder.com/400x300?text=House+20"
    }
]);
</script>
<template>
    <section class=" py-8 px-[2%] flex flex-col   w-full">
        <div class="flex lg:items-center flex-col lg:flex-row justify-between">
            <h1 class="text-xl font-semibold">Showing Rental Houses in Aizawl (20)</h1>
            <div class="flex items-center gap-2">
                <label for="sort">Sort by</label>
                <select name="sort" id="sort" class="border p-1">
                    <option value="0">Recommended</option>
                    <option value="0">New</option>
                    <option value="0">Price High to Low</option>
                    <option value="0">Price Low to High</option>
                </select>
            </div>
        </div>
        <div class="py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
            <ItemCard />
        </div>

        <div class="flex items-center justify-center ">

           <ButtonLink content="Load More" :isLink="false" />

        </div>

    </section>
</template>
<style scoped>
</style>