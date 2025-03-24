<script setup>
</script>
<template>
   <header class="flex items-center justify-between py-4 shadow  px-[2%]">
      <!-- LOGO -->
      <span class="font-semibold  flex items-center gap-1"><i class='bx text-3xl text-accent bx-home-heart'></i> <span class="">LOGO</span></span>

      <!-- SEARCH BAR -->
      <!-- <div class="flex items-center  ">
         <input type="search" name="search" id="search"
            class=" p-2 w-[400px] rounded-l-xl outline-none border border-gray-400" placeholder="Search ">
         <i
            class='bx bx-search-alt-2 text-white text-2xl px-2 py-2 birder-2 rounded-r-xl border-accent border hover:brightness-110 active:brightness-100 cursor-pointer bg-accent'></i>
      </div> -->

      <nav class="flex items-center gap-10">
         <span class="cursor-pointer hover:underline underline-offset-4">Login</span>
         <button
            class="cursor-pointer p-2 px-3  bg-accent hover:brightness-110 active:brightness-100  text-white">Create
            Post</button>
      </nav>
   </header>
</template>
<style scoped>
/* div {
   color: #e9475d;
} */
</style>
