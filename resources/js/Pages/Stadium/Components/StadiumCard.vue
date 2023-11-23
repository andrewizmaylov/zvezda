<template>
    <div class="w-full ringed rounded p-6 bg-red-100 my-1">
        <h4>{{ stadium.name }}</h4>
    </div>
</template>
<script setup>
import {Link, router} from '@inertiajs/vue3';

defineProps(['stadium']);
</script>