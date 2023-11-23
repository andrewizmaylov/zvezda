import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import {createI18n} from 'vue-i18n';
import {messages} from '@/i18n.js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') ?? 'ru', // set locale
    fallbackLocale: 'en',
    messages,
});

import Layout from '@/Layouts/AppLayout.vue';
import mitt from 'mitt';
const emitter = mitt();
window.Event = emitter;

import {copyContent} from '@/Pages/Shared/helpers.js';
window.copyContent = copyContent;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout ??= Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
