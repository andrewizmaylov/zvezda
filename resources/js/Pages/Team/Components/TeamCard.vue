<template>
    <section class="ringed rounded w-full p-6">
        <h1 class="text_34">{{ team.name }}</h1>
        <section class="grid grid-cols-2 gap-4">
            <TeamComponent class="col-span-1"
                           :team="team"/>
            <GameComponent class="col-span-1"
                           :team="team"/>
        </section>
        <section class="my-8">
            <h4>{{ $t('pages.news') }}</h4>
            <article v-for="news in team.news"
                     :key="news.id">
            </article>
        </section>
    </section>
</template>
<script setup>
import TeamComponent from '@/Pages/Team/Components/TeamComponent.vue';
import GameComponent from '@/Pages/Team/Components/GameComponent.vue';

defineProps(['team']);
</script>