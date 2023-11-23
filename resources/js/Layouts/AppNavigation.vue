<template>
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <ApplicationMark />
                        </Link>
                    </div>
					
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <NavLink :href="route(element.path)"
                                 :active="route().current(element.path)"
                                 v-for="element in navigation"
                                 :key="element.id">
                            {{ element.name }}
                        </NavLink>
                    </div>
                </div>

                

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <AddMore v-if="$page.props?.is_admin"
                             class="mr-12"/>
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <Dropdown align="right"
                                  width="48">
                            <template #trigger>
                                <button v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         :src="menu_image"
                                         alt="main menu">
                                </button>
								
                                <span v-else
                                      class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ menu_text }}
                                    </button>
                                </span>
                            </template>
							
                            <template #content>
                                <section v-if="!$page.props.auth.user">
                                    <DropdownLink :href="route('login')">
                                        {{ $t('auth.login') }}
                                    </DropdownLink>

                                    <DropdownLink :href="route('register')">
                                        {{ $t('auth.register') }}
                                    </DropdownLink>
                                </section>

                                <section v-else>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t('top_menu.manage_account') }}
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        {{ $t('top_menu.profile') }}
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                  :href="route('api-tokens.index')">
                                        {{ $t('top_menu.api') }}
                                    </DropdownLink>

                                    <div class="border-t border-gray-200 dark:border-gray-600" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            {{ $t('logout') }}
                                        </DropdownLink>
                                    </form>
                                </section>

                            </template>
                        </Dropdown>
                    </div>
                </div>
				
                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            @click="showingNavigationDropdown = ! showingNavigationDropdown">
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
		
        <!-- Responsive Navigation Menu -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
             class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route(element.path)"
                                   :active="route().current(element.path)"
                                   v-for="element in navigation"
                                   :key="element.id">
                    {{ element.name }}
                </ResponsiveNavLink>
            </div>
        			
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <section class="mt-3 space-y-1"
                         v-if="!$page.props.auth.user">
                    <ResponsiveNavLink :href="route('login')"
                                       :active="route().current('login')">
                        {{ $t('auth.login') }}
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('register')"
                                       :active="route().current('register')">
                        {{ $t('auth.register') }}
                    </ResponsiveNavLink>
                </section>
				
                <section v-else>
                    <div class="flex items-center px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos"
                             class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover"
                                 :src="$page.props.auth.user.profile_photo_url"
                                 :alt="$page.props.auth.user.name">
                        </div>

                        <div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ full_name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')"
                                           :active="route().current('profile.show')">
                            {{ $t('top_menu.profile') }}
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                           :href="route('api-tokens.index')"
                                           :active="route().current('api-tokens.index')">
                            {{ $t('top_menu.api') }}
                        </ResponsiveNavLink>

                        <!-- Authentication -->
                        <form method="POST"
                              @submit.prevent="logout">
                            <ResponsiveNavLink as="button">
                                {{ $t('logout') }}
                            </ResponsiveNavLink>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </nav>

</template>
<script setup>
import {useI18n} from 'vue-i18n';
const { t } = useI18n();

import {Link, router} from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import {computed, ref} from 'vue';
import {full_name, initials, page} from '@/Pages/Shared/helpers.js';
import AddMore from '@/Layouts/AddMore.vue';

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

const navigation = [
    // {
    //     id: 1,
    //     name: t('pages.media'),
    //     path: 'home',
    //     external: false,
    // },
    // {
    //     id: 2,
    //     name: t('pages.match'),
    //     path: 'home',
    //     external: false,
    // },
    // {
    //     id: 3,
    //     name: t('pages.club'),
    //     path: 'teams.index',
    //     external: false,
    // },
    // {
    //     id: 4,
    //     name: t('pages.fan'),
    //     path: 'stadiums.index',
    //     external: false,
    // },
    // {
    //     id: 5,
    //     name: t('pages.partner'),
    //     path: 'home',
    //     external: false,
    // },
];

let menu_image = computed(() => page.props?.auth?.user?.profile_photo_url ?? '/img/empty_user.jpeg');
let menu_text = computed(() => initials.value ?? 'menu');
</script>