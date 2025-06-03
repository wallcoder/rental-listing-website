<script setup>
import { ref } from 'vue'

const guest = ref({
    name: '',
    email: '',
    phone: ''
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
</script>



<template>
    <div class="container mx-auto min-h-[80vh] px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Guest Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Booking Summary (Static with Image) -->




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
        <div class="flex flex-col gap-2">
            <div class="bg-white p-6 rounded-2xl shadow">
                <!-- Image Slot -->

                <h2 class="text-xl font-semibold mb-4">Booking Summary</h2>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span class="font-medium">Homestay:</span>
                        <span>Hilltop Cozy Cottage</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Check-in:</span>
                        <span>June 15, 2025</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Check-out:</span>
                        <span>June 18, 2025</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Guests:</span>
                        <span>2 </span>
                    </div>
                </div>
            </div>
            <div class="sticky top-24 h-fit bg-white p-6 rounded-2xl shadow">
            
            <h2 class="text-xl font-semibold mb-4">Price summary</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>₹1500 x 3 nights</span>
                    <span>₹4500</span>
                </div>
                <div class="flex justify-between">
                    <span>Service Fee</span>
                    <span>₹500</span>
                </div>
                <div class="flex justify-between">
                    <span>Taxes</span>
                    <span>₹300</span>
                </div>
                <hr class="my-2" />
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span>₹5300</span>
                </div>
            </div>

            <button @click="submit" :disabled="loading"
                class="flex items-center text-white bg-accent hover:brightness-110 justify-center gap-2 cursor-pointer p-[6px] px-5 rounded-3xl active:brightness-100 disabled:bg-gray-500 w-full mt-4">
                <span v-if="!loading">Confirm and Pay</span>
                <span v-else>Loading...</span>
            </button>
        </div>
        </div>

        <!-- Right: Price Summary -->

    </div>
</template>

