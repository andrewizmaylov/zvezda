<template>
    <div :class="setup_data.decoration_classes">
        <FilePond
            ref="pond"
            :class="setup_data.absolute ? 'absolute z-10 inset-0':''"
            :accepted-file-types="setup_data.file_types"
            :label-idle="setup_data.work_area ?? ''"
            max-files="10"
            name="file"
            :labelMaxFileSize="`$t('file_pond.max_size') ${MAX_FILE_SIZE} $t('file_pond.mb')`"
            :maxFileSize="MAX_FILE_SIZE + 'MB'"
            :server="filePondServer"
            credits="false"
            :labelFileLoading="$t('file_pond.loading')"
            :labelFileProcessing="$t('file_pond.loading')"
            :labelFileProcessingComplete="$t('file_pond.loaded')"
            :labelMaxFileSizeExceeded="$t('file_pond.big')"
            :labelTapToCancel="$t('file_pond.cancel')"
            :labelTapToRetry="$t('file_pond.again')"
            :labelTapToUndo="$t('file_pond.cancel')"
            :allow-multiple="setup_data.multiple"
            imageTransformVariants=image_sizes
            :stylePanelLayout="layout"
            styleLoadIndicatorPosition='center bottom'
            styleProgressIndicatorPosition='right bottom'
            styleButtonRemoveItemPosition='left bottom'
            styleButtonProcessItemPosition='right bottom'
            @addfilestart="activateFilepond"
        />
    </div>
</template>
<script setup>
import {onMounted, ref} from 'vue';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import Cookies from 'js-cookie';
import {deleteFileRequest} from '@/api/files';
import useFilePond from '@/Pages/Shared/useFilePond.js';

const MAX_FILE_SIZE = 5;

let {activateFilepond} = useFilePond();

const props = defineProps(['setup_data']);
const emits = defineEmits(['newFile', 'deleteFile', 'clearFn']);

const FilePond = props.setup_data.file_pond_image_preview ?
    vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize, FilePondPluginImagePreview) :
    vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

const pond = ref(null);
let layout = ref(null);
// const file = ref(null);
// const isFileUploading = ref(false);
// const isSizeError = ref(false);

onMounted(() => {
    if (props.setup_data.circle) {
        layout.value = 'compact circle';
    }
    emits('clearFn', () => {
        pond.value.removeFiles();
    });
	
    Event.on('file_deleted', () => {
        pond.value.removeFile();
    });
	
    Event.on('delete_files', () => {
        pond.value.removeFiles();
    });
	
});

const filePondServer = {
    url: '/files',
    revert: async (file, load, error) => {
        const res = await deleteFileRequest(file.id);
		
        if (res.success) {
            emits('deleteFile', file.id);
            load();
        } else {
            error();
        }
    },
    process: {
        url: '/tmp',
        ondata: (formData) => {
            formData.append('source', props.setup_data.file_type);
            return formData;
        },
        onload: (res) => {
            const data = JSON.parse(res);
            if (data.success) {
                emits('newFile', data.file);
            }
			
            return data.file;
        }
    },
    headers: {
        'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
    }
};
</script>
<style>
#bordered_area .filepond--file {
    position: relative;
    width: 360px !important;
    margin: 16px auto  !important;
    background: #343744;
    border-radius: 6px;
	display: flex;
	align-items: center;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

#bordered_area .filepond--list-scroller {
	transform: translate3d(-195px, 66px, 14px) !important;
}
</style>
