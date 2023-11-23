<template>
    <Head :title="$t('pages.partners')" />
	
    <div class="p-4">
        <section class="grid grid-cols-2 gap-4">
            <PartnerCard class="col-span-1 cursor-pointer"
                         @click="router.get(route('partners.edit', {slug: partner.slug}))"
                         v-for="partner in partners"
                         :key="partner.id"
                         :input="partner"/>
        </section>
		
        <section class="mt-6 flex w-full">
            <Link class="btn_main btn_ld ml-auto"
                  :href="route('partners.create')">{{ $t('create_button') }}</Link>
        </section>
    </div>
</template>
<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import PartnerCard from '@/Pages/Partner/Components/PartnerCard.vue';

defineProps(['partners']);
</script>