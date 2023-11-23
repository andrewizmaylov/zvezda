<template>
    <section class="col-span-6 sm:col-span-4 flex justify-between mt-8">
        <ActionMessage :on="form.recentlySuccessful"
                       class="mr-3">
            {{ $t('saved') }}
        </ActionMessage>
		
        <PrimaryButton :class="{ 'opacity-25': form.processing }"
                       :disabled="form.processing"
                       @click="submitForm"
                       id="submit_form_button">
            {{ $t('save_button') }}
        </PrimaryButton>
    </section>
</template>
<script setup>
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['form']);

const emits = defineEmits(['update', 'create']);
const submitForm = () => {
    let event = props.form.id ? 'update' : 'create';
    emits(event);
};
</script>