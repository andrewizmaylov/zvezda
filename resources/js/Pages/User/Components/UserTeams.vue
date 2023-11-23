<template>
    <section class="grid place-items-center h-24"
             v-if="!active">
        <h6>{{ $t('only_players') }}</h6>
    </section>
    <section v-else>
        <section class="mb-6"
                 v-if="user.teams.length">
            <h4 class="text_18 font-semibold mb-4">{{$t('associated_team')}}</h4>
            
            <section class="grid grid-cols-3 gap-4 ">
                <UserTeamCard v-for="team in user.teams"
                              :selected="form.team_id === team.id"
                              :key="team.id"
                              @click="form.team_id === team.id ? form.team_id = '' : form.team_id = team.id"
                              :team="team" />
            </section>
        </section>
        <SelectInputSet :name="'select_team'"
                        :options="teams"
                        v-model="form.team_id"/>
		
        <FormSubmission :form="form"
                        @create="submitForm(form, 'user')"/>
    </section>
</template>
<script setup>
import SelectInputSet from '@/Components/SelectInputSet.vue';
import FormSubmission from '@/Components/FormSubmission.vue';
import {onMounted, ref} from 'vue';
import {router, useForm} from '@inertiajs/vue3';
import UserTeamCard from '@/Pages/User/Components/UserTeamCard.vue';

const props = defineProps(['active', 'user']);
let teams = ref([]);

let form = useForm({
    user_id: props.user.id,
    team_id: '',
});

function submitForm() {
    form.post(route('toggle_team'), {
        errorBag: 'updateInformation',
        preserveScroll: true,
        onSuccess: () => {
            form.team_id = '';
            router.reload({only: ['input']});
        }
    });
}

onMounted(() => {
    axios.post(route('admin_collection'), {
        model: 'Team',
    }).then(response => teams.value = response.data);
});
</script>
