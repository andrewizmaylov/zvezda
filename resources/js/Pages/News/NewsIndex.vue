<template>
    <Head :title="$t('pages.news')" />
	
    <div class="grid grid-cols-3 gap-4 p-4">
        <NewsCard class=""
                  v-for="element in news"
                  :key="element.id"
                  :input="element"/>
    </div>
</template>
<script setup>
import {Head} from '@inertiajs/vue3';
import NewsCard from '@/Pages/News/Components/NewsCard.vue';
const props = defineProps(['news']);
</script>