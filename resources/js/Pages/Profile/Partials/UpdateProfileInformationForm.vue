<script setup>
import {onMounted, ref} from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ProfilePhoto from '@/Pages/Profile/Partials/ProfilePhoto.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    email: props.user.email,
    file: null,
});

const fileInput = ref(null);

const verificationLinkSent = ref(null);
const photoPreview = ref(null);

const updateProfileInformation = () => {
    if (fileInput.value) {
        form.file = fileInput.value;
    }

    form.post(route('user-profile-update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            clearPhotoFileInput();
            router.reload({ only: ['user'] });
        },
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    (document.getElementsByName('file'))[0].click();
};

const deletePhoto = () => {
    router.delete(route('user-photo-destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
            router.reload({ only: ['user'] });
            Event.emit('file_deleted');
        },
    });
};

const clearPhotoFileInput = () => {
    if (fileInput.value) {
        fileInput.value = null;
    }
};

onMounted(() => {
    Event.on('new_file_uploaded', (file) => {
        fileInput.value = file;
    });
});
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            {{$t('update_profile.title')}}
        </template>

        <template #description>
            {{$t('update_profile.description')}}
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos"
                 class="col-span-6 sm:col-span-4">

                <ProfilePhoto class="col-span-6 sm:col-span-4"
                              :user="user"/>

                <SecondaryButton class="mt-2 mr-2"
                                 type="button"
                                 @click.prevent="selectNewPhoto">
                    {{$t('update_profile.select_new')}}
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    {{$t('update_profile.remove')}}
                </SecondaryButton>
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email"
                            :value="$t('email')" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email"
                            class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2 dark:text-white">
                        {{$t('update_profile.unverified')}}

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            @click.prevent="sendEmailVerification"
                        >
                            {{$t('update_profile.resend_verification')}}
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent"
                         class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{$t('update_profile.message')}}
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful"
                           class="mr-3">
                {{$t('saved')}}
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                           :disabled="form.processing">
                {{$t('save_button')}}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
