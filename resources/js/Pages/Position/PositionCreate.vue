<template>
    <Head :title="$t('pages.' + MODEL.toLowerCase())"/>
	
    <section class="form_wrapper">
        <FormHeader :model="MODEL"
                    :input="input"
                    :tabs="tabs"
                    @tab_changed="(id) => tab_selected = id">
                    <!--slot-->
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
		
        <InstanceDetails :details="details"
                         :input="input?.details ?? []"
                         @update_details="updateData"
                         v-if="tab_selected === 2"/>

        <InstanceImages :input="input"
                        :model="MODEL"
                        v-if="tab_selected === 4"/>
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
import {updateDetails} from '@/Pages/Shared/useForms.js';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import InstanceImages from '@/Pages/Shared/InstanceImages.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';

const { t } = useI18n();
const props = defineProps(['input']);
const MODEL = 'Position';

let {form, updateFormField, fillForm, submitForm, updateForm} = useFormComposable(MODEL);

onMounted(() => {
    Event.on(['form_updated', 'file_pond_upload'], () => {
        router.reload({only: ['input']});
        fillForm(props.input);
    });
	
    fillForm(props.input);
});

function updateData(input) {
    let data = Object.assign({
        model: MODEL,
        id: props.input.id,
        field: 'root',
    }, {root: input});
	
    updateDetails(data);
}
let details = [
    { type: 'text', label: 'Name', model: 'contact' },
    { type: 'email', label: 'Email', model: 'email' },
    { type: 'password', label: 'Password', model: 'password' },
    { type: 'textarea', label: 'Description', model: 'description' },
    { type: 'number', label: 'Number', model: 'age' },
    { type: 'checkbox', label: 'Тип характера', model: 'paranoid' },
    {
        type: 'select', label: 'Select', model: 'role',
        options: [
            {id: 1, name: 'admin'},
            {id: 2, name: 'player'},
            {id: 3, name: 'couch'},
            {id: 7, name: 'sudo'},
        ],
    },
];

const tabs = [
    {id: 1, name: t('tabs.main_info')},
    {id: 2, name: t('tabs.details')},
    {id: 4, name: t('tabs.images')},
];

let tab_selected = ref(1);
</script>