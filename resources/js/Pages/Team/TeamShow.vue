<template>
    <Head :title="$t('pages.team')" />
	
    <section class="px-4">
        <h1 class="text_21 ">TeamShow</h1>
        <h6>{{ team.name}}</h6>
        <section class="py-2">
            <span class="btn_main btn_ld cursor-pointer"
                  @click="router.delete(route('teams.destroy', {slug: team.slug}))">{{ $t('delete') }}</span>
        </section>
    </section>
</template>
<script setup>
import {Head, router} from '@inertiajs/vue3';
defineProps(['team']);
</script>