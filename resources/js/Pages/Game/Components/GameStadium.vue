<template>
    <section>
        <SelectInputSet :name="'select_stadium'"
                        :options="stadiums"
                        v-model="form.stadium_id" />

        <FormSubmission :form="form"
                        @update="updateForm(form, 'game')"/>
    </section>
</template>
<script setup>
import {onMounted, ref} from 'vue';
import SelectInputSet from '@/Components/SelectInputSet.vue';
import {useForm} from '@inertiajs/vue3';
import {updateForm} from '@/Pages/Shared/useForms.js';
import FormSubmission from '@/Components/FormSubmission.vue';

const props = defineProps(['input']);
let stadiums = ref([]);

let form = useForm({
    stadium_id: '',
});

onMounted(() => {
    axios.post(route('admin_collection'), {
        model: 'Stadium',
    }).then(response => stadiums.value = response.data);
	
    for (let key in props.input) {
        form[key] = props.input[key];
    }
});
</script>