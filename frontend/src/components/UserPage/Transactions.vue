<script setup>

import { ref, onMounted } from 'vue'
import { useUserStore } from '@/stores/user';
import { storeToRefs } from 'pinia'
import { useUtilStore } from '@/stores/util';
import ButtonLink from '@/components/ButtonLink.vue'
import axios from 'axios';
import { push } from 'notivue'
import { usePayStore } from '@/stores/pay'



const { userTransactions, isLoadingUserTransactions } = storeToRefs(useUserStore())

const { getUserTransactions } = useUserStore()

onMounted(() => {
    getUserTransactions()
})

</script>
<template>
    <div>

        <div v-if="isLoadingUserTransactions" class="w-full flex flex-col animate-pulse">
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
            <h1 class="text-3xl text-center">Transactions</h1>
            <!-- <pre>
                 {{ userTransactions }}
            </pre> -->
           
            <div v-if="userTransactions?.length != 0" class="flex flex-col   py-8 gap-4">
                
                <div class="flex flex-col py-8 gap-4">
                    <div v-for="t in userTransactions" :key="t.id"
                        class="flex flex-col md:flex-row justify-between gap-4 rounded-lg hover:bg-gray-100 p-4 border">
                        <!-- Left: Basic Info -->
                        <div class="flex flex-col gap-2 w-full md:w-2/3">
                            <div class="text-lg font-semibold text-gray-800">
                                ₹{{ (parseFloat(t?.amount)).toFixed(2) }} <span class="text-sm text-gray-500">({{
                                    t?.currency }})</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Booking</span> {{ t?.purpose }}
                            </div>
                            <div class="text-sm text-gray-600" v-if="t?.post_id">
                                <span class="font-medium">Post ID:</span> {{ t?.post_id }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Order ID:</span> {{ t?.order_id }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Reference ID:</span> {{ t?.ref_id }}
                            </div>
                        </div>

                        <!-- Right: Status & Date -->
                        <div class="flex flex-col justify-between text-right w-full md:w-1/3">
                            <span class="text-sm px-3 py-1 rounded-full w-fit self-end" :class="{
                                'bg-green-100 text-green-700': t?.status === 'success',
                                'bg-red-100 text-red-700': t?.status === 'failed'
                            }">
                                {{ t?.status }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ new Date(t?.created_at).toLocaleString() }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            <div v-else class="text-center py-6 text-lg text-gray-600 ">
                You have no transactions

            </div>

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
}
</style>