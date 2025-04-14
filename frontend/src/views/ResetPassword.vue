<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { RouterLink } from 'vue-router'

const test = () => {
    console.log("jojoj")
}

const props = defineProps({
    token:{
        type: String,
        required: true
    },
    email:{
        type: String,
        required: true
    }
})
</script>
<template>
    <section class="w-full flex items-center justify-center h-[90vh]">
        <form class="flex flex-col bg-white p-4 gap-2 w-[300px] rounded-md" @submit.prevent="test">
            <h2 class="text-lg font-semibold">Reset password</h2>
            <span>Email: {{ email }}</span>
            
            <FormInput label="Password" placeholder="Enter Password" type="password" />
            <FormInput label="Confirm Password" placeholder="Confirm Password" type="password" />
            
            <ButtonLink content="Submit" :isLink="false" type="submit" />
            
        </form>
    </section>
</template>