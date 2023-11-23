<template>
    <section>
        <InputLabel :for="'selector_set_'+name"
                    :value="$t('form_base.'+name)"/>
        <select :id="'selector_set_'+name"
                class="form_element"
                @change="updateParentForm"
                :value="modelValue">
            <option value=0
                    selected
                    disabled
                    hidden>...</option>
            <option :value="element.id"
                    v-for="element in options"
                    :key="element.id">{{ getTitleForSelector(element) }}</option>
        </select>
        <InputError :message="error"
                    class="mt-2"/>
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import {messages} from '@/i18n.js';

const {t} = useI18n();
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: {
        type: [Number,String]
    },
    name: String,
    error: String,
    options: Array,
    i18_key: String,
});

function updateParentForm(event) {
    console.log(event.target.value);
    emit('update:modelValue', typeof event.target.value === 'number' ?
        Number(event.target.value) : String(event.target.value));
}
function getTitleForSelector(element) {
    return props.i18_key && messages.ru[props.i18_key][element.name] ?
        t(props.i18_key +'.'+ element.name) : element.name;
}
</script>
