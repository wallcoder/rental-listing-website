<script setup>
    import {RouterView} from 'vue-router'
    import {RouterLink} from 'vue-router'
    import {useAuthStore} from '@/stores/auth'
    import {storeToRefs} from 'pinia'
    const {logout }  = useAuthStore()
    const {user} = storeToRefs(useAuthStore())


</script>
<template>
    <section class="px-[4%]  lg:px-[8%] py-10">
       
        <div class="flex w-full justify-center gap-2 flex-col items-center">
            <div class=" w-24 h-24 rounded-full bg-gray-100 flex justify-center items-center overflow-hidden">
                <!-- <img src="../assets/house.jpg" class=" h-full w-full object-cover rounded-full brightness-[0.9] hover:scale-[1.03] hover:brightness-[1]" alt=""> -->
                 
                <div class="bx bx-user text-5xl "></div>
                
                <!-- <div class="h-full w-full rounded-full items-center justify-center">
                    <i class='bx bx-user text-8xl '></i>
                 </div> -->
                
            </div>
            <h2 class="text-3xl" v-if="user?.name">
                {{ user?.name }}
            </h2>
            <h2 class="text-gray-600" v-if="user?.email">{{ user?.email }}</h2>

            <div class="py-6 flex  gap-4">
                <RouterLink to="/user" class="text-lg font-semibold  hover:bg-gray-100 p-2 rounded-lg" exact-active-class="text-accent">Profile</RouterLink>
                <RouterLink to="/user/saved" class="text-lg font-semibold hover:bg-gray-100 p-2 rounded-lg" exact-active-class="text-accent">Saved</RouterLink>
                <RouterLink to="/user/posts" class="text-lg font-semibold  hover:bg-gray-100 p-2 rounded-lg" exact-active-class="text-accent">Posts</RouterLink>
                <span class="text-lg font-semibold  hover:bg-gray-100 p-2 rounded-lg cursor-pointer" @click="logout()">Logout</span>


            </div>
            <div class="w-full">
                
                <RouterView />

            </div>

        </div>

    </section>
</template>