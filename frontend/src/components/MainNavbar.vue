<script setup>
import ButtonLink from './ButtonLink.vue';
import { RouterLink } from 'vue-router';
import { ref, watch } from 'vue'
import Logo from '@/components/Logo.vue'
const isOpenSidebar = ref(false)
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
</script>
<template>
   <header class="flex items-center justify-between py-4 h-20   bg-white px-[4%]  lg:px-[8%] ">
      <!-- LOGO -->
      <div class="flex items-center gap-6">
         <Logo />

      </div>




      <nav class="hidden md:flex items-center gap-4">

         <RouterLink to="/user/login" class="p-[8px] px-5 rounded-3xl hover:bg-gray-100">Sign In</RouterLink>
         <ButtonLink content="Create Post" extraStyle="" link="/create-post" />

      </nav>

      <div class=" block md:hidden">
         <i class='bx bx-menu text-4xl cursor-pointer hover:text-accent' @click="isOpenSidebar = true"></i>
      </div>


      <div class="fixed  w-full  top-0 left-0 z-30 pointer-events-none" >
         <Transition>
            <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto" @click="isOpenSidebar = false" v-if="isOpenSidebar">

            </div>
         </Transition>
         <div class="absolute top-0 right-0 bg-white  w-[300px] h-[100vh] flex flex-col pointer-events-auto transition-all duration-[0.5s] ease-out"
            :class="isOpenSidebar ? 'translate-x-0' : 'translate-x-[100%]'">
            <div class="flex justify-between items-center p-4">
               <Logo />
               <i class="bx bx-x text-3xl cursor-pointer hover:text-accent" @click="isOpenSidebar = false" :class="isOpenSidebar ? 'rotate-[720deg]': ''"></i>
            </div>
            <RouterLink @click="isOpenSidebar = false" :to="l.link" class="px-4 py-2 font-semibold "
               exactActiveClass="text-accent" v-for="l in links" :key="l">{{ l.label }}</RouterLink>



         </div>

      </div>
   </header>
</template>
<style scoped>
/* div {
   color: #e9475d;
} */
</style>
