<script setup>
import FormInput from '@/components/FormInput.vue'
import { useCreatePostStore } from '@/stores/createPost'
import { storeToRefs } from 'pinia'

const createPost = useCreatePostStore()
const { contactDetails } = storeToRefs(createPost)
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <h2 class="text-xl font-semibold">Contact Details</h2>
        <div class="flex gap-4 flex-wrap">
            
            <FormInput v-model="contactDetails.owner" id="owner" label="Owner's Name" placeholder="Enter Owner's Name" />
            <FormInput v-model="contactDetails.phone" id="phone" label="Phone" type="number" placeholder="Enter Contact Number"/>
            <FormInput v-model="contactDetails.email" id="email" label="Email" type="email" placeholder="Enter valid email"/>
        </div>


    </div>
</template>