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

        <StadiumMap :input="input"
                    v-if="tab_selected === 3"/>

        <InstanceImages :input="input"
                        :model="MODEL"
                        v-if="tab_selected === 4"/>

        <AddressBlock :input="input?.address ?? []"
                      :id="input.id"
                      :model="MODEL"
                      v-if="tab_selected === 5"/>

        <TextEditor :input="input"
                    :model="MODEL"
                    v-if="tab_selected === 6"/>
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {updateDetails} from '@/Pages/Shared/useForms.js';
import {onMounted, ref} from 'vue';
import {Head, router} from '@inertiajs/vue3';
import TextInputSet from '@/Components/TextInputSet.vue';
import TextAreaSet from '@/Components/TextAreaSet.vue';
import FormSubmission from '@/Components/FormSubmission.vue';
import FormHeader from '@/Components/FormHeader.vue';
import StadiumMap from '@/Pages/Stadium/Components/StadiumMap.vue';
import InstanceImages from '@/Pages/Shared/InstanceImages.vue';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import AddressBlock from '@/Pages/Shared/AddressBlock.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';
import TextEditor from '@/Pages/Shared/TextEditor.vue';

const { t } = useI18n();
const props = defineProps(['input']);
const MODEL = 'Stadium';

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
    {id: 2, name: t('tabs.details')},
    {id: 3, name: t('tabs.map')},
    {id: 4, name: t('tabs.images')},
    {id: 5, name: t('tabs.address')},
    {id: 6, name: t('tabs.text')},
];

let tab_selected = ref(1);

function updateData(input) {
    let data = Object.assign({
        model: MODEL,
        id: props.input.id,
        field: 'root',
    }, {root: input});
	
    updateDetails(data);
}
let details = [];
</script>