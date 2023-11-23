<template>
    <div class="ringed px-1">
        <div class="aspect-w-1 aspect-h-1 rounded-full overflow-hidden mx-auto shrink-0 m-[14px] ringed shadow">
            <img class=" w-full h-full object-cover"
                 :src="user.profile_photo_url"
                 alt="avatar">

        </div>

        <section class="text-center">{{ full_name }}</section>
    </div>
</template>
<script setup>
import {computed} from 'vue';

const props = defineProps(['user']);
let full_name = computed(() => (props.user?.contact?.first_name ?? 'john') +' '+ (props.user?.contact?.last_name ?? 'john'));
</script>