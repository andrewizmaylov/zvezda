<template>
    <section class="flex items-center space-x-4 p-2 rounded ringed_10 bg_ld_contrast text_ld font-play">
        <div class="h-12 w-12 rounded-full ringed overflow-hidden">
            <img :src="player.profile_photo_url"
                 alt="profile_photo"
                 class="w-full h-full object-cover">
        </div>
        <h1 class="text_34 font-bold opacity-80">#{{ Math.floor(Math.random() * 99) }}</h1>
        <section class="">
            <h4 class="text_16 font-bold">
                {{ player.contact.first_name }} {{ player.contact.last_name }}
            </h4>
            <h6 class="text_12">position 2bd</h6>
        </section>
    </section>
</template>
<script setup>
defineProps(['player']);
</script>