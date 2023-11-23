<template>
    <h1 class="text_34 font-play font-bold opacity-80 uppercase my-4 text_ld">{{ $t('pages.game')}}</h1>
    <section class="grid grid-cols-2 gap-4">
        <GameCard  v-for="game in games"
                   :key="game.id"
                   :input="game"/>
    </section>
</template>
<script setup>
import GameCard from '@/Pages/Game/Components/GameCard.vue';

const props = defineProps(['games']);
</script>