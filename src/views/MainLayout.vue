<script setup>
import MainNavbar from '@/components/MainNavbar.vue'
import MainFooter from '@/components/MainFooter.vue'
import { RouterView } from 'vue-router'
</script>

<template>
  <section class="">
    <MainNavbar />
    <RouterView />
    <MainFooter />
  </section>
</template>
