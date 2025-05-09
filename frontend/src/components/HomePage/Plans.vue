<script setup>
import { ref, onMounted } from 'vue'
import { usePlanStore } from '@/stores/plan'
import { storeToRefs } from 'pinia'
const { plans, isLoadingPlans } = storeToRefs(usePlanStore())
const { getPlans } = usePlanStore()

onMounted(() => {
    getPlans()
})
</script>
<template>
    <section>

        <div v-if="isLoadingPlans" class="flex flex-col gap-8 py-10 border-gray-300">
            <!-- Title Skeleton -->
            <div class="flex justify-center">
                <div class="relative overflow-hidden h-10 w-56 bg-gray-100 rounded">
                    <div
                        class="absolute inset-0 -translate-x-full animate-shimmer bg-gradient-to-r from-transparent via-white/60 to-transparent">
                    </div>
                </div>
            </div>

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
            <h1 class="text-3xl font-semibold text-center " v-motion-fade-visible-once>Our <span
                    class="text-accent">Plans</span></h1>
          
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 max-w-7xl   md:mx-auto">
                <!-- Free Plan -->
                <div class="" :class="p.name === 'boosted' ? 'border-2 border-blue-500 rounded-2xl p-6 shadow-md hover:shadow-xl transition-all bg-blue-50':'border rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all'" v-for="p in plans"
                    :key="p.name">
                    <h2 class="text-xl font-semibold mb-2" v-if="p?.name === 'free'">Free Plan</h2>
                    <h2 class="text-xl font-semibold mb-2 text-blue-700" v-else-if="p?.name === 'boosted'">Boosted Listing</h2>
                    <h2 class="text-xl font-semibold mb-2" v-else-if="p?.name === 'agent'">Agent Plan</h2>

                    <p class="text-gray-500 mb-4" v-if="p?.name === 'free'">Ideal for individuals with 1–2 listings.</p>
                    <p class="text-blue-600 mb-4" v-else-if="p?.name === 'boosted'">Ideal for individuals with 1–2 listings.</p>
                    <p class="text-gray-500 mb-4" v-else-if="p?.name === 'agent'">Perfect for realtors and frequent listers.</p>


                    <div class="text-3xl font-bold mb-4" v-if="p?.name === 'free'">₹{{ p.price }}</div>
                    <div class="text-3xl font-bold text-blue-800 mb-4" v-else-if="p?.name === 'boosted'">₹{{ p.price }}/post</div>
                    <div class="text-3xl font-bold mb-4" v-else-if="p?.name === 'agent'">₹{{ p.price }}/mo</div>

                    <ul class="space-y-2 mb-6 text-sm" v-if="p?.name === 'free'">
                        <li>✅ 1 Active Listing</li>
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
                    <button v-if="p?.name === 'free'" class="w-full bg-gray-200 text-gray-800 py-2 rounded-3xl font-semibold hover:bg-gray-300">
                        Current Plan
                    </button>
                    <button v-else-if="p?.name === 'boosted'" class="w-full bg-blue-600 text-white py-2 rounded-3xl font-semibold hover:bg-blue-700">
                        Boost a Listing
                    </button>
                    <button v-else-if="p?.name === 'agent'" class="w-full bg-accent text-white py-2 rounded-3xl font-semibold hover:brightness-110">
                        Subscribe Now
                    </button>
                </div>

               
            </div>

        </div>
    </section>
</template>