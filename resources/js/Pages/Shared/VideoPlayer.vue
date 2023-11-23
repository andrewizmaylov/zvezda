<template>
    <div class="mx-auto w-[100%] pt-[56.25%] rounded ringed shadow overflow-hidden relative">
        <iframe class="w-[100%] h-[100%] absolute inset-0"
                :src="url"
                allowfullscreen="1"
                allow="autoplay; encrypted-media; fullscreen; picture-in-picture" />
    </div>
</template>
<script setup>
import {computed} from 'vue';
const props = defineProps(['game']);
let url = computed(() => props.game.details.broadcast ?? 'https://www.youtube.com/embed/g8U3o3TOfSY');
</script>
