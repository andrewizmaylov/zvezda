<template>
    <section class="mt-6">
        <section class="flex items-center justify-between">
            <h3 class="text_21 font-semibold opacity-75">{{ $t('search')}}</h3>
            <h6 class="text_12 uppercase hover:text-blue-500 cursor-pointer"
                @click="toggleSearchSection">{{ show_search_section ? $t('hide') : $t('show')}}</h6>
        </section>
        <section class="my-6"
                 v-if="show_search_section">
            <TextInputSet :name="'search'"
                          :error="null"
                          v-model="search_input"/>
        </section>
    </section>
</template>
<script setup>
import TextInputSet from '@/Components/TextInputSet.vue';
import {ref, watch} from 'vue';
import {debounce} from 'lodash';
import axios from 'axios';
let show_search_section = ref(false);
let search_input = ref('');
let search_results = ref([]);

const props = defineProps(['model', 'input']);
const emits = defineEmits(['update_results']);

const processSearch = debounce(async (newSearchInput) => {
    search_results.value = await axios.post(route('search_data'), {
        search_input: newSearchInput,
        model: props.model,
        instance_id: props.input.id,
    });
	
    emits('update_results', search_results.value.data);
}, 500);

watch(search_input, (newSearchInput) => {
    processSearch(newSearchInput);
});

let toggleSearchSection = () => {
    if (show_search_section.value) {
        search_results.value = [];
        search_input.value = '';
    }
    show_search_section.value = !show_search_section.value;
};
</script>
