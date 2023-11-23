<template>
    <section class="mb-4"
             v-for="member in members"
             :key="member.index">
        <section class="grid grid-cols-5 gap-4"
                 v-if="member.role === RolesEnum.Couch">
            <UserCard :user="member"/>
        </section>
        <section class="grid grid-cols-5 gap-4"
                 v-if="member.role === RolesEnum.Player">
            <UserCard :user="member"/>
        </section>
    </section>
	
    <ImportPlayers :input="setup_data"
                   @new_records="getMembers">
        <UserCard class="col-span-1 cursor-pointer"
                  v-for="user in members"
                  :user="user"
                  :key="user.id"
                  @click="router.get(route('users.edit', {user: user}))"/>
    </ImportPlayers>
	
    <!--	hiring section -->
    <SearchComponent :model="'User'"
                     :input="team"
                     @update_results="updateSearchResults"/>
    <section class="grid grid-cols-5 gap-4">
        <UserCard :user="user"
                  v-for="user in search_results"
                  :key="user.id"/>
    </section>
</template>
<script setup>
import {onMounted, ref} from 'vue';
import {RolesEnum} from '@/Enums/RolesEnum.js';
import UserCard from '@/Pages/User/Components/UserCard.vue';
import SearchComponent from '@/Pages/Shared/SearchComponent.vue';
import ImportPlayers from '@/Pages/Shared/ExcelImport.vue';
import {router} from '@inertiajs/vue3';

const props = defineProps(['team']);

let members = ref([]);
let search_results = ref([]);

const setup_data = {
    appendable_id: props.team.id,
    appendable: 'Team',
    creatable: 'User',
};

function updateSearchResults(data) {
    console.log('data updated after search', data);
    search_results.value = data;
}
function getMembers() {
    axios.post(route('get_team_members'), {
        team_id: props.team.id
    }).then(response => {
        members.value = response.data;
    });
}

onMounted(() => {
    getMembers();
});
</script>