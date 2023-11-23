<style scoped>
.btn_editor {
	@apply px-2 py-1 rounded text-xs text-white cursor-pointer
}
</style>
<template>
    <section v-if="tab_selected === 1">
        <h4 class="text_ld text_18 mb-4 font-medium">{{ $t('tabs.text_edit') }}</h4>
        <section class="max-w-[800px] mx-auto flex-1 shadow-element rounded-[10px] border bg-gray-100">
            <div class="w-full min-h-[800px] font-play"
                 id="editorjs" />
        </section>
        <section class="flex flex-col space-y-4 my-3 fixed bottom-4 right-4 bg-gray-200/60 backdrop-blur-sm rounded p-3 z-40 shadow"
                 :class="success ? 'border border-green-700/100 duration-[20ms]':'border border-green-700/0 duration-[1000ms]'">
            <span class="btn_editor bg-red-400 hover:bg-red-500 ml-auto"
                  @click="exit">{{$t('form_base.cancel')}}</span>
            <span class="btn_editor bg-blue-400 hover:bg-blue-500 ml-auto"
                  @click="saveContent">{{$t('form_base.save')}}</span>
            <span class="btn_editor bg-blue-400 hover:bg-blue-500 ml-auto"
                  @click="saveExit">{{$t('form_base.save_exit')}}</span>
        </section>
    </section>
    <section class="max-w-[800px] mx-auto"
             v-if="tab_selected === 2">
        <section class="flex items-center justify-between mb-4">
            <h4 class="text_ld text_18 font-medium">{{ $t('tabs.text') }}</h4>
            <h4 class="text-blue-500 text_12 font-medium cursor-pointer"
                @click="loadEditor">{{ $t('tabs.edit_mode') }}</h4>
        </section>
        <section class="w-full shadow-element rounded-[10px] border">
            <section  class="max-w-[650px] min-h-[800px] mx-auto flex-1  py-1">
                <div class="w-full font-play"
                     id="text_output"
                     v-html="output"/>
            </section>
        </section>
    </section>
</template>
<script setup>
import {useI18n} from 'vue-i18n';
import {ref, onMounted, computed} from 'vue';
import EditorJS from '@editorjs/editorjs';
import {tools_default} from '@/Pages/Utilities/EditorDefault.js';
import {router} from '@inertiajs/vue3';
import {page} from '@/Pages/Shared/helpers.js';
import {htmlOutput} from '@/Pages/Utilities/HtmlOutput.js';

const {t} = useI18n();
const props = defineProps(['input','model']);

let editor = ref(null);
let exit_editor = ref(false);
let success = ref(false);
let tab_selected = ref(2);

function loadEditor() {
    tab_selected.value = 1;
    createEditor(props.input?.text?.schema ?? null, tools_default);
}

function exit() {
    editor.value.destroy();
    tab_selected.value = 2;
    setTimeout(() => {
        createMessageHook();
    }, 0);
}

function saveContent() {
    editor.value.save().then((savedData) => {
        axios.post(route('save_text'), {
            textable_type: props.model,
            textable_id: props.input.id,
            text: {
                id: props.input?.text?.id ?? null,
                schema: savedData,
                user_id: page.props.auth.user.id,
            }
        }).then(() => {
            success.value = true;
            setTimeout(() => success.value = false, 3000);
            router.reload({only: ['input']});
            if (exit_editor.value) {
                exit();
            }
        }).catch(error => {
            console.log(error);
        });
    }).catch(err => { console.log(err); });
}

function saveExit() {
    exit_editor.value = true;
    saveContent();
}

function createEditor(data, tools) {
    editor.value = new EditorJS({
        holder : 'editorjs',
        tools: tools,
        /**
         * onReady callback
         */
        onReady: () => {
            console.log('Editor.js is ready to work!');
        },
        // Previously saved data that should be rendered
        data: data
    });
}

// empty interactive placeholder with event listener
let output = computed(() => props.input?.text?.schema ? htmlOutput(props.input.text.schema) : `
	<div class="grid place-items-center h-[400px]">
<span class="text_12 opacity-50 uppercase cursor-pointer hover:text-blue-500 duration-75" id="create_message"> ${t('story')} </span>
</div>
`
);
function createMessageHook() {
    if (! document.getElementById('create_message')) return;
	
    document.getElementById('create_message')
        .addEventListener('click', () => loadEditor());
}
onMounted(() => createMessageHook());
</script>
