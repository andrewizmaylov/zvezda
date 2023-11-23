<template>
    <section>
        <section class="w-full"
                 v-if="show_map">
            <div class="max-w-[90%] rounded-[10px] shadow mx-auto mb-6 overflow-hidden">
                <img class="w-full h-full object-cover"
                     :src="cloud_path+input.details.map.image"
                     alt="map">
            </div>
            <section class="flex justify-center my-4">
                <button class="btn_main btn_ld"
                        @click="show_map = false">{{ $t('select_new_button')}}</button>
            </section>
        </section>

        <div class="max-w-[90%] mx-auto px-2 mb-6"
             v-else>
            <div class="bordered_area"
                 id="bordered_area">
                <FilePondAdapter :setup_data="setup_data"
                                 @newFile="updateLink"
                                 @deleteFile="deleteFile" />
            </div>
        </div>

        <TextInputSet :name="'url'"
                      v-model="form.map.url" />

        <FormSubmission :form="form"
                        @update="updateMap" />

    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {updateDetails} from '@/Pages/Shared/useForms.js';
import {onMounted, reactive, ref} from 'vue';
import FilePondAdapter from '@/Pages/Shared/FilePondAdapter.vue';
import {FileSourcesEnum} from '@/Enums/FileSourcesEnum.js';
import useFilePond from '@/Pages/Shared/useFilePond.js';
import {cloud_path} from '@/Pages/Shared/helpers.js';
import TextInputSet from '@/Components/TextInputSet.vue';
import FormSubmission from '@/Components/FormSubmission.vue';

const {t} = useI18n();
const props = defineProps(['input']);
let {deleteFile} = useFilePond();

let show_map = ref(false);

let form = ref({
    model: 'Stadium',
    id: props.input.id,
    field: 'map',
    map: {
        url: '',
        image: '',
    }
});

function updateMap() {
    updateDetails(form.value);
}

function updateLink(file) {
    form.value.map.image = file.link;
}

const work_area = `
<div class="h-full">
    <div class="flex items-center flex-col">
        <p class="custom-message">
             ${t('file_pond.select_map')}
        </p>
        <span
            id="chat__upload-file-btn"
            class="custom-button"
        >
            ${t('file_pond.select' )}
        </span>
    </div>
</div>`;

const setup_data = reactive({
    decoration_classes: '',
    file_types: 'image/jpeg,image/png,image/jpg,image/svg',
    file_pond_image_preview: false,
    absolute: false,
    circle: false,
    multiple: true,
    work_area: work_area,
    file_type: FileSourcesEnum.Image,
});

onMounted(() => {
    if (props.input.details?.map) {
        show_map.value = true;
        let {url, image} = props.input.details.map;
        form.value.map.url = url ?? null;
        form.value.map.image = image ?? null;
    }
});
</script>
