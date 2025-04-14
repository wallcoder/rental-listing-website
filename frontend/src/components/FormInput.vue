<script setup>
const props = defineProps({
    label: {
        type: String,
        default: ""
    },
    placeholder: {
        type: String,
        default: ""
    },
    modelValue: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: true
    },
    id: {
        type: String,
        default: ""
    }
});
</script>

<template>
    <div class="flex flex-col">
        <label :for="id">{{ label }}</label>
        <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :type="type" :id="id"
            :required="required" :placeholder="placeholder" class="p-2 border rounded-md border-gray-300 outline-none">
    </div>
</template>
