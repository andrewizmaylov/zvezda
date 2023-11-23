<template>
    <section class="grid sm:grid-cols-2 grid-cols-1 gap-4">
        <GameTeamComponent :team="game.first_team"
                           :players="team_a"/>
        <GameTeamComponent :team="game.second_team"
                           :players="team_b"/>
    </section>
</template>
<script setup>
import GameTeamComponent from '@/Pages/Game/Components/GameTeamComponent.vue';
import {onMounted, ref} from 'vue';
import {getTheGame} from '@/Pages/Shared/helpers.js';

let team_a = ref([]);
let team_b = ref([]);

const props = defineProps(['game']);
onMounted(() => {
    getTheGame(props.game).then(response => {
        team_a.value = response.data.team_a;
        team_b.value = response.data.team_b;
    });

});

</script>