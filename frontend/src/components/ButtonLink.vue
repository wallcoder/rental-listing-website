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

    },

    loading: {
        type: Boolean,
        default: false
    }


})
</script>
<template>
    <RouterLink v-if="isLink" :to="props.link"
        :class="extraStyle ? extraStyle : 'text-white bg-accent hover:brightness-110'"
        class="flex items-center box-border  justify-center gap-2 cursor-pointer p-[8px] px-5 text-center rounded-3xl    active:brightness-100  ">
        <span>{{ props.content }}</span><i v-if="icon" :class="icon"></i>
    </RouterLink>
    <button :type="type" v-else @click="props.fun" :disabled="loading"
        :class="extraStyle ? extraStyle : 'text-white bg-accent hover:brightness-110 '"
        class="flex  items-center box-border justify-center gap-2 cursor-pointer p-[6px] px-5 rounded-3xl  bg-accent active:brightness-100  text-white disabled:bg-gray-500">
        <div v-if="!loading">
            <span>{{ props.content }}</span><i v-if="icon" :class="icon"></i>
        </div>
        <div v-else>
            Loading..
        </div>
    </button>
</template>
