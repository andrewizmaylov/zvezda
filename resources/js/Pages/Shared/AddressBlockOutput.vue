<template>
    <section class="text_14 font-play text_ld flex items-center justify-between cursor-pointer"
             @click="show_map = !show_map">
        <h4>
            {{ input.address.city }}, {{ input.street_01 }} {{ input.street_02 }}
        </h4>
        <span class="">{{ show_map ? $t('form_base.hide_map') : $t('form_base.show_map') }}</span>
    </section>
    <div class="w-full h-auto"
         v-if="show_map">
        <img :src="input.image"
             alt="map_image"
             v-if="input.image">
        <section class="w-full rounded ringed h-32 grid place-items-center">
            {{ $t('form_base.load_map') }}
        </section>
    </div>
</template>
<script setup>
import {ref} from 'vue';
defineProps(['input']);
let show_map = ref(false);
</script>