<template>
    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'textarea_set_'+name"
                    :value="$t('form_base.'+name)"/>
        <textarea cols="30"
                  :id="'textarea_set_'+name"
                  :rows="rows"
                  class="form_element"
                  :value="modelValue"
                  @input="$emit('update:modelValue', $event.target.value)"
                  ref="input">
        </textarea>
        <InputError :message="error"
                    class="mt-2"/>
    </div>
</template>
<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

defineProps(['modelValue', 'rows', 'error', 'name']);
defineEmits(['update:modelValue']);
</script>