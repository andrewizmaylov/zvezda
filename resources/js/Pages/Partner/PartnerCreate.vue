<template>
    <Head :title="$t('pages.' + MODEL.toLowerCase())"/>
	
    <section class="form_wrapper">
        <FormHeader :model="MODEL"
                    :input="input"
                    :tabs="tabs"
                    @tab_changed="(id) => tab_selected = id">
            <!--slot-->
            <section class="flex space-x-4 mb-6">
                <section>
                    <InputLabel class="mb-1">{{ $t('form_base.logo') }}</InputLabel>
                    <div class="w-32 h-32 shrink-0 ringed rounded overflow-hidden">
                        <img class="w-full h-full object-cover"
                             id="partner_logo"
                             :src="input.logo ? cloud_path + input.logo : '/img/empty.svg'"
                             alt="logo">
                    </div>
                </section>
                <section class="flex-1">
                    <InputLabel class="mb-1">{{ $t('form_base.banner') }}</InputLabel>
                    <div class="w-full h-32 ringed rounded overflow-hidden">
                        <img class="w-full h-full"
                             :class="input.banner ? 'object-cover':'object-contain'"
                             :src="input.banner ? cloud_path + input.banner : '/img/empty.svg'"
                             alt="banner">
                    </div>
                </section>
            </section>
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

        <ImageBlock :input="input"
                    :model="MODEL"
                    :setup="logo_data"
                    @update_main_form_field="updateFormField"
                    v-if="tab_selected === 3"/>

        <ImageBlock :input="input"
                    :model="MODEL"
                    :setup="banner_data"
                    @update_main_form_field="updateFormField"
                    v-if="tab_selected === 4"/>

        <AddressBlock :input="input?.address ?? []"
                      :id="input.id"
                      :model="MODEL"
                      v-if="tab_selected === 5"/>
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {updateDetails} from '@/Pages/Shared/useForms.js';
import {Head, router} from '@inertiajs/vue3';
import FormSubmission from '@/Components/FormSubmission.vue';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import FormHeader from '@/Components/FormHeader.vue';
import TextAreaSet from '@/Components/TextAreaSet.vue';
import TextInputSet from '@/Components/TextInputSet.vue';
import {onMounted, ref} from 'vue';
import ImageBlock from '@/Pages/Shared/BlockImageComponent.vue';
import {cloud_path} from '@/Pages/Shared/helpers.js';
import InputLabel from '@/Components/InputLabel.vue';
import AddressBlock from '@/Pages/Shared/AddressBlock.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';

const { t } = useI18n();
const props = defineProps(['input']);
const MODEL = 'Partner';

const logo_data = {
    css: 'relative w-[130px] h-[130px] rounded-[10px] ringed_10 overflow-hidden',
    field: 'logo',
};
const banner_data = {
    css: 'relative w-[800px] h-[200px] rounded-[10px] ringed_10 overflow-hidden',
    field: 'banner',
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
    {id: 2, name: t('tabs.details')},
    {id: 3, name: t('tabs.logo')},
    {id: 4, name: t('tabs.banner')},
    {id: 5, name: t('tabs.address')},
];
let tab_selected = ref(1);

let details = [];
function updateData(input) {
    let data = Object.assign({
        model: MODEL,
        id: props.input.id,
        field: 'root',
        root: input
    });
	
    updateDetails(data);
}
</script>