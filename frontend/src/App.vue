<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { Notivue, Notification, push } from 'notivue'
</script>

<template>
  <div class="bg-bg">
    <RouterView />
    <Notivue v-slot="item">
      <Notification :item="item" />
    </Notivue>
  </div>
</template>

<style scoped></style>
