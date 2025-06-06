<script setup>

import { ref, onMounted } from 'vue'
import { useUserStore } from '@/stores/user';
import { storeToRefs } from 'pinia'
import { useUtilStore } from '@/stores/util';
import ButtonLink from '@/components/ButtonLink.vue'
import axios from 'axios';
import { push } from 'notivue'
import { usePayStore } from '@/stores/pay'

const { payBoost } = usePayStore()
const { isLoadingPay } = storeToRefs(usePayStore())
const { userPosts, isLoadingUserPosts } = storeToRefs(useUserStore())
const { getUserPosts } = useUserStore()
const { timeAgo } = useUtilStore()
const deleteId = ref(null)
const api = import.meta.env.VITE_SERVER
const isOpenConfirmDelete = ref(false)
onMounted(() => {
    getUserPosts()
})
const isOpenCheckout = ref(false)
const postId = ref(null)


const deletePost = async (id) => {
  try {
    if (!id) {
      push.warning('No post has been selected')
      return
    }
    isOpenConfirmDelete.value = false
    const response = await axios.delete(`post/delete/${id}`)
    push.success(response.data.message)
    

    // Remove the deleted post from userPosts array
    const index = userPosts.value.findIndex(post => post.id === id)
    if (index !== -1) {
      userPosts.value.splice(index, 1)
    }

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

                                <!-- <span v-if="n.is_boosted" class="text-xs text-gray-600">Boost Expires in 2 days</span> -->
                                <button v-if="!n.is_rented" @click="() => { isOpenCheckout = true; postId = n.id }"
                                    class="flex items-center py-1 px-2 rounded-xl bg-accent text-white hover:brightness-110 gap-2">Not
                                    Rented</button>
                                <button v-else type="button"
                                    class="flex   items-center cursor-pointer  py-1 px-2 rounded-xl bg-green-500 text-white  gap-2">
                                    Rented</button>

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
                                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span
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
                                <span class="text-accent font-semibold"><span>₹{{ n?.price }}</span><span
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

                    <div class="flex flex-col md:flex-row w-full  gap-2 ">
                        <ButtonLink :isLink="false" type="button" content="Proceed" :fun="() => { deletePost(deleteId) }" />
                        <ButtonLink :isLink="false" type="button" content="Cancel "
                            :fun="() => { isOpenConfirmDelete = false }" />
                    </div>
                </div>
            </Transition>
        </div>


        <div class="fixed inset-0 z-30 pointer-events-none">
            <!-- Overlay -->
            <Transition>
                <div v-if="isOpenCheckout" class="w-full h-full bg-black/60 backdrop-blur-sm pointer-events-auto"
                    @click="isOpenCheckout = false"></div>
            </Transition>

            <!-- Modal -->
            <Transition>
                <div v-if="isOpenCheckout"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full px-4  max-h-screen overflow-y-auto">
                    <div class="flex flex-col md:flex-row gap-2 max-w-4xl mx-auto pointer-events-auto">
                        <!-- Boost Plan Card -->
                        <div class="flex-1 min-w-[280px] bg-white p-6  rounded-lg shadow-lg">
                            <div
                                class="border-2 border-blue-500 rounded-lg h-full p-4 bg-blue-50 shadow hover:shadow-xl transition-all">
                                <h2 class="text-xl font-semibold mb-2 text-blue-700">Boosted Listing</h2>
                                <p class="text-blue-600 mb-4">Ideal for individuals with single listing.</p>
                                <div class="text-3xl font-bold text-blue-800 mb-4">₹99</div>
                                <ul class="space-y-2 mb-6 text-sm text-blue-800">
                                    <li>✅ 1 Listing Boost</li>
                                    <li>✅ Appearing at the top of search results</li>
                                    <li>✅ Featured on Homepage</li>
                                    <li>✅ Boost lasts 7 days</li>
                                </ul>

                            </div>
                        </div>

                        <!-- Order & Payment Section -->
                        <div class="flex-1 min-w-[280px] bg-white p-8   rounded-lg shadow-lg">
                            <div class="flex flex-col gap-2 border border-gray-200 rounded-lg p-6">
                                <!-- <div class=" border-t ">
                                    <h3 class="text-lg font-semibold">Order Summary</h3>
                                    <ul class="text-sm space-y-2 text-gray-700">
                                        <li><strong>Item:</strong> Boost Listing</li>
                                        <li><strong>Price:</strong> ₹99</li>
                                        <li><strong>Total:</strong> ₹99</li>
                                    </ul>
                                </div> -->

                                <h2 class="text-xl font-semibold ">Payment</h2>
                                <p class="text-sm text-gray-600 ">
                                    To proceed with the payment, click the button below. You'll be redirected to Razorpay to
                                    complete the transaction securely.
                                </p>

                                <button :disabled="isLoadingPay" id="razorpay-button" @click="payBoost(99, postId)"
                                    type="button"
                                    class="w-full bg-blue-600 rounded-3xl text-white py-2  font-semibold hover:bg-blue-700 transition">
                                    <span v-if="isLoadingPay">Loading..</span>
                                    <span v-else @click="isOpenCheckout = false">Pay with Razorpay</span>
                                </button>

                                <ButtonLink content="Cancel" type="button" :isLink="false"
                                    :fun="() => { isOpenCheckout = false }" />
                            </div>
                        </div>
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