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
		
        <section class="w-full"
                 v-if="tab_selected === 1">
            <section class="grid sm:grid-cols-6 gap-4 my-6">
                <TextInputSet class="sm:col-span-4 col-span-6"
                              :name="'date'"
                              :input_type="'date'"
                              :error="form.errors.date"
                              v-model="form.date"/>

                <TextInputSet class="sm:col-span-2 col-span-6"
                              :name="'time'"
                              :input_type="'time'"
                              :error="form.errors.time"
                              v-model="form.time"/>
            </section>

            <section class="col-span-6 grid grid-cols-2 gap-4">
                <SelectInputSet class="col-span-1"
                                :name="'team_a'"
                                :error="form.errors.team_a"
                                :options="teams"
                                v-model="form.team_a" />

                <SelectInputSet class="col-span-1"
                                :name="'team_b'"
                                :error="form.errors.team_b"
                                :options="teams"
                                v-model="form.team_b" />
            </section>

            <FormSubmission :form="form"
                            @update="updateForm(form, MODEL)"
                            @create="submitForm(form, MODEL)" />
        </section>
		
        <GameStadium :input="input"
                     v-if="tab_selected === 2"/>

        <TextEditor :input="input"
                    :model="MODEL"
                    v-if="tab_selected === 3"/>

        <InstanceDetails :details="details"
                         :input="input?.details ?? []"
                         @update_details="updateData"
                         v-if="tab_selected === 4"/>

        <InstanceImages :input="input"
                        :model="MODEL"
                        v-if="tab_selected === 5"/>
    </section>
</template>
<script setup>
import {Head, router} from '@inertiajs/vue3';
import ImageBlock from '@/Pages/Shared/BlockImageComponent.vue';
import FormHeader from '@/Components/FormHeader.vue';
import {image_data} from '@/Pages/Shared/useCreation.js';
import {onMounted, ref,} from 'vue';
import TextInputSet from '@/Components/TextInputSet.vue';
import SelectInputSet from '@/Components/SelectInputSet.vue';
import {useI18n} from 'vue-i18n';
import FormSubmission from '@/Components/FormSubmission.vue';
import {updateDetails} from '@/Pages/Shared/useForms.js';
import GameStadium from '@/Pages/Game/Components/GameStadium.vue';
import TextEditor from '@/Pages/Shared/TextEditor.vue';
import InstanceDetails from '@/Pages/Shared/InstanceDetails.vue';
import InstanceImages from '@/Pages/Shared/InstanceImages.vue';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';

const props = defineProps(['input', 'teams']);
const {t} = useI18n();
const MODEL = 'Game';

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
    {id: 2, name: t('tabs.stadium')},
    {id: 3, name: t('tabs.anons')},
    {id: 4, name: t('tabs.details')},
    {id: 5, name: t('tabs.images')},
];
let tab_selected = ref(1);

let details = [
    { type: 'text', label: 'Broadcast', model: 'broadcast' },
    { type: 'text', label: 'Count', model: 'count', placeholder: '5:0' },
	
    // { type: 'text', label: 'Videos', model: 'videos' },
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