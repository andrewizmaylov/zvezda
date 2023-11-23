<template>
    <Head :title="$t('pages.' + MODEL.toLowerCase())"/>

    <section class="form_wrapper">
        <FormHeader :model="MODEL"
                    :input="input"
                    :tabs="tabs"
                    @tab_changed="(id) => tab_selected = id">
            <!--slot-->
            <ImageBlock :input="input"
                        :model="MODEL"
                        @update_main_form_field="updateFormField"
                        :setup="image_data"/>
        </FormHeader>
			
        <section class="grid grid-cols-6 sm:grid-cols-4 gap-4"
                 v-if="tab_selected === 1">
            <TextInputSet class="col-span-3"
                          :name="'name'"
                          :error="form.errors.name"
                          v-model="form.name"/>

            <TextAreaSet :name="'description'"
                         :rows=10
                         :error="form.errors.description"
                         v-model="form.description"
                         v-if="form.id"/>

            <FormSubmission :form="form"
                            @update="updateForm(form, MODEL)"
                            @create="submitForm(form, MODEL)" />
        </section>

        <TeamMembers :team="input"
                     v-if="tab_selected === 2"/>

        <TextEditor :input="input"
                    :model="MODEL"
                    v-if="tab_selected === 3"/>

        <InstanceDetails v-if="tab_selected === 4"/>
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {Head, router} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';
import TextInputSet from '@/Components/TextInputSet.vue';
import TextAreaSet from '@/Components/TextAreaSet.vue';
import FormHeader from '@/Components/FormHeader.vue';
import FormSubmission from '@/Components/FormSubmission.vue';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import TeamMembers from '@/Pages/Team/Components/TeamMembers.vue';
import TextEditor from '@/Pages/Shared/TextEditor.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';
import ImageBlock from '@/Pages/Shared/BlockImageComponent.vue';

const { t } = useI18n();
const props = defineProps(['input']);
const image_data = {
    css: 'relative w-[400px] h-[300px] rounded-[10px] ringed_10 overflow-hidden',
    field: 'logo',
};

let {form, updateFormField, fillForm, submitForm, updateForm} = useFormComposable('Team');
const MODEL = 'Team';

onMounted(() => {
    Event.on(['form_updated', 'file_pond_upload'], () => {
        router.reload({only: ['input']});
        fillForm(props.input);
    });
	
    fillForm(props.input);
});

const tabs = [
    {id: 1, name: t('tabs.main_info')},
    {id: 2, name: t('tabs.members')},
    {id: 3, name: t('tabs.history')},
    {id: 4, name: t('tabs.details')},
];

let tab_selected = ref(1);
</script>
