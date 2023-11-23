<template>
    <section class="text_ld">
        <section class="max-w-[650px] m-6">
	        
            <h3>{{ news.name }}</h3>
            <p>{{ news.description }}</p>
            <div v-html="output" />
        </section>
    </section>
</template>
<script setup>
import {computed} from 'vue';
import {htmlOutput} from '@/Pages/Utilities/HtmlOutput.js';

const props = defineProps(['news']);
let output = computed(() => props.news.text ? htmlOutput(props.news.text.schema) : '');
</script>