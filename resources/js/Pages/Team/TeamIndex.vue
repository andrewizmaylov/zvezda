<template>
    <Head :title="$t('pages.team')" />
	
    <div class="p-4">
        <section class="grid grid-cols-2 gap-4">
            <TeamCard class="col-span-1 cursor-pointer"
                      @click="router.get(route('teams.edit', {slug: team.slug}))"
                      v-for="team in teams"
                      :key="team.id"
                      :team="team"/>
        </section>

        <section class="mt-6 flex w-full">
            <Link class="btn_main btn_ld ml-auto"
                  :href="route('teams.create')">{{ $t('create_button') }}</Link>
        </section>
    </div>
</template>
<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import TeamCard from '@/Pages/Team/Components/TeamCard.vue';

defineProps(['teams']);
</script>