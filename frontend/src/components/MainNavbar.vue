<script setup>
import ButtonLink from './ButtonLink.vue';
import { RouterLink } from 'vue-router';
import Logo from '@/components/Logo.vue'
</script>
<template>
   <header class="flex items-center justify-between py-2  bg-white  px-[2%] ">
      <!-- LOGO -->
      <div class="flex items-center gap-6">
         <Logo />
         <ButtonLink content="Create Post" extraStyle="" icon="bx bx-star" link="/create-post" />
      </div>

      <!-- SEARCH BAR -->
      <!-- <div class="flex items-center  ">
         <input type="search" name="search" id="search"
            class=" p-2 w-[400px] rounded-l-xl outline-none border border-gray-400" placeholder="Search ">
         <i
            class='bx bx-search-alt-2 text-white text-2xl px-2 py-2 birder-2 rounded-r-xl border-accent border hover:brightness-110 active:brightness-100 cursor-pointer bg-accent'></i>
      </div> -->
      

      <nav class="flex items-center gap-2">


         <ButtonLink content="Login" extraStyle="bg-accent-2" link="/user/login" />
         <ButtonLink content="Sign up"
            extraStyle="   font-semibold" link="/user/signup" />

      </nav>
   </header>
</template>
<style scoped>
/* div {
   color: #e9475d;
} */
</style>
