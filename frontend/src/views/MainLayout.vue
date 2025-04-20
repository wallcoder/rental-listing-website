<script setup>
import MainNavbar from '@/components/MainNavbar.vue'
import MainFooter from '@/components/MainFooter.vue'
import { RouterView } from 'vue-router'
import TopLoader from '@/components/TopLoader.vue'
</script>

<template>
  <section class="">
    <TopLoader />
    <MainNavbar />
    <RouterView />
    <MainFooter />
  </section>
</template>
