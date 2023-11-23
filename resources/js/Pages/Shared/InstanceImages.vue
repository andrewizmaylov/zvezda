<template>
    <div class="max-w-[600px] mx-auto px-2">
        <div class="bordered_area"
             id="bordered_area">
            <FilePondAdapter :setup_data="setup_data"
                             @newFile="newFile"
                             @deleteFile="deleteFile" />
        </div>
    </div>
	
    <ImageSection :input="images"
                  :title="'approved'"
                  @toggle="toggleImage" />
	
    <FormSubmission :form="form"
                    @update="saveData" />
	
    <ImageSection :input="trashed"
                  :title="'trashed'"
                  @toggle="toggleImage" />
	
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {onMounted, reactive, ref} from 'vue';
import FilePondAdapter from '@/Pages/Shared/FilePondAdapter.vue';
import {FileSourcesEnum} from '@/Enums/FileSourcesEnum.js';
import useFilePond from '@/Pages/Shared/useFilePond.js';
import ImageSection from '@/Pages/Shared/ImageSection.vue';
import {useForm} from '@inertiajs/vue3';
import FormSubmission from '@/Components/FormSubmission.vue';

const { t } = useI18n();
let {deleteFile} = useFilePond();

const props = defineProps(['input', 'model']);
let images = ref([]);
let trashed = ref([]);

function newFile(file) {
    images.value.push(file);
}

function toggleImage(input) {
    let index = input.title === 'trashed' ?
        trashed.value.map(row => row.id).indexOf(input.image.id) :
        images.value.map(row => row.id).indexOf(input.image.id);
    if (input.title === 'trashed') {
        trashed.value.splice(index, 1);
        images.value.push(input.image);
    } else {
        images.value.splice(index, 1);
        trashed.value.push(input.image);
    }
}

const work_area = `
<div class="h-full">
    <div class="flex items-center flex-col">
        <p class="custom-message">
             ${t('file_pond.drop_select')}
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
    if (props.input?.details?.images) {
        images.value = props.input.details.images;
    }
});

let form = useForm({
    model: props.model,
    id: props.input.id,
    field: 'images',
    images: [],
    trashed: [],
});

function saveData() {
    form.images = images.value.map(row => ({id: row.id, link: row.link}));
    form.trashed = trashed.value.map(row => ({id: row.id, link: row.link}));
    // 	remove trashed files from DB and from storage inside request
    trashed.value = [];
	
    form.post(route('update_details'), {
        errorBag: 'updateInformation',
        preserveScroll: true,
        onSuccess: () => {
            Event.emit('delete_files');
        }
    });
}
</script>
<style>
.bordered_area {
	@apply relative p-6 rounded-[10px] border-dashed border-[#676767] border-[1px] text-center flex flex-col justify-center items-center
}
.custom-button {
	cursor: pointer;
	position: relative;
	display: flex;
	justify-content: center;
	align-items: center;
	padding-top: .4rem;
	padding-bottom: .4rem;
	width: 200px !important;
	border-radius: 6px;
	background-color: #334155;
	color: #fafafa;
	font-weight: 600; /* This corresponds to font-semibold */
	font-size: 13px !important;
	text-transform: uppercase;
	letter-spacing: 0.1em; /* tracking-wide */
	transition: opacity 0.3s ease; /* This is a typical transition for hover effects */
}
.custom-message {
	font-size: 12px !important;
	font-weight: 500;
	line-height: 94%;
	margin-bottom: 24px;
	color: #383247;
}
.dark .custom-message {
	color: #fafafa;
}
.custom-button:hover {
	background: #0f172a;
}
.dark .custom-button:hover {
	background: #444857;
}
.dark .custom-button {
	background-color: #333745; /* This corresponds to bg-gray-800 in dark mode */
	color: #fafafa;
}
</style>
