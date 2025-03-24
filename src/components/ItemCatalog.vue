<script setup>
import { ref } from 'vue'

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
        <div class="py-8 grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="flex relative flex-col cursor-pointer hover:shadow-lg transition-shadow duration-300 bg-white rounded-lg overflow-hidden"
                v-for="n in rentalListings" :key="n">
                <img class="w-full h-48 object-cover"
                    src="https://media.istockphoto.com/id/1415886887/photo/freshly-painted-craftsman-bungalow-house.jpg?s=612x612&w=0&k=20&c=lcwiyJqjUoIM0FfRb3TwV2BzUY8RS7oT9zFmZGv4nLI="
                    alt="House Image">
                <div class="flex flex-col p-4">
                    <h2 class="font-semibold text-lg">{{ n.price }}</h2>
                    <div class="flex gap-3 mt-2 text-gray-600">
                        <span class="flex items-center gap-1">
                            <i class='bx bxs-bed text-accent'></i> <span>{{n.bedrooms}}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class='bx bxs-bath text-accent'></i> <span>{{ n.bathrooms }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class='bx bxs-home text-accent'></i> <span>{{ n.livingRooms }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class='bx bxs-map text-accent'></i> <span>2</span>
                        </span>
                    </div>

                    <span class="mt-2 text-gray-500">{{ n.location }}</span>
                    <span class="text-gray-500 text-sm">{{ n.posted }}</span>

                </div>
                <i
                    class='bx bxs-heart absolute top-2 right-2 opacity-80 hover:text-accent hover:opacity-100 text-white text-3xl'></i>
            </div>
        </div>

        <div class="flex items-center justify-center ">

            <button class="cursor-pointer p-2 px-3   bg-accent hover:brightness-110 active:brightness-100  text-white">Load
                More</button>

        </div>

    </section>
</template>
<style scoped></style>