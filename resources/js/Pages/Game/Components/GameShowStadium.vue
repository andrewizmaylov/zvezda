<template>
    <section>
        <h2 class="header_34 my-4">{{ stadium.name }}</h2>

        <AddressBlockOutput class="my-6"
                            :input="stadium" />

        <section class="flex items-center justify-between cursor-pointer"
                 @click="show_info = !show_info">
            <h2 class="header_21">{{ $t('tabs.main_info')}}</h2>
            <span class="header_34">{{ show_info ? '-' : '+' }}</span>
        </section>
        <article class="font-play mb-6 -mt-12"
                 v-html="htmlOutput(stadium.text.schema)"
                 v-if="stadium.text && show_info" />
    </section>
</template>
<script setup>
import {htmlOutput} from '@/Pages/Utilities/HtmlOutput.js';
import AddressBlockOutput from '@/Pages/Shared/AddressBlockOutput.vue';
import { ref } from 'vue';
defineProps(['stadium']);

let show_info = ref(false);
</script>