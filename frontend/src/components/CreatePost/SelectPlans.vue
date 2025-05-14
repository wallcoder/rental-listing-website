<script setup>
import { ref, onMounted } from 'vue'
import { usePlanStore } from '@/stores/plan'
import { usePayStore } from '@/stores/pay'
import { storeToRefs } from 'pinia'
import ButtonLink from '@/components/ButtonLink.vue'

const { handlePayment } = usePayStore()
const { isLoadingPay } = storeToRefs(usePayStore())
const { plans, isLoadingPlans } = storeToRefs(usePlanStore())
const { getPlans } = usePlanStore()
const isOpenCheckout = ref(false)
onMounted(() => {
    getPlans()
})
</script>
<template>
    <section>

        <div v-if="isLoadingPlans" class="flex flex-col gap-8 py-10 border-gray-300">
            <!-- Title Skeleton -->
            <!-- <div class="flex justify-center">
                <div class="relative overflow-hidden h-10 w-56 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div> -->

            <!-- Plans Grid Skeleton -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 max-w-7xl md:mx-auto">
                <div v-for="n in 3" :key="n" class=" rounded-2xl p-6  shadow-sm bg-gray-100 relative overflow-hidden">
                    <!-- Shimmer overlay -->
                    <div
                        class="absolute inset-0  -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                    <!-- Content blocks -->
                    <div class="space-y-4">
                        <div v-for="n in 3" :key="n" class="h-6 w-[300px]  rounded"></div>


                        <div class="space-y-2">
                            <div v-for="i in 4" :key="i" class="h-4 w-full  rounded"></div>
                        </div>
                        <div class="h-10 w-full  rounded-3xl"></div>
                    </div>
                </div>
            </div>
        </div>


        <div v-else class="flex flex-col  py-10 border-gray-300">
            <h1 class="text-2xl text-center">Select Plan</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 max-w-7xl   md:mx-auto">
                <!-- Free Plan -->
                <div class=""
                    :class="p.name === 'boosted' ? 'border-2 border-blue-500 rounded-2xl p-6 shadow-md hover:shadow-xl transition-all bg-blue-50' : 'border rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all'"
                    v-for="p in plans" :key="p.name">
                    <h2 class="text-xl font-semibold mb-2" v-if="p?.name === 'free'">Free Plan</h2>
                    <h2 class="text-xl font-semibold mb-2 text-blue-700" v-else-if="p?.name === 'boosted'">Boosted Listing
                    </h2>
                    <h2 class="text-xl font-semibold mb-2" v-else-if="p?.name === 'agent'">Agent Plan</h2>

                    <p class="text-gray-500 mb-4" v-if="p?.name === 'free'">Ideal for individuals with single listing. No
                        payment required.</p>
                    <p class="text-blue-600 mb-4" v-else-if="p?.name === 'boosted'">Ideal for individuals with single
                        listing.
                    </p>
                    <p class="text-gray-500 mb-4" v-else-if="p?.name === 'agent'">Perfect for realtors and frequent listers.
                    </p>


                    <div class="text-3xl font-bold mb-4" v-if="p?.name === 'free'">₹{{ p.price }}</div>
                    <div class="text-3xl font-bold text-blue-800 mb-4" v-else-if="p?.name === 'boosted'">₹{{ p.price }}
                    </div>
                    <div class="text-3xl font-bold mb-4" v-else-if="p?.name === 'agent'">₹{{ p.price }}</div>

                    <ul class="space-y-2 mb-6 text-sm" v-if="p?.name === 'free'">
                        <li>✅ 1 Active Listing (visible for 1 month)</li>
                        <li>❌ No Featured Placement</li>
                        <li>❌ No Dashboard Insights</li>
                    </ul>
                    <ul class="space-y-2 mb-6 text-sm" v-else-if="p?.name === 'boosted'">
                        <li>✅ 1 Listing Boost</li>
                        <li>✅ Appearing at the top of search results</li>
                        <li>✅ Featured on Homepage</li>
                        <li>✅ Boost lasts 7 days</li>
                    </ul>
                    <ul class="space-y-2 mb-6 text-sm" v-else-if="p?.name === 'agent'">
                        <li>✅ Unlimited Listings</li>
                        <li>✅ 5 Free Boosts per Month</li>
                        <li>✅ Analytics Dashboard</li>
                        <li>✅ Verified Badge</li>
                    </ul>
                    <button type="submit" v-if="p?.name === 'free'"
                        class="w-full bg-gray-200 text-gray-800 py-2 rounded-3xl font-semibold hover:bg-gray-300">
                        Post Now (FREE)
                    </button>
                    <button type="button" v-else-if="p?.name === 'boosted'" @click="isOpenCheckout = true"
                        class="w-full bg-blue-600 text-white py-2 rounded-3xl font-semibold hover:bg-blue-700">
                        Post Now (With Boost)
                    </button>
                    <button v-else-if="p?.name === 'agent'"
                        class="w-full bg-accent text-white py-2 rounded-3xl font-semibold hover:brightness-110">
                        Subscribe Now
                    </button>
                </div>


            </div>



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
                                <div class=" border-t ">
                                    <h3 class="text-lg font-semibold">Order Summary</h3>
                                    <ul class="text-sm space-y-2 text-gray-700">
                                        <li><strong>Item:</strong> Boost Listing</li>
                                        <li><strong>Price:</strong> ₹99</li>
                                        <li><strong>Total:</strong> ₹99</li>
                                    </ul>
                                </div>

                                <h2 class="text-xl font-semibold ">Payment</h2>
                                <p class="text-sm text-gray-600 ">
                                    To proceed with the payment, click the button below. You'll be redirected to Razorpay to
                                    complete the transaction securely.
                                </p>

                                <button :disabled="isLoadingPay" id="razorpay-button" @click="handlePayment()" type="button"
                                    class="w-full bg-blue-600 rounded-3xl text-white py-2  font-semibold hover:bg-blue-700 transition">
                                    <span v-if="isLoadingPay">Loading..</span>
                                    <span v-else>Pay with Razorpay</span>
                                </button>

                                <ButtonLink content="Cancel" type="button" :isLink="false"
                                    :fun="() => { isOpenCheckout = false }" />
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>


    </section>
</template>