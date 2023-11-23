<template>
    <section class="p-6 opacity-0">
        <h6 class="mt-4 text_ld">Intermediate page to redirect for edit just created content</h6>
        <div class="p-12 rounded bg-white my-16 w-1/3 shadow">
            {{ input.name }}
        </div>
		
        <button id="edit_latest_element"
                @click="editContent"
                class="btn button_secondary">Edit content</button>
    </section>
</template>
<script setup>
import {onMounted} from 'vue';
import {router} from '@inertiajs/vue3';
import {model_route} from '@/Pages/Shared/useForms.js';

const props = defineProps(['input', 'model']);

onMounted(() => {
    redirect();
});

const redirect = () => {
    // router.get(route(`${model_route(props.model.toLowerCase())}.edit`));
    if (props.model === 'User') {
        router.get(`users/${props.input.id}/edit`);
    } else {
        router.get(`/${model_route(props.model.toLowerCase())}/${props.input.slug}/edit`);
    }
};

</script>

