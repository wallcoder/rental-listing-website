<script setup>
import ButtonLink from '@/components/ButtonLink.vue'
import FormInput from '@/components/FormInput.vue'
import { ref } from 'vue'
import axios from 'axios'
import { push } from 'notivue'

const kyc = ref({
    email: '',
    phone: '',
    type: 'route',
    reference_id: '',
    legal_business_name: '',
    business_type: 'individual',
    contact_name: '',
    profile: {
        category: 'healthcare',   // hardcoded, no input field
        subcategory: 'clinic',     // hardcoded, no input field
        addresses: {
            registered: {
                street1: '',
                street2: '',
                city: '',
                state: '',
                postal_code: '',
                country: 'IN'
            }
        }
    },
    legal_info: {
        pan: '',
        gst: ''
    }
})

const isLoadingKYC = ref(false)

const submitKYC = async () => {
    try {
        isLoadingKYC.value = true
        const response = await axios.post('/user/kyc', kyc.value)
        push.success(response.data.message)
    } catch (err) {
        console.error(err)
        push.error(err?.response?.data?.details?.error?.description)
    } finally {
        isLoadingKYC.value = false
    }
}
</script>

<template>
    <section class="flex flex-col items-center gap-4">
        <h1 class="text-3xl text-center">KYC</h1>
        <form class="flex flex-col gap-4 w-full md:px-[20%]" @submit.prevent="submitKYC">
            <h1 class="text-xl">KYC Onboarding</h1>

            <!-- Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="email" label="Email" v-model="kyc.email" placeholder="Enter email" />
                <FormInput id="phone" label="Phone" v-model="kyc.phone" placeholder="Enter phone number" />
            </div>

            <!-- Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="referenceId" label="Reference ID" v-model="kyc.reference_id" placeholder="Reference ID" />
                <FormInput id="contactName" label="Contact Name" v-model="kyc.contact_name" placeholder="Contact Name" />
            </div>

            <!-- Row 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="legalBusinessName" label="Legal Business Name" v-model="kyc.legal_business_name"
                    placeholder="Business or Brand Name" />
                <!-- <div>
                    <label for="businessType" class="block text-sm font-medium text-gray-700">Business Type</label>
                    <select id="businessType" v-model="kyc.business_type"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200"
                        required>
                        <option disabled value="">Select business type</option>
                        <option value="individual">Individual</option>
                        <option value="proprietorship">Proprietorship</option>
                        <option value="partnership">Partnership</option>
                        <option value="llp">LLP</option>
                        <option value="private_limited">Private Limited</option>
                        <option value="public_limited">Public Limited</option>
                        <option value="trust">Trust</option>
                        <option value="society">Society</option>
                        <option value="association">Association</option>
                        <option value="government_body">Government Body</option>
                        <option value="huf">HUF</option>
                    </select>
                </div> -->
            </div>

            <!-- Display fixed category/subcategory as text only -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <p class="mt-1 p-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed select-none">
                        Real Estate
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subcategory</label>
                    <p class="mt-1 p-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed select-none">
                        Rental
                    </p>
                </div>
            </div>

            <!-- Address rows -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="street1" label="Street 1" v-model="kyc.profile.addresses.registered.street1"
                    placeholder="Street address" />
                <FormInput id="street2" label="Street 2" v-model="kyc.profile.addresses.registered.street2"
                    placeholder="Optional" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="city" label="City" v-model="kyc.profile.addresses.registered.city" placeholder="City" />
                <FormInput id="state" label="State" v-model="kyc.profile.addresses.registered.state" placeholder="State" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="postalCode" label="Postal Code" v-model="kyc.profile.addresses.registered.postal_code"
                    placeholder="Postal Code" />
                <FormInput id="country" label="Country" v-model="kyc.profile.addresses.registered.country"
                    placeholder="IN" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <FormInput id="pan" label="PAN Number" v-model="kyc.legal_info.pan" placeholder="ABCDE1234F" />
                <FormInput id="gst" label="GST Number" v-model="kyc.legal_info.gst" placeholder="18AABCU9603R1ZM" />
            </div>

            <div>
                <ButtonLink content="Submit KYC" :loading="isLoadingKYC" :isLink="false" type="submit" />
            </div>
        </form>
    </section>
</template>
