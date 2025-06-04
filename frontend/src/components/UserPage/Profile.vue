<script setup>
import ButtonLink from '@/components/ButtonLink.vue'
import FormInput from '@/components/FormInput.vue'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'
import { push } from 'notivue'
const isOpenConfirmDelete = ref(false)
const name = ref('');
const password = ref({
    current: '',
    new: '',
    confirm: ''
})
const { user, isLoadingEditName, isLoadingChangePassword } = storeToRefs(useAuthStore())
const { checkToken, logout, startLoading, finishLoading } = useAuthStore()
name.value = user.value.name

const editName = async () => {
    try {
        startLoading()
        isLoadingEditName.value = true
        const response = await axios.put('/user/edit-name', {
            id: user.value.id,
            name: name.value
        })

        await checkToken()
        name.value = user.value.name
        push.success(response.data.message)

    } catch (err) {
        console.log(err.response.data.err)
        push.error('Error editing name')


    } finally {
        finishLoading()
        isLoadingEditName.value = false
    }
}

const changePassword = async () => {
    try {
        startLoading()
        isLoadingChangePassword.value = true
        const response = await axios.put('/user/change-password', {
            current_password: password.value.current,
            password: password.value.new,
            confirm_password: password.value.confirm,
        })

        push.success(`${response.data.message}. Logging out..`)

        setTimeout(() => {
            logout()
        }, 1000);

    } catch (err) {
        console.log(err)
    } finally {
        finishLoading()
        isLoadingChangePassword.value = false
    }
}

const deleteAccount = async () => {
    try {
        const response = await axios.delete('/user/delete-account', {

        })

        logout()

    } catch (err) {
        console.log(err)
    } finally {
        isOpenConfirmDelete.value = false
    }
}



</script>

<template>
    <section class=" flex flex-col items-center gap-4">
        <h1 class="text-3xl text-center">Profile</h1>
        <div v-if="!user.email_verified_at" class="flex flex-col gap-2 py-   rounded-lg w-full md:w-[500px] text-center">
            <div class="bg-red-200 flex flex-col p-3 rounded-lg">
                <span class="text-red-800 text-lg">Your email is not verified!!</span>
                <span class="text-sm">Please verify your email address to continue. Certain actions require a verified email. </span>
            </div>
            <div>
                <button class="text-accent hover:underline text-sm">Send Verification Link</button>
            </div>




        </div>

        <div class="flex  gap-10 w-full justify-center flex-wrap">
            <div class="flex flex-col gap-2 w-full md:w-[300px]">


                <form class="flex flex-col gap-2 w-full " @submit.prevent="editName">
                    <h1 class="text-xl ">Edit Name</h1>
                    <FormInput id="name" label="Name" v-model="name" placeholder="Enter Name" />
                    <ButtonLink content="Save" :loading="isLoadingEditName" :isLink="false" type="submit" />

                </form>

                <button class="text-red-600 text-sm hover:underline" @click="isOpenConfirmDelete = true">Delete
                    Account</button>
            </div>


            <form class="flex flex-col gap-2 w-full md:w-[300px] " @submit.prevent="changePassword">

                <h1 class="text-xl ">Change Password</h1>
                <FormInput v-model="password.current" id="currentPassword" label="Current Password" type="password"
                    placeholder="Enter Current Password" />
                <FormInput v-model="password.new" id="password" label="New Password" type="password"
                    placeholder="Enter New Password" />
                <FormInput v-model="password.confirm" id="confirmPassword" label="Confirm Password" type="password"
                    placeholder="Confirm Password" />
                <ButtonLink content="Save Password" :loading="isLoadingChangePassword" :isLink="false" type="submit" />
            </form>


            <div class="fixed  w-full  top-0 left-0 z-30 pointer-events-none">
                <Transition>
                    <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto"
                        @click="isOpenConfirmDelete = false" v-if="isOpenConfirmDelete">

                    </div>


                </Transition>
                <Transition>
                    <div v-if="isOpenConfirmDelete"
                        class="absolute top-1/2 p-8 left-1/2 rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white   flex flex-col gap-2 pointer-events-auto transition-all duration-[0.5s] ease-out">
                        <h3 class="text-xl">Are you sure you want to delete your account?</h3>
                        <p class="text-sm">
                            Deleting your account is permanent and cannot be undone. This will also delete all your posts
                            and personal data associated with your account.
                        </p>
                        <div class="flex flex-col md:flex-row w-full  gap-2 ">
                            <ButtonLink :isLink="false" type="button" content="Proceed" :fun="() => { deleteAccount() }" />
                            <ButtonLink :isLink="false" type="button" content="Cancel "
                                :fun="() => { isOpenConfirmDelete = false }" />
                        </div>
                    </div>
                </Transition>
            </div>
        </div>


    </section>
</template>