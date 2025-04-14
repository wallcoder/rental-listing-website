<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { RouterLink } from 'vue-router'

const test = () => {
    console.log("jojoj")
}
</script>
<template>
    <section class="w-full flex items-center justify-center h-[90vh]">
        <form class="flex flex-col bg-white p-4 gap-2 w-[300px] rounded-md" @submit.prevent="test">
            <h2 class="text-lg font-semibold">Sign up</h2>
            <FormInput label="Name" placeholder="Enter Name" type="email" id="name"/>
            <FormInput label="Email" placeholder="Enter Email" type="email" id="email" />
            <FormInput label="Password" placeholder="Enter Password" type="password" id="password"/>
            <FormInput label="Confirm Password" placeholder="Confirm Password" type="password" id="confirmPassword"/>
            
            <ButtonLink content="Sign up" :isLink="false" type="submit" />
            <RouterLink to="/user/login" class="text-sm hover:underline -">Already have an account? Log in</RouterLink>
        </form>
    </section>
</template>