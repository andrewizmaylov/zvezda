<template>
    <Dropdown align="right"
              width="60">
        <template #trigger>
            <div
                class="inline-flex p-1 md:px-4 md:py-2 bg_ld_invert tracking-wide text-xs text_invert font-bold rounded-full cursor-pointer">
                <span class="hidden md:block">Добавить</span>
                <span class="md:hidden text-white"
                      v-html="collection.add.path"></span>
            </div>
        </template>
		
        <template #content>
            <section class="w-[180px]">
                <DropdownLink :href="type.link"
                              v-for="(type, index) in contents"
                              :key="index" >
                    {{ type.name }}
                </DropdownLink>
            </section>
        </template>
    </Dropdown>
</template>

<script setup>
import {useI18n} from 'vue-i18n';
import {collection} from '@/Pages/Utilities/assets.js';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

let { t } = useI18n();

const contents = [
    {
        id: 0, name: t('pages.user'), roles: [1, 7], link: '/users/create',
    },
    {
        id: 0, name: t('pages.team'), roles: [1, 7], link: '/teams/create',
    },
    {
        id: 0, name: t('pages.match'), roles: [1, 7], link: '/games/create',
    },
    {
        id: 0, name: t('pages.stadium'), roles: [1, 7], link: '/stadiums/create',
    },
    {
        id: 0, name: t('pages.merch'), roles: [1, 7], link: '/merch/create',
    },
    {
        id: 0, name: t('pages.news'), roles: [1, 7], link: '/news/create',
    },
    {
        id: 0, name: t('pages.partner'), roles: [1, 7], link: '/partners/create',
    },
    {
        id: 0, name: t('pages.position'), roles: [1, 7], link: '/positions/create',
    },
];
</script>
