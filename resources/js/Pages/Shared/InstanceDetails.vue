<template>
    <form v-if="show_form">
        <section class="mb-4"
                 v-for="(field, index) in details"
                 :key="field.index">

            <section class="flex items-center relative cursor-pointer my-4"
                     v-if="field.type === 'checkbox'"
                     @click="form[field.model] = !form[field.model]">
                <div class="absolute inset-0">&nbsp;</div>
                <input type="checkbox"
                       class="rounded small mr-3"
                       :checked="form[field.model] === true">
                <span class="text_12 uppercase font-semibold">{{ field.label }}</span>
            </section>
			
            <section v-else>
                <InputLabel :for="'generated_'+field.model+index"
                            :value="$t('form_base.'+field.model)"/>

                <!-- input text | email | password | number -->
                <input :type="field.type"
                       :id="'generated_'+field.model+index"
                       :placeholder="field.placeholder"
                       v-if="['text','email','password','number'].includes(field.type)"
                       v-model="form[field.model]"
                       min="0"
                       step="1"
                       class="form_element">

                <!-- input textarea -->
                <textarea :id="'generated_'+field.model+index"
                          v-if="field.type === 'textarea'"
                          :placeholder="field.placeholder"
                          cols="30"
                          rows="10"
                          v-model="form[field.model]"
                          class="form_element" />

                <!-- input select -->
                <select :id="'generated_'+field.model+index"
                        v-if="field.type === 'select'"
                        v-model="form[field.model]"
                        class="form_element">
                    <option value=0
                            selected
                            disabled
                            hidden>...
                    </option>
                    <option :value="element.id"
                            v-for="element in field.options"
                            :selected="element.id === form[field.model]"
                            :key="element.id">{{ $t('roles.' + element.name) }}
                    </option>
                </select>
            </section>
        </section>

        <section class="col-span-6 sm:col-span-4 flex justify-between mt-8">
            <span :class="success ? 'opacity-100 duration-[20ms]':'opacity-0 duration-[1000ms]'"
                  class="mr-3 text-sm text-gray-600 dark:text-gray-400"
                  id="success_message">
                {{ $t('saved') }}
            </span>
            <PrimaryButton @click="emits('update_details', form)">{{ $t('save_button') }}</PrimaryButton>
        </section>
    </form>
    
    <section class="grid place-items-center h-[400px]"
             v-if="info_message">
        <span>{{ $t('form_base.provide_details') }}</span>
    </section>
</template>
<script setup>
import {onMounted, ref} from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['input', 'details']);
let show_form = ref(false);
let form = ref({});
let success = ref(false);
let info_message = ref(false);

onMounted(() => {
    Event.on('successfully_updated', () => {
        success.value = true;
        setTimeout(() => success.value = false, 3000);
    });
    if (! props.details || ! props.details.length) {
        info_message.value = true;
    } else {
        props.details.forEach(row =>  {
            form.value[row.model] = props.input[row.model] ?? '';
        });
		
        show_form.value = true;
    }
});

const emits = defineEmits(['update_details']);
</script>
