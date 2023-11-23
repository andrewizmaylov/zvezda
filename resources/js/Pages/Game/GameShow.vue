<template>
    <section class="p-6">
        <GameDetails :game="game"
                     :tab_selected="tab_selected"/>

        <MenuTabs class="mx-auto"
                  :tabs="tabs"
                  :tab_selected="tab_selected"
                  @update_selected="updateSelected"/>

        <GameTeams :game="game"
                   v-if="tab_selected === 1"/>

        <GameShowStadium :stadium="game.stadium"
                         v-if="tab_selected === 2"/>
 
        <section v-if="game.text && tab_selected === 3"
                 v-html="htmlOutput(game.text.schema)"
                 class="font-play"/>

        <VideoPlayer :game="game"
                     v-if="tab_selected === 4"/>

        <ImageSlider :images="game?.details?.images"
                     v-if="game?.details?.images && tab_selected === 5"/>

        <GameTickets :input="game"
                     v-if="tab_selected === 6"/>
	
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
const {t} = useI18n();
import GameDetails from '@/Pages/Game/Components/GameDetails.vue';
import GameTeams from '@/Pages/Game/Components/GameTeams.vue';
import MenuTabs from '@/Components/MenuTabs.vue';
import {ref} from 'vue';
import {htmlOutput} from '@/Pages/Utilities/HtmlOutput.js';
import GameShowStadium from '@/Pages/Game/Components/GameShowStadium.vue';
import VideoPlayer from '@/Pages/Shared/VideoPlayer.vue';
import ImageSlider from '@/Pages/Shared/ImageSlider.vue';
import GameTickets from '@/Pages/Game/Components/GameTickets.vue';

const props = defineProps(['game']);

const tabs = [
    {id: 3, name: t('tabs.anons'), show: true},
    {id: 1, name: t('tabs.teams'), show: true},
    {id: 2, name: t('tabs.stadium'), show: true},
    {id: 4, name: t('tabs.video'), show: props.game?.details?.broadcast},
    {id: 5, name: t('tabs.images'), show: props.game?.details?.images},
    {id: 6, name: t('tabs.tickets'), show: true},
];
let tab_selected = ref(1);
function updateSelected(e) {
    tab_selected.value = e.id;
}
</script>