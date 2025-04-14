<script setup>
import { RouterLink } from 'vue-router';

const props = defineProps({
    content: {
        type: String,
        default: ""
    },
    link: {
        type: String,
        default: ""
    },
    isLink: {
        type: Boolean,
        default: true
    },

    extraStyle: {
        type: String,
        default: ''
    },

    fun: {
        type: Function,
        default: () => {

        }
    },
    type: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        default: ''

    }

})
</script>
<template>
    <RouterLink v-if="isLink" :to="props.link" :class="extraStyle"
        class="flex items-center justify-center gap-2 cursor-pointer p-[6px] px-5 text-center rounded-3xl bg-accent hover:brightness-110 active:brightness-100  text-white">
        <i v-if="icon" :class="icon"></i> <span>{{ props.content }}</span></RouterLink>
    <button :type="type" v-else @click="props.fun" :class="extraStyle" 
        class="flex items-center justify-center gap-2 cursor-pointer p-[6px] px-5 rounded-3xl  bg-accent hover:brightness-110 active:brightness-100  text-white">
        <i v-if="icon" :class="icon"></i> <span>{{ props.content }}</span></button>
</template>
