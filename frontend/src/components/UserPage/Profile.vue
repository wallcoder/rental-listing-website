<script setup>
import ButtonLink from '@/components/ButtonLink.vue'
import FormInput from '@/components/FormInput.vue'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'
const name = ref('');

const { user } = storeToRefs(useAuthStore())
name.value = user.value.name
</script>

<template>
    <section class="flex gap-10 w-full justify-center flex-wrap ">
        <div class="flex flex-col gap-2 w-full md:w-[300px]">


            <form class="flex flex-col gap-2 w-full ">
                <h1 class="text-xl ">Edit Name</h1>
                <FormInput label="Name" v-model="name" />
                <ButtonLink content="Save" />

            </form>
            
            <button class="text-red-600 text-sm hover:underline">Delete Account</button>
        </div>

        <form class="flex flex-col gap-2 w-full md:w-[300px] ">
            <h1 class="text-xl ">Change Password</h1>
            <FormInput label="Current Password" type="password" />
            <FormInput label="New Password" type="password" />
            <FormInput label="Confirm Password" type="password" />
            <ButtonLink content="Save Password" />
        </form>

    </section>
</template>