<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { Notivue, Notification, push } from 'notivue'

import 'notivue/notification.css' // Only needed if using built-in <Notification />
import 'notivue/animations.css' // Only needed if using default animations
</script>

<template>
  <div class="">
    <RouterView />
    <Notivue v-slot="item">
      <Notification :item="item" />
    </Notivue>
  </div>
</template>

<style scoped></style>
