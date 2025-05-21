<script setup>

</script>
<template>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-semibold text-center mb-8">Checkout - <span class="text-blue-600">Boost Listing</span></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Boost Details -->
            <div class="bg-white shadow rounded-lg p-6 border">
                <h2 class="text-xl font-semibold mb-4">Boost Details</h2>
                <ul class="text-sm space-y-2 text-gray-700">
                    <li><strong>Listing:</strong> 2BHK Flat in Downtown</li>
                    <li><strong>Boost Duration:</strong> 7 days</li>
                    <li><strong>Featured:</strong> Yes (Homepage + Top Rank)</li>
                    <li><strong>Price:</strong> ₹99</li>
                </ul>
            </div>

            <!-- Payment Section -->
            <div class="bg-white shadow rounded-lg p-6 border">
                <h2 class="text-xl font-semibold mb-4">Payment</h2>

                <p class="text-sm mb-4 text-gray-600">To proceed with the payment, click the button below. You'll be
                    redirected to Razorpay to complete the transaction securely.</p>

                <!-- Razorpay Button -->
                <button id="razorpay-button"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Pay ₹99 with Razorpay
                </button>

                <!-- Order Summary -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold">Order Summary</h3>
                    <ul class="text-sm space-y-2 text-gray-700">
                        <li><strong>Item:</strong> Boost Listing</li>
                        <li><strong>Price:</strong> ₹99</li>
                        <li><strong>Total:</strong> ₹99</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</template>