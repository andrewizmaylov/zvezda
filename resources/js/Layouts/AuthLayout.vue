<script setup>
import { Head } from '@inertiajs/vue3';
import ThemeWrapper from '@/Layouts/ThemeWrapper.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="bg-red-100">
        <Head :title="title" />
        <ThemeWrapper/>
		

        <slot />
    </div>
</template>
