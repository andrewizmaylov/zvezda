<template>
    <div class="profile_photo_wrapper relative">
        <FilePondAdapter :setup_data="setup_data"
                         @newFile="handleNewFile"
                         @deleteFile="deleteFile"
                         class="duration-150"
                         :class="pond_opacity ? 'opacity-100':'opacity-0'"/>

        <img :src="placeholder"
             :alt="setup_data.file_type"
             id="image_preview"
             class="absolute z-0 inset-0 object-cover w-full h-full"
             @click="reloadPond"
        />
    </div>
</template>
<script setup>
import {onMounted, reactive, ref} from 'vue';
import FilePondAdapter from '@/Pages/Shared/FilePondAdapter.vue';
import {FileSourcesEnum} from '@/Enums/FileSourcesEnum.js';
import useFilePond from '@/Pages/Shared/useFilePond.js';
import {cloud_path} from '@/Pages/Shared/helpers.js';

let {files, deleteFile, newFile} = useFilePond();

const props = defineProps(['user', 'use_id']);

let placeholder = ref(null);
let pond_opacity = ref(true);
function setPlaceholder(file) {
    placeholder.value = cloud_path + file.link;
    setTimeout(() => pond_opacity.value = false, 3000);
}

function reloadPond() {
    deleteFile(files.value[0].id);
    pond_opacity.value = true;
    Event.emit('file_deleted');
}

function handleNewFile(file) {
    if (props.use_id) {
        updateById(file);
    } else {
        newFile(file);
    }
}

const emit = defineEmits(['profile_photo_updated', 'update_main_form_field']);
function updateById(file) {
    emit('profile_photo_updated', file);
    emit('update_main_form_field', {
        field: 'profile_photo_path',
        url: file.link
    });
    setPlaceholder(file);
}

onMounted(() => {
    Event.on('new_file_uploaded', (file) => setPlaceholder(file));
    placeholder.value = props.user?.profile_photo_url  ?? '/img/empty_user.jpeg';
});

const setup_data = reactive({
    decoration_classes: 'relative overflow-hidden ringed-10 w-full h-full cursor-pointer',
    file_types: 'image/jpeg,image/png,image/jpg,image/svg',
    file_pond_image_preview: true,
    absolute: true,
    circle: true,
    multiple: false,
    file_type: FileSourcesEnum.ProfilePhoto,
});

</script>
<style>
.profile_photo_wrapper {
	@apply h-28 w-28 rounded-full border_ld overflow-hidden
}
</style>

