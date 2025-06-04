<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import dayjs from 'dayjs'
import { storeToRefs } from 'pinia'
import { usePayStore } from '@/stores/pay'
import {push} from 'notivue'
const { handlePayment } = usePayStore()
const { isLoadingPay } = storeToRefs(usePayStore())
const route = useRoute()
const slug = computed(() => route.params.slug)
const checkIn = computed(() => route.query.checkIn)
const checkOut = computed(() => route.query.checkOut)

const isLoading = ref(false)
const info = ref(null)

const guest = ref({
    name: '',
    email: '',
    phone: ''
})

const getCheckoutInfo = async () => {
    try {
        isLoading.value = true;
        console.log("checkin: ", checkIn.value);
        const response = await axios.get(`/checkout-info/${slug.value}`, {
            params: {
                checkin_date: checkIn.value,
                checkout_date: checkOut.value,
            }
        });
        info.value = response.data.data;
    } catch (err) {
        console.log(err);
        // Optionally handle conflict error (409)
        if (err.response?.status === 409) {
            push.error(err.response.data.message || 'Date conflict detected.');
        }
    } finally {
        isLoading.value = false;
    }
};


onMounted(() => {
    getCheckoutInfo()
})

const paymentMethod = ref('card')
const loading = ref(false)

function submit() {
    loading.value = true
    setTimeout(() => {
        alert(`Booking confirmed for ${guest.value.name} using ${paymentMethod.value}.`)
        loading.value = false
    }, 1500)
}


const nights = computed(() => {
    if (!checkIn.value || !checkOut.value) return 0
    const inDate = dayjs(checkIn.value)
    const outDate = dayjs(checkOut.value)
    return outDate.diff(inDate, 'day')
})


const basePrice = computed(() => {
    if (!info?.value || !info?.value.price) return 0
    return parseFloat(info?.value.price) * nights.value
})


const taxes = computed(() => Math.round(basePrice.value * 0.05)) // 5% tax
const total = computed(() => basePrice.value + taxes.value)

</script>



<template>
    <div class="container mx-auto min-h-[80vh] px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 👇 Skeleton Loader (Pulse) -->
        <template v-if="isLoading">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-6 rounded-2xl shadow animate-pulse space-y-4">
                    <div class="h-6 bg-gray-200 rounded w-1/3"></div>
                    <div class="space-y-3">
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="bg-white p-6 rounded-2xl shadow animate-pulse space-y-4">
                    <div class="h-6 bg-gray-200 rounded w-1/2"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow animate-pulse space-y-4 sticky top-24 h-fit">
                    <div class="h-6 bg-gray-200 rounded w-1/2"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                        <div class="h-4 bg-gray-300 rounded w-1/2 mx-auto mt-4"></div>
                    </div>
                </div>
            </div>
        </template>

        <!-- 👇 Actual Content -->
        <template v-else>
            <div class="lg:col-span-2 space-y-8">
                <!-- Guest Info -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-semibold mb-4">Your details</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" v-model="guest.name" class="w-full border rounded-lg px-3 py-2"
                                placeholder="John Doe" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" v-model="guest.email" class="w-full border rounded-lg px-3 py-2"
                                placeholder="john@example.com" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Phone</label>
                            <input type="tel" v-model="guest.phone" class="w-full border rounded-lg px-3 py-2"
                                placeholder="+1234567890" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking & Price Summary -->
            <div class="flex flex-col gap-2">
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-semibold mb-4">Booking Summary</h2>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="font-medium">Homestay:</span>
                            <span>{{ info?.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Check-in:</span>
                            <span>{{ checkIn }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Check-out:</span>
                            <span>{{ checkOut }}</span>
                        </div>

                    </div>
                </div>

                <div class="sticky top-24 h-fit bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-semibold mb-4">Price summary</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>₹{{ parseFloat(info?.price).toFixed(0) }} x {{ nights }} {{ nights === 1 ? 'night' :
                                'nights' }}</span>
                            <span>₹{{ basePrice }}</span>
                        </div>
                        <!-- <div class="flex justify-between">
                            <span>Service Fee</span>
                            <span>₹{{ serviceFee }}</span>
                        </div> -->
                        <div class="flex justify-between">
                            <span>Tax(5%)</span>
                            <span>₹{{ taxes }}</span>
                        </div>
                        <hr class="my-2" />
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span>₹{{ total }}</span>
                        </div>
                    </div>
                  
                    
                    <button @click="handlePayment(total, info?.user?.merchant_id, info?.id, checkIn, checkOut, guest.name, guest.email, guest.phone)" :disabled="loading"
                        class="flex items-center text-white bg-accent hover:brightness-110 justify-center gap-2 cursor-pointer p-[6px] px-5 rounded-3xl active:brightness-100 disabled:bg-gray-500 w-full mt-4">
                        <span v-if="!isLoadingPay">Confirm and Pay</span>
                        <span v-else>Loading...</span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</template>


