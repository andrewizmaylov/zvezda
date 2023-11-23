<template>
    <Head :title="$t('pages.merch')" />
	
    <div class="p-4">
        <section class="grid grid-cols-2 gap-4">
            <MerchCard class="col-span-1 cursor-pointer"
                       @click="router.get(route('merch.edit', {slug: element.slug}))"
                       v-for="element in merch"
                       :key="element.id"
                       :input="element"/>
        </section>
		
        <section class="mt-6 flex w-full">
            <Link class="btn_main btn_ld ml-auto"
                  :href="route('merch.create')">{{ $t('create_button') }}</Link>
        </section>
    </div>
</template>
<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import MerchCard from '@/Pages/Merch/Components/MerchCard.vue';
defineProps(['merch']);

</script>