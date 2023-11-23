<template>
    <Head :title="$t('pages.' + MODEL.toLowerCase())"/>
	
    <div>
        <section class="form_wrapper">
            <FormHeader :model="MODEL"
                        :input="user"
                        :tabs="tabs"
                        @tab_changed="(id) => tab_selected = id">

                <ProfilePhoto :user="user"
                              :use_id=true
                              @profile_photo_updated="updateProfilePhotoField"/>
            </FormHeader>

            <!-- main block -->
            <div v-if="tab_selected === 1">
                <section class="grid sm:grid-cols-3 grid-cols-1 gap-4">
                    <TextInputSet class="col-span-1"
                                  :name="'first_name'"
                                  :error="form.errors.first_name"
                                  v-model="form.first_name"/>
                    <TextInputSet class="col-span-1"
                                  :name="'second_name'"
                                  :error="form.errors.second_name"
                                  v-model="form.second_name"/>
                    <TextInputSet class="col-span-1"
                                  :name="'last_name'"
                                  :error="form.errors.last_name"
                                  v-model="form.last_name"/>
                </section>
                <section class="grid sm:grid-cols-3 grid-cols-1 gap-4 mt-4">
                    <TextInputSet class="sm:col-span-2 col-span-1"
                                  :name="'email'"
                                  :input_type="'email'"
                                  :error="form.errors.email"
                                  v-model="form.email"/>
                    <TextInputSet class="col-span-1"
                                  :name="'birthday'"
                                  :input_type="'date'"
                                  :error="form.errors.birthday"
                                  v-model="form.birthday"/>
                </section>

                <section class="grid sm:grid-cols-2 grid-cols-1 gap-4 mt-4">
                    <TextInputSet class="col-span-1"
                                  :name="'tg'"
                                  :error="form.errors.tg"
                                  v-model="form.tg"/>

                    <SelectInputSet class="col-span-1"
                                    :name="'role_selector'"
                                    :error="form.errors.role"
                                    :options="roles"
                                    :i18_key="'roles'"
                                    v-model="form.role"
                                    v-if="!form.id"/>
                </section>

                <FormSubmission :form="form"
                                @update="updateForm(form, MODEL)"
                                @create="submitForm(form, MODEL)" />
            </div>

            <UserRoles :user="user"
                       :roles="roles"
                       v-if="tab_selected === 2"/>

            <UserTeams :user="user"
                       :active="show_command_component"
                       v-if="tab_selected === 3"/>

            <AddressBlock :input="user?.address ?? []"
                          :id="user.id"
                          :model="MODEL"
                          v-if="tab_selected === 4"/>

        </section>
    </div>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
const { t } = useI18n();
import {Head, router, useForm} from '@inertiajs/vue3';
import TextInputSet from '@/Components/TextInputSet.vue';
import SelectInputSet from '@/Components/SelectInputSet.vue';
import {computed, onMounted, ref} from 'vue';
import UserRoles from '@/Pages/User/Components/UserRoles.vue';
import UserTeams from '@/Pages/User/Components/UserTeams.vue';
import FormSubmission from '@/Components/FormSubmission.vue';
import FormHeader from '@/Components/FormHeader.vue';
import ProfilePhoto from '@/Pages/Profile/Partials/ProfilePhoto.vue';
import AddressBlock from '@/Pages/Shared/AddressBlock.vue';
import {RolesEnum} from '@/Enums/RolesEnum.js';
import useFormComposable from '@/Pages/Shared/useFormComposable.js';

const props = defineProps(['roles', 'user']);
const MODEL = 'User';

let {updateForm, submitForm} = useFormComposable(MODEL);

let form = useForm({
    id: '',
    email: '',
    profile_photo_path: '',
    first_name: '',
    second_name: '',
    last_name: '',
    birthday: '',
    tg: '',
    role: null,
});

onMounted(() => {
    Event.on('form_updated', () => reload());
    if (props.user) {
        form.id = props.user.id;
        form.email = props.user.email;
        form.profile_photo_path = props.user.profile_photo_path ?? null;
        form.first_name = props.user?.contact?.first_name ?? null;
        form.second_name = props.user?.contact?.second_name ?? null;
        form.last_name = props.user?.contact?.last_name ?? null;
        form.birthday = props.user?.contact?.birthday ?? null;
        form.tg = props.user?.contact?.tg ?? null;
        form.role = props.user?.roles[0]?.id ?? null;
    }
});

function updateProfilePhotoField(file) {
    form.profile_photo_path = file.link;
    document.getElementById('submit_form_button').click();
}
function reload() {
    router.reload({only: ['user']});
}

const tabs = ref([
    {id: 1, name: t('tabs.main_info')},
    {id: 2, name: t('tabs.roles')},
    {id: 3, name: t('tabs.team')},
    {id: 4, name: t('tabs.address')},
]);
let tab_selected = ref(1);
let show_command_component = computed(() => props.user.roles.map(role => role.id).some(role => [RolesEnum.Player, RolesEnum.Couch].includes(role)));
</script>