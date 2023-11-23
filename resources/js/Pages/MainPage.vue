<template>
    <Head :title="$t('pages.main')" />
    <section class="lg:p-6 md:p-4 sm:p-3 p-2">
        <NewSwiper :input="news"/>

        <BannerMain />

        <MainGames :games="games"/>
	    
        <MainBannerKids />

        <VideosMain />
	    
        <PartnersMain />
    </section>
</template>
<script setup>
import {Head} from '@inertiajs/vue3';
import NewSwiper from '@/Pages/MainPage/NewSwiper.vue';
import BannerMain from '@/Pages/MainPage/MainBanner.vue';
import MainGames from '@/Pages/MainPage/MainGames.vue';
import MainBannerKids from '@/Pages/MainPage/MainBannerKids.vue';

defineOptions({layout: null});
const props = defineProps(['news', 'games']);


</script>