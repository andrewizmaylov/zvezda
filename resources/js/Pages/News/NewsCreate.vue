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

        <TextEditor :input="input"
                    :model="MODEL"
                    v-if="tab_selected === 2"/>
        
        <AuthorComponent :input="input"
                         v-if="tab_selected === 3"/>
     
        <TeamComponent :input="input"
                       v-if="tab_selected === 4"/>
        
        <InstanceDetails :details="details"
                         :input="input?.details ?? []"
                         @update_details="updateData"
                         v-if="tab_selected === 5"/>

    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {updateDetails} from '@/Pages/Shared/useForms.js';
import {Head, router} from '@inertiajs/vue3';
import FormSubmission from '@/Components/FormSubmission.vue';
import FormHeader from '@/Components/FormHeader.vue';
import TextAreaSet from '@/Components/TextAreaSet.vue';
import TextInputSet from '@/Components/TextInputSet.vue';
import {onMounted, ref} from 'vue';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import TextEditor from '@/Pages/Shared/TextEditor.vue';
import AuthorComponent from '@/Pages/News/Components/AuthorComponent.vue';
import TeamComponent from '@/Pages/News/Components/TeamComponent.vue';
import ImageBlock from '@/Pages/Shared/BlockImageComponent.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';

const {t} = useI18n();
const props = defineProps(['input']);
const MODEL = 'News';

const image_data = {
    css: 'relative w-[400px] h-[300px] rounded-[10px] ringed_10 overflow-hidden',
    field: 'image',
};

let {form, updateFormField, fillForm, submitForm, updateForm} = useFormComposable(MODEL);

onMounted(() => {
    Event.on(['form_updated', 'file_pond_upload'], () => {
        router.reload({only: ['input']});
        fillForm(props.input);
    });
	
    fillForm(props.input);
});

const tabs = [
    {id: 1, name: t('tabs.main_info')},
    {id: 2, name: t('tabs.text')},
    {id: 3, name: t('tabs.author')},
    {id: 4, name: t('tabs.team')},
    {id: 5, name: t('tabs.details')},
];

let tab_selected = ref(1);

let details = [
    // { type: 'text', placeholder: 'placeholder', label: 'Name', model: 'contact' },
    // { type: 'email', placeholder: 'placeholder', label: 'Email', model: 'email' },
    // { type: 'password', placeholder: 'placeholder', label: 'Password', model: 'password' },
    // { type: 'textarea', placeholder: 'placeholder', label: 'Description', model: 'description' },
    // { type: 'number', placeholder: 'placeholder', label: 'Number', model: 'age' },
    // { type: 'checkbox', label: 'Тип характера', model: 'paranoid' },
    // {
    //     type: 'select', label: 'Select', model: 'role',
    //     options: [
    //         {id: 1, name: 'admin'},
    //         {id: 2, name: 'player'},
    //         {id: 3, name: 'couch'},
    //         {id: 7, name: 'sudo'},
    //     ],
    // },
];
function updateData(input) {
    let data = Object.assign({
        model: MODEL,
        id: props.input.id,
        field: 'root',
    }, {root: input});
	
    updateDetails(data);
}
</script>