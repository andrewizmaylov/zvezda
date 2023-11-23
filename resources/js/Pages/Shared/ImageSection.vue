<template>
    <section class="rounded ringed p-4 my-4 shadow"
             v-if="input.length">
        <h4 class="mb-6 text_21 font-semibold opacity-75">{{ $t('file_pond.'+title) }}</h4>
        <section class="grid grid-cols-6 gap-4 my-6">
            <div class="col-span-1 rounded w-full h-[100px] ringed overflow-hidden bg-gray-200 shadow relative"
                 v-for="image in input"
                 :key="image.id">
                <img class="w-full h-full object-contain"
                     :src="cloud_path + image.link"
                     alt="image">
                <span v-html="title === 'trashed' ? collection.arrow.path : collection.trash.path"
                      class="absolute right-2 bottom-2 text-gray-700 bg-white ringed rounded-full p-[3px] cursor-pointer"
                      @click="toggleImage(image)"/>
            </div>
        </section>
    </section>
</template>
<script setup>
import {cloud_path} from '@/Pages/Shared/helpers.js';
import {collection} from '@/Pages/Utilities/assets.js';

const props = defineProps(['input', 'title']);
let emits = defineEmits(['toggle']);

function toggleImage(image) {
    emits('toggle', {image: image, title: props.title});
}
</script>
