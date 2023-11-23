<template>
    <section class="font-play text_ld">
        <h1 class="header_34 text-center my-4">{{ game.first_team.name }} | {{ game.second_team.name }}</h1>
        <section class="text-center"
                 v-if="tab_selected === 3">
            <div class="md:w-2/3 w-full mx-auto rounded-[6px] shadow overflow-hidden my-3 flex items-center relative">
                <img class="w-full h-full object-contain"
                     :src="game.image_url"
                     alt="game_image"
                     v-if="game.image_url">
                <p class="w-[100%] my-auto bg-white py-2 text-center font-play lg:text-[96px] md:text-[72px] text-[50px] font-bold absolute opacity-75"
                   v-if="game.details.count">{{ game.details.count }}</p>
            </div>
            <h1 class="header_21">{{ game?.title }}</h1>
            <h1 class="header_21">{{ game?.date }} {{ game?.time }}</h1>
            <p class="text_16">{{ game?.description }}</p>
        </section>
    </section>
</template>
<script setup>
defineProps(['game', 'tab_selected']);
</script>