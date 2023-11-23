<template>
    <Head :title="$t('pages.game')" />
	
    <div class="grid grid-cols-3 gap-4 p-4">
        <GameCard class=""
                  v-for="element in games"
                  :key="element.id"
                  :input="element"/>
    </div>
</template>
<script setup>
import {Head} from '@inertiajs/vue3';
import GameCard from '@/Pages/Game/Components/GameCard.vue';
const props = defineProps(['games']);
</script>