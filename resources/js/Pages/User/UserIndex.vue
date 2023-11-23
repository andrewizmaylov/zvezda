<template>
    <h1>User Index</h1>
    <section class="ringed p-4 grid grid-cols-6 gap-4">
        <UserCard class="col-span-1"
                  @click="router.get(route('users.edit', {user: user.id}))"
                  :user="user"
                  :key="user.id"
                  v-for="user in users" />
    </section>
</template>
<script setup>
import UserCard from '@/Pages/User/Components/UserCard.vue';
import {router} from '@inertiajs/vue3';

defineProps(['users']);
</script>