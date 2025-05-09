<script setup>

import { ref, onMounted } from 'vue'
import { useUserStore } from '@/stores/user';
import { storeToRefs } from 'pinia'
import { useUtilStore } from '@/stores/util';
import ButtonLink from '@/components/ButtonLink.vue'
import axios from 'axios';
import { push } from 'notivue'
const { userPosts, isLoadingUserPosts } = storeToRefs(useUserStore())
const { getUserPosts } = useUserStore()
const { timeAgo } = useUtilStore()
const deleteId = ref(null)
const api = import.meta.env.VITE_SERVER
const isOpenConfirmDelete = ref(false)
onMounted(() => {
    getUserPosts()
})

const deletePost = async (id) => {
    try {

        if (!id) {
            push.warning('No post has been selected')
            return
        }

        const response = await axios.delete(`post/delete/${id}`)
        push.success(response.data.message)
        console.log(response.data)
        isOpenConfirmDelete.value = false
        getUserPosts(true)


    } catch (err) {
        console.log(err)

    }

}



</script>
<template>
    <div>
        <div v-if="isLoadingUserPosts" class="w-full flex flex-col animate-pulse">
            <!-- Title -->
            <div class="flex justify-center py-4">
                <div class="relative overflow-hidden h-8 w-32 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>

            <!-- Listings -->
            <div class="flex flex-col py-8 gap-4">
                <div v-for="n in 5" :key="n"
                    class="flex-col flex md:flex-row gap-4 rounded-lg  p-2 relative overflow-hidden">
                    <!-- Image Placeholder -->
                    <div class="overflow-hidden min-w-[300px] rounded-lg h-[200px] bg-gray-200 relative">
                        <div
                            class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                        </div>
                    </div>

                    <!-- Textual Content Placeholder -->
                    <div class="flex flex-col gap-2 flex-1">
                        <div class="flex justify-between items-center">
                            <div class="h-6 w-48 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                            <div class="h-6 w-6 bg-gray-200 rounded-full relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="h-4 w-24 bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="h-4 w-12 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                            <div class="h-4 w-12 bg-gray-200 rounded relative overflow-hidden">
                                <div
                                    class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="h-5 w-32 bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>

                        <div class="h-10 w-full bg-gray-200 rounded relative overflow-hidden">
                            <div
                                class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-else class="w-full flex flex-col">
            <h1 class="text-3xl text-center">Posts</h1>

            <div class="flex flex-col   py-8 gap-4" v-if="userPosts.length > 0">

                <div v-for="n in userPosts" :key="n.id"
                    class="flex-col flex md:flex-row gap-4  rounded-lg hover:bg-gray-100  p-2">
                    <RouterLink :to="`/rental-properties/${n.slug}`" v-if="n?.thumbnail"
                        class="overflow-hidden min-w-[300px]  rounded-lg h-[250px] md:h-[200px]">
                        <img :src="`${api}/${n?.thumbnail}`" class="w-full h-full object-cover" alt="">

                    </RouterLink>

                    <div class="flex flex-col gap-2 w-full" v-if="n.location">
                        <div class="flex justify-between ">
                            <h1 class="text-2xl"><span v-if="n.location?.locality">{{ n?.location?.locality }},</span> <span
                                    v-if="n.location?.city">{{ n?.location?.city }}</span> </h1>
                            <div class="flex gap-2 items-center">

                                <span v-if="n.is_boosted" class="text-xs text-gray-600">Boost Expires in 2 days</span>
                                <button v-if="!n.is_boosted"
                                    class="flex items-center py-1 px-2 rounded-xl bg-green-500 text-white hover:brightness-110 gap-2"><i
                                        class="bx bx-rocket"></i> Boost</button>
                                <button v-else type="button"
                                    class="flex   items-center cursor-default  py-1 px-2 rounded-xl bg-green-500 text-white  gap-2"><i
                                        class="bx bx-rocket"></i> Boosted</button>
                                
                                <i class='bx bx-edit p-2 cursor-pointer rounded-full border hover:bg-gray-200 '></i>
                                <i @click="() => { isOpenConfirmDelete = true; deleteId = n.id }"
                                    class='bx bx-x p-2 cursor-pointer rounded-full border hover:bg-gray-200 '></i>
                            </div>


                        </div>


                        <span class="text-xs text-gray-600 ">{{ timeAgo(n.created_at) }}</span>
                        <div v-if="n?.category == 'shop'">
                            <div class="flex gap-2 items-center">
                                <div class="flex  text-sm items-center">
                                    <i class='bx bx-water'></i>
                                    <span class=" text-gray-600"> <span v-if="n.shop?.water_supply == 'yes'"
                                            class="bx bx-check text-lg text-green-500"></span> <span
                                            class="bx bx-x text-lg text-red-500" v-else></span></span>
                                </div>
                                <div class="flex  text-sm items-center">
                                    <i class='bx bx-bulb'></i>
                                    <span class=" text-gray-600"> <span v-if="n.shop?.electricity == 'yes'"
                                            class="bx bx-check text-lg text-green-500"></span> <span
                                            class="bx bx-x text-lg  text-red-500" v-else></span></span>
                                </div>

                            </div>
                            <div class="flex justify-between w-full">
                                <span class="text-accent font-semibold"><span>₹{{ n?.shop?.price }}</span><span
                                        class="text-xs">/m</span></span>




                            </div>
                            <p class="w-[100%] line-clamp-2 ">
                                {{ n?.shop?.description }}
                            </p>
                        </div>
                        <div v-else>
                            <div class="flex gap-2 items-center">
                                <div class="flex gap-1 text-sm items-center">
                                    <i class='bx bxs-bed '></i>
                                    <span class=" text-gray-600">{{ n.house?.bedroom }}</span>
                                </div>
                                <div class="flex gap-1 text-sm items-center">
                                    <i class='bx bxs-bath'></i>
                                    <span class=" text-gray-600">{{ n.house?.bathroom }}</span>
                                </div>

                            </div>
                            <div class="flex justify-between w-full">
                                <span class="text-accent font-semibold"><span>₹{{ n?.house?.price }}</span><span
                                        class="text-xs">/m</span></span>




                            </div>
                            <p class="w-[100%] line-clamp-2 ">
                                {{ n?.house?.description }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>
            <div v-else class="text-center py-6 text-lg text-gray-600 ">
                You have no posts

            </div>

        </div>

        <div class="fixed  w-full  px- top-0 left-0 z-30 pointer-events-none">
            <Transition>
                <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto"
                    @click="isOpenConfirmDelete = false" v-if="isOpenConfirmDelete">

                </div>


            </Transition>
            <Transition>
                <div v-if="isOpenConfirmDelete"
                    class="absolute   top-1/2 p-8 left-1/2 rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white   flex flex-col gap-2 pointer-events-auto transition-all duration-[0.5s] ease-out">
                    <h3 class="text-xl">Are you sure you want to delete this post?</h3>
                    <p class="text-sm">
                        This action is permanent and cannot be undone. 
                        
                    </p>
                    <p class="text-sm font-semibold">
                        
                        Please note: Any amount paid for listing this post will not be refunded.
                    </p>
                    <div class="flex flex-col md:flex-row w-full  gap-2 ">
                        <ButtonLink :isLink="false" type="button" content="Proceed" :fun="() => { deletePost(deleteId) }" />
                        <ButtonLink :isLink="false" type="button" content="Cancel "
                            :fun="() => { isOpenConfirmDelete = false }" />
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>
<style scoped>
@keyframes lamp-glow {

    0%,
    100% {
        box-shadow: 0 0 1px 1px rgba(34, 197, 94, 0.6);
        opacity: 1;
    }

    50% {
        box-shadow: 0 0 2px 2px rgba(34, 197, 94, 0.9);
        opacity: 0.9;
    }
}

.lamp-glow {
    animation: lamp-glow 2s ease-in-out infinite;
}</style>