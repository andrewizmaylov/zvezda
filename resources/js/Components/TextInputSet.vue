<template>
    <section>
        <InputLabel :for="'text_input_set_'+name"
                    :value="$t('form_base.'+name)"/>
        <input
            :id="'text_input_set_'+name"
            ref="input"
            :type="input_type ?? 'text'"
            class="form_element"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
        <InputError :message="error"
                    class="mt-2"/>
    </section>
</template>
<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    name: String,
    error: String,
    input_type: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

</script>