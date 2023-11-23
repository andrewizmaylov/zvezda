<template>
    <section class="flex items-center space-x-8">
        <section class="flex items-center space-x-2 relative p-1 cursor-pointer"
                 v-for="role in roles"
                 :key="role.id"
                 @click="toggleRole(role)">
            <div class="absolute inset-0">&nbsp;</div>
            <input type="checkbox"
                   class="rounded small"
                   :checked="roles_id && roles_id.includes(role.id)">
            <span class="text_12 uppercase font-semibold">{{ role.name }}</span>
        </section>
    </section>
	
    <FormSubmission :form="form"
                    @create="submitForm"/>
</template>
<script setup>
import {computed, onMounted, ref} from 'vue';
import FormSubmission from '@/Components/FormSubmission.vue';
import {router, useForm} from '@inertiajs/vue3';

const props = defineProps(['user', 'roles']);
let roles_selected = ref([]);

onMounted(() => {
    roles_selected.value = props.user.roles;
});

let roles_id = computed(() => roles_selected.value.map(role => role.id));

let form = useForm({
    user_id: props.user.id,
    roles: [],
});

const submitForm = () => {
    form.roles = roles_id.value;
    form.post(route('sync_roles'), {
        errorBag: 'updateInformation',
        preserveScroll: true,
        onSuccess: () => router.reload({only: ['user']}),
    });
};
function toggleRole(role) {
    let index = roles_id?.value?.indexOf(role.id);
	
    if (index < 0) {
        roles_selected.value.push(role);
    } else {
        roles_selected.value.splice(index, 1);
    }
}
</script>