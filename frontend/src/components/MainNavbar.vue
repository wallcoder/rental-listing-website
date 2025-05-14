<script setup>
import ButtonLink from './ButtonLink.vue';
import { RouterLink } from 'vue-router';
import { ref, watch } from 'vue'
import Logo from '@/components/Logo.vue'
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'
import { onClickOutside } from '@vueuse/core'

const { isLoggedin, user } = storeToRefs(useAuthStore())
const { logout } = useAuthStore()
const isOpenSidebar = ref(false)
const isOpenMenu = ref(false)
const dropdown = ref(null)
const toggler = ref(null)
const links = ref([
   {
      label: 'Home',
      link: '/'
   },
   {
      label: 'Sign In',
      link: '/user/login'
   },
   {
      label: 'Create Post',
      link: '/create-post'
   },


])

watch(isOpenSidebar, (newVal) => {
   if (newVal) {
      document.body.classList.add('overflow-hidden')
   } else {
      document.body.classList.remove('overflow-hidden')
   }
})

onClickOutside(dropdown, (event) => {
   if (toggler.value.contains(event.target))
      return
   isOpenMenu.value = false
})
</script>
<template>
   <header class="flex items-center justify-between py-4 h-20   bg-white px-[4%]  lg:px-[8%] ">
      <!-- LOGO -->
      <div class="flex items-center gap-6">
         <Logo />


      </div>





      <nav class="hidden md:flex items-center gap-4 ">

         <RouterLink to="/browse?street=&locality=&city=&state=Mizoram&pincode=&country=India"
            class="p-[8px] px-5 rounded-3xl hover:bg-gray-100">All Listings
         </RouterLink>
         <RouterLink to="/user/login" class="p-[8px] px-5 rounded-3xl hover:bg-gray-100" v-if="!isLoggedin">Sign In
         </RouterLink>


         <ButtonLink content="List Your Property" extraStyle="" link="/create-post" />
         <div class="flex items-center gap-1 " v-if="isLoggedin && user">
            <RouterLink to="/user" v-if="isLoggedin"
               class="flex items-center  justify-center hover:bg-gray-100 rounded-full p-2  cursor-pointer border active:scale-90">
               <i class='bx bx-user text-2xl '></i>
            </RouterLink>


            <div class="relative  ">
               <i @click="isOpenMenu = !isOpenMenu" ref="toggler"
                  class='bx bx-chevron-down text-2xl  rounded-full border hover:bg-gray-100 cursor-pointer active:scale-75'></i>

               <!-- MENU -->
               <div ref="dropdown"
                  class="absolute z-20 menu top-9 bg-white right-0 shadow-md p-2 flex flex-col  rounded-lg"
                  v-if="isOpenMenu">
                  <div @click="isOpenMenu = false"
                     class="flex gap-2 items-center rounded-lg hover:bg-gray-100 p-2 cursor-pointer">
                     <i class='bx bx-user text-3xl rounded-full p-2 bg-gray-100 '></i>
                     <RouterLink to="/user" class="flex flex-col" v-if="user">
                        <div>{{ user.name }}</div>
                        <span class="text-gray-400">{{ user.email }}</span>
                     </RouterLink>
                  </div>
                  <div @click="isOpenMenu = false" class="mt-2 flex flex-col font-semibold">
                     <RouterLink to="/user/saved"
                        class="text-left hover:bg-gray-100 p-2 rounded-lg flex items-center gap-2"><i
                           class='bx bx-bookmark text-xl'></i><span>Saved</span> </RouterLink>
                     <RouterLink to="/user/posts"
                        class="text-left hover:bg-gray-100 p-2 rounded-lg flex items-center gap-2"><i
                           class='bx bx-clinic text-xl'></i><span>Posts</span> </RouterLink>
                     <button @click="logout()"
                        class="text-left hover:bg-gray-100 p-2 rounded-lg flex items-center gap-2"><i
                           class='bx bx-log-out text-xl'></i><span>Log
                           out</span> </button>

                  </div>
               </div>
            </div>
         </div>
      </nav>

      <div class=" block md:hidden">
         <i class='bx bx-menu text-4xl cursor-pointer hover:text-accent' @click="isOpenSidebar = true"></i>
      </div>


      <div class="fixed  w-full  top-0 left-0 z-30 pointer-events-none">
         <Transition>
            <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto" @click="isOpenSidebar = false"
               v-if="isOpenSidebar">

            </div>
         </Transition>
         <div
            class="absolute top-0 right-0 bg-white  w-[300px] h-[100vh] flex flex-col pointer-events-auto transition-all duration-[0.5s] ease-out"
            :class="isOpenSidebar ? 'translate-x-0' : 'translate-x-[100%]'">
            <div class="flex justify-between items-center p-4">
               <Logo />
               <i class="bx bx-x text-3xl cursor-pointer hover:text-accent" @click="isOpenSidebar = false"
                  :class="isOpenSidebar ? 'rotate-[720deg]' : ''"></i>
            </div>
            <div  v-if="isLoggedin" @click="isOpenSidebar = false" class="flex gap-2 items-center rounded-lg hover:bg-gray-100 p-2 cursor-pointer">
               <i class='bx bx-user text-3xl rounded-full p-2 bg-gray-100 '></i>
               <RouterLink to="/user" class="flex flex-col" v-if="user">
                  <div>{{ user.name }}</div>
                  <span class="text-gray-400">{{ user.email }}</span>
               </RouterLink>
            </div>
            <RouterLink @click="isOpenSidebar = false" to="/" class="px-4 py-2 font-semibold " exactActiveClass="text-accent">Home</RouterLink>
            <RouterLink @click="isOpenSidebar = false" to="/browse?street=&locality=&city=&state=Mizoram&pincode=&country=India"  class="px-4 py-2 font-semibold " exactActiveClass="text-accent">All Listings</RouterLink>
            <RouterLink @click="isOpenSidebar = false" to="/user/saved" class="px-4 py-2 font-semibold " exactActiveClass="text-accent" v-if="isLoggedin">Saved</RouterLink>
            <RouterLink @click="isOpenSidebar = false"  to="/user/posts" class="px-4 py-2 font-semibold " exactActiveClass="text-accent" v-if="isLoggedin">Posts</RouterLink>
            <RouterLink @click="isOpenSidebar = false"  to="/user/login" class="px-4 py-2 font-semibold " exactActiveClass="text-accent" v-if="!isLoggedin">Sign In</RouterLink>
            <span @click="isOpenSidebar = false; logout()"  class="px-4 py-2 font-semibold cursor-pointer" exactActiveClass="text-accent" v-if="isLoggedin">Logout</span>
            



      </div>

   </div>
</header></template>
<style scoped></style>
