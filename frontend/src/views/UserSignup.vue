<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { RouterLink } from 'vue-router'
import {storeToRefs} from 'pinia'
import {useAuthStore} from '@/stores/auth'
const {signUp, isLoadingSignup } = storeToRefs(useAuthStore())
const {handleSignUp}  = useAuthStore()

</script>
<template>
    <section class="w-full flex items-center justify-center h-[90vh]">
        
        <form class="flex flex-col bg-white border  p-6 gap-2 w-[300px] rounded-md" @submit.prevent="handleSignUp">
            <h2 class="text-lg font-semibold">Sign up</h2>
            <FormInput v-model="signUp.name"  label="Name" placeholder="Enter Name" type="text" id="name"/>
            <FormInput v-model="signUp.email" label="Email" placeholder="Enter Email" type="email" id="email" />
            <FormInput v-model="signUp.password" label="Password" placeholder="Enter Password" type="password" id="password"/>
            <FormInput v-model="signUp.confirm_password" label="Confirm Password" placeholder="Confirm Password" type="password" id="confirmPassword"/>
            
            <ButtonLink :loading="isLoadingSignup" content="Sign up" :isLink="false" type="submit" />
            <RouterLink  to="/user/login" class="text-sm hover:underline -">Already have an account? Log in</RouterLink>
        </form>
    </section>
</template>