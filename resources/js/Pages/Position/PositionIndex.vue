<template>
    <Head :title="$t('pages.position')" />
	
    <div class="p-4">
        <section class="grid grid-cols-2 gap-4">
            <PositionCard class="col-span-1 cursor-pointer"
                          @click="router.get(route('positions.edit', {slug: position.slug}))"
                          v-for="position in positions"
                          :key="position.id"
                          :position="position"/>
        </section>
		
        <section class="mt-6 flex w-full">
            <Link class="btn_main btn_ld ml-auto"
                  :href="route('positions.create')">{{ $t('create_button') }}</Link>
        </section>
    </div>
</template>
<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import PositionCard from '@/Pages/Position/Components/PositionCard.vue';

defineProps(['positions']);
</script>