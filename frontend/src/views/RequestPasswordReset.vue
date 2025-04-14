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
            <h2 class="text-lg font-semibold">Request Password Reset</h2>
            <FormInput label="Email" placeholder="Enter Email" type="email" />
            
            <span  class="text-sm  ">Your password reset link has been sent to the provided email.
            </span>
            <span  class="text-sm  ">You can resend in <span class="text-accent">00:30</span>
            </span>
            <ButtonLink content="Send" :isLink="false" type="submit" />
            
        </form>
    </section>
</template>