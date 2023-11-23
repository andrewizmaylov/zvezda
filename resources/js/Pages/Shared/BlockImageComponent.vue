<template>
    <div :class="setup.css">
        <FilePondAdapter :setup_data="setup_data"
                         @newFile="handleNewFile"
                         @deleteFile="deleteFile"
                         class="duration-150"
                         :class="pond_opacity ? 'opacity-100':'opacity-0'"/>
			
        <img :src="placeholder"
             :alt="setup_data.file_type"
             id="image_preview"
             class="absolute z-0 inset-0 h-full w-full duration-150"
             :class="placeholder === default_image ? 'object-contain':'object-cover'"
             @click="reloadPond"
        />
    </div>
</template>
<script setup>
import {onMounted, reactive, ref} from 'vue';
import FilePondAdapter from '@/Pages/Shared/FilePondAdapter.vue';
import {getIdFromEnum} from '@/Enums/FileSourcesEnum.js';
import useFilePond from '@/Pages/Shared/useFilePond.js';
import {cloud_path, default_image} from '@/Pages/Shared/helpers.js';
import axios from 'axios';

let {files, deleteFile} = useFilePond();

const props = defineProps(['input', 'model', 'setup']);

let placeholder = ref(null);
let pond_opacity = ref(true);
function setPlaceholder(file) {
    placeholder.value = cloud_path + file.link;
    setTimeout(() => {
        pond_opacity.value = false;
        document.getElementById('image_preview').classList.remove('opacity-0');
    }, 3000);
}

function reloadPond() {
    if (files.value.length) {
        deleteFile(files.value[0].id);
        Event.emit('file_deleted');
    }
    pond_opacity.value = true;
	
    document.getElementsByName('file')[0].click();
}

const emits = defineEmits(['update_main_form_field']);
function handleNewFile(file) {
    axios.post(route('update_image'), {
        model: props.model,
        id: props.input.id,
        file: file,
    }).then(() => {
        setPlaceholder(file);
        emits('update_main_form_field', {
            field: props.setup.field,
            url: file.link
        });
    });
}

function definePlaceHolderByField() {
    const fieldMappings = {
        'image': props.input.image_url,
        'logo': props.input.logo_url,
        'banner': props.input.banner_url
    };
	
    return fieldMappings[props.setup.field] || default_image;
}

onMounted(() => {
    Event.on('file_pond_upload', () => {
        document.getElementById('image_preview').classList.add('opacity-0');
    });
    placeholder.value = definePlaceHolderByField();
});

const setup_data = reactive({
    decoration_classes: '',
    file_types: 'image/jpeg,image/png,image/jpg,image/svg',
    file_pond_image_preview: true,
    circle: false,
    absolute: false,
    multiple: false,
    file_type: getIdFromEnum(props.setup.field),
});
</script>
