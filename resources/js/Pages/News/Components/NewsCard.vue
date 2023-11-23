<template>
    <div class="relative rounded border-2 border-white shadow overflow-hidden cursor-pointer ringed"
         style="padding-top: 75%;"
         @click="router.get(route('news.show', {slug: input.slug}))">

        <div class="absolute inset-0 w-full h-full">
            <section class="p-2 absolute w-full backdrop-blur-md bottom-0 backdrop-brightness-200">
                <h3 class="text_21 font-semibold">{{input.name}}</h3>
                <p class="absolute text_12">{{input.description}}</p>
            </section>
            <img class="w-full h-full object-cover"
                 :src="input?.image_url ?? '/img/empty.svg'"
                 alt="cover_image">
        </div>

    </div>
</template>
<script setup>
import {router} from '@inertiajs/vue3';

defineProps(['input']);
</script>
