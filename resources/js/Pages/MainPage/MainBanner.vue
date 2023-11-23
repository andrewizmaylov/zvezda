<template>
    <div class="w-full h-auto rounded-[6px] ringed overflow-hidden my-6">
        <img :src="banner_image"
             class="scale-[103%]"
             alt="banner">
    </div>
</template>
<script setup>
import {computed} from 'vue';

let banner_image = computed(() => '/img/banners/banner_top.jpeg');
</script>