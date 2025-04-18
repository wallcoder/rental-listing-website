<script setup>
import { RouterLink, RouterView } from 'vue-router'
import {onMounted} from 'vue'
import { Notivue, Notification, push } from 'notivue'
import {useAuthStore} from '@/stores/auth'
const {checkToken} = useAuthStore()
import 'notivue/notification.css' // Only needed if using built-in <Notification />
import 'notivue/animations.css' // Only needed if using default animations

onMounted(()=>{
  checkToken(true);
})
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
