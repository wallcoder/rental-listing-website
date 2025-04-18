<script setup>
    import FormInput from '@/components/FormInput.vue'
</script>
<template>
    <div class="rounded-xl bg-white p-4 flex flex-col gap-2 border border-gray-300">
        <h2 class="text-xl">Contact Details</h2>
        <div class="flex gap-4">
            <FormInput label="Phone" />
            <FormInput label="Email" />
        </div>


    </div>
</template>