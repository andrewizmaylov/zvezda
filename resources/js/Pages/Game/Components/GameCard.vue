<template>
    <div class="relative rounded shadow-tag overflow-hidden cursor-pointer ringed hover:shadow-element duration-150"
         style="padding-top: 75%;"
         @click="router.get(route('games.show', {slug: input.slug}))">
		
        <div class="absolute inset-0 w-full h-full rounded overflow-hidden">
            <img class="w-full h-full"
                 :class="cover_image === default_image ? 'object-contain':'object-cover'"
                 :src="cover_image"
                 alt="cover_image">
        </div>
        <section class="p-2 absolute w-full backdrop-blur-md left-0 right-0 bottom-0 backdrop-brightness-200 overflow-hidden rounded-b">
            <section class="flex items-center justify-between">
                <h3 class="text_21 font-semibold">{{input?.first_team?.name}}</h3>
                <h3 class="text_21 font-semibold">{{input?.second_team?.name}}</h3>
            </section>
            <section class="flex items-center justify-center text_12 w-full">
                <h5 class="whitespace-nowrap">{{input.date}} </h5>
                <h5 class="border-l pl-3 ml-3">{{ input?.stadium?.name ?? $t('stadium_later') }}</h5>
            </section>
        </section>
    </div>
</template>
<script setup>
import {router} from '@inertiajs/vue3';
import {default_image} from '@/Pages/Shared/helpers.js';
import {computed} from 'vue';

const props = defineProps(['input']);

let cover_image = computed(() => props.input?.image_url ?? default_image);

</script>
