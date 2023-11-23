<template>
    <img src="/img/app_logo.png"
         :class="logo_size"
         alt="application logo">
</template>
<script setup>
import {computed} from 'vue';

const props = defineProps(['size']);

let logo_size = computed(() => props.size ? `w-${props.size} h-${props.size}` : 'w-16 h-16');
</script>