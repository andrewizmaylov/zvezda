<template>
    <section class="flex items-center justify-between">
        <h5 class="text_24">{{ $t('pages.'+model.toLowerCase()) }}: {{ input?.id ? $t('pages.edit') : $t('pages.create') }}</h5>
        <Link class="btn_interface_blue btn_interface_rectangle text_14"
              :href="route(model_route(model.toLowerCase()) + '.index')">{{ $t('pages.'+model.toLowerCase())}}: {{ $t('all_button') }}
        </Link>
    </section>
    <section class="my-12 mx-auto"
             v-if="input?.id">

        <slot v-if="tab_selected === 1"></slot>
		
        <section class="my-4 flex items-center space-x-4">
            <span class="btn_main cursor-pointer"
                  :class="tab_selected === tab.id ? 'btn_ld':'btn_ld_border'"
                  v-for="tab in tabs"
                  :key="tab.id"
                  @click="selectTab(tab)">{{ tab.name }}</span>
        </section>
    </section>
</template>
<script setup>
import { Link} from '@inertiajs/vue3';
import {ref} from 'vue';
import {model_route} from '@/Pages/Shared/useForms.js';

defineProps(['model', 'input', 'tabs']);
let tab_selected = ref(1);

let emits = defineEmits(['tab_changed']);
function selectTab(tab) {
    tab_selected.value = tab.id;
    emits('tab_changed', tab.id);
}
</script>