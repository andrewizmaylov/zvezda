<template>
    <section>
        <section class="flex items-center justify-between mb-6">
            <h4 class="text_ld text_18 font-medium">{{ $t('team.current') }}</h4>

            <section class="">
                <label for="files"
                       class="btn_interface_blue btn_interface_rectangle text_12">{{ $t('team.import_exel') }}</label>
                <input type="file"
                       id="files"
                       class="hidden"
                       accept=".xlsx"
                       required
                       @change="proceedFile($event)"/>
            </section>
        </section>
        <section class="flex items-center justify-center space-x-4 mb-6">
            <span class="h-6 w-6 rounded ring ring-blue-500 ring-opacity-5 grid place-items-center btn_interface_blue font-bold"
                  @click="step > 2 ? step-- : step">-</span>
            <span class="h-6 w-6 rounded ring ring-blue-500 ring-opacity-5 grid place-items-center btn_interface_blue font-bold"
                  @click="step < 12 ? step++ : step">+</span>
        </section>
        <section class="grid gap-4"
                 :class="'grid-cols-' + step">
            <slot></slot>
        </section>
    </section>
</template>
<script setup>
import {ref} from 'vue';

const props = defineProps(['input']);
let step = ref(5);

const emits = defineEmits(['new_records']);
function proceedFile(e) {
    let formData = new FormData();
    formData.append('excel_file', e.target.files[0]);
    formData.append('appendable_id', props.input.appendable_id);
    formData.append('appendable', props.input.appendable);
    formData.append('creatable', props.input.creatable);
	
    axios.post(route('excel_upload'), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        // handle success
        console.log(response.data.new_records);
        emits('new_records');
    }).catch(error => {
        // handle error
        console.error(error);
    });
}
</script>
<style>
.grids {
	@apply grid-cols-1 grid-cols-2 grid-cols-3 grid-cols-4 grid-cols-5 grid-cols-6 grid-cols-7 grid-cols-8 grid-cols-9 grid-cols-10 grid-cols-11 grid-cols-12 grid-cols-13 grid-cols-14 grid-cols-15 grid-cols-16
}
</style>
