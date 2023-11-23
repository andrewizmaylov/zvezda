<template>
    <FormSection @submitted="updateContactInformation">
        <template #title>
            {{$t('contact_information.intro')}}
        </template>
		
        <template #description>
            {{$t('contact_information.description')}}
        </template>
		
        <template #form>
            <!-- ФИО -->
            <TextInputSet class="col-span-6 sm:col-span-4"
                          :name="'last_name'"
                          :error="form.errors.last_name"
                          v-model="form.last_name"/>

            <TextInputSet class="col-span-6 sm:col-span-4"
                          :name="'first_name'"
                          :error="form.errors.first_name"
                          v-model="form.first_name"/>

            <TextInputSet class="col-span-6 sm:col-span-4"
                          :name="'second_name'"
                          :error="form.errors.second_name"
                          v-model="form.second_name"/>

            <TextInputSet class="col-span-6 sm:col-span-4"
                          :input_type="'date'"
                          :name="'birthday'"
                          :error="form.errors.birthday"
                          v-model="form.birthday"/>

            <TextInputSet class="col-span-6 sm:col-span-4"
                          :name="'tg'"
                          :error="form.errors.tg"
                          v-model="form.tg"/>

        </template>
		
        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful"
                              class="mr-3">
                {{$t('saved')}}
            </JetActionMessage>
			
            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                           :disabled="form.processing">
                {{$t('save_button')}}
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<script setup>
import {onMounted} from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import JetActionMessage from '@/Components/ActionMessage.vue';
// import JetSecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm, usePage} from '@inertiajs/vue3';
import TextInputSet from '@/Components/TextInputSet.vue';

let form = useForm({
    _method: 'POST',
    id: null,
    first_name: null,
    second_name: null,
    last_name: null,
    tg: null,
    birthday: null,
});

const page = usePage();

onMounted(() => {
    form.id = page.props.auth.user.id;
    form.first_name = page.props.auth.user.contact?.first_name ?? null;
    form.second_name = page.props.auth.user.contact?.second_name ?? null;
    form.last_name = page.props.auth.user.contact?.last_name ?? null;
    form.tg = page.props.auth.user.contact?.tg ?? null;
    form.birthday = page.props.auth.user.contact?.birthday ?? null;
});

function updateContactInformation() {
    form.post(route('user.update_contact'), {
        errorBag: 'updateContactInformation',
        preserveScroll: true,
    });
}

</script>