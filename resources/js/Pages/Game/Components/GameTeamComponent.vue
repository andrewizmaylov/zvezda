<template>
    <section class="space-y-4">
        <section class="flex items-center space-x-4">
            <div class="w-auto h-16 p-1">
                <img class="w-full h-full object-contain"
                     :src="team.logo_url"
                     alt="team_logo">
            </div>
            <h4 class="header_34">{{ team.name }}</h4>
        </section>
        <PlayerComponent :player="player"
                         v-for="player in players"
                         :key="player.id"/>
    </section>
</template>
<script setup>
import PlayerComponent from '@/Pages/Shared/PlayerComponent.vue';
defineProps(['team', 'players']);
</script>