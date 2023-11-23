<template>
    <section class="rounded ringed p-4 grid place-items-center h-40 cursor-pointer shadow-md hover:shadow-element duration-150"
             :class="selected ? 'bg-red-100':''">
        <h6 class="text_12 uppercase">{{ team.name }}</h6>
        <h6 class="text_12 font-semibold text-red-500"
            v-if="selected">{{ $t('unlink') }}</h6>
    </section>
</template>
<script setup>
defineProps(['team', 'selected']);
</script>