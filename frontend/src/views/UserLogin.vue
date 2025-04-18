<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth';
import { storeToRefs } from 'pinia'
import {ref} from 'vue'
import axios from 'axios';
const { login, isLoadingLogin } = storeToRefs(useAuthStore())
const { handleLogin } = useAuthStore()





</script>
<template>
    <section class="w-full flex items-center justify-center  h-[90vh]">
        <form @submit.prevent="handleLogin" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Login</h2>

            <FormInput id='email' v-model="login.email" label="Email" placeholder="Enter Email" type="email" />
            <FormInput id='password' v-model="login.password" label="Password" placeholder="Enter Password" type="password" />
            <RouterLink to="/user/request-password-reset" class="text-sm hover:underline -">Forgot your password?
            </RouterLink>
            <ButtonLink :loading="isLoadingLogin" content="Login" :isLink="false" type="submit" />
            <RouterLink to="/user/signup" class="text-sm hover:underline ">Don't have and account? Sign up</RouterLink>
        </form>
    </section>
</template>