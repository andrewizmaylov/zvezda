<template>
    <Head :title="$t('pages.stadium')" />
	
    <div class="p-4">

        <StadiumCard class="col-span-1 cursor-pointer"
                     @click="router.get(route('stadiums.edit', { slug: stadium.slug }))"
                     v-for="stadium in stadiums"
                     :key="stadium.id"
                     :stadium="stadium"/>

		
        <section class="mt-6 flex w-full">
            <Link class="btn_main btn_ld ml-auto"
                  :href="route('stadiums.create')">{{ $t('create_button') }}</Link>
        </section>
    </div>
</template>
<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import StadiumCard from '@/Pages/Stadium/Components/StadiumCard.vue';

defineProps(['stadiums']);
</script>