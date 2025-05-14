<script setup>
import MainNavbar from '@/components/MainNavbar.vue'
import MainFooter from '@/components/MainFooter.vue'
import { RouterView } from 'vue-router'
import TopLoader from '@/components/TopLoader.vue'
</script>

<template>
  <section>
    <TopLoader />
    <MainNavbar />

   
    <keep-alive include="browse">
      <RouterView />
    </keep-alive>

    <MainFooter />
  </section>
</template>
