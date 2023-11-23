<style>
.size {
	border-top-right-radius: 16px;
	border-bottom-right-radius: 16px;
	height: 32px;
}
</style>
<template>
    <section
        class="fixed left-0 bottom-[5%] z-30 size dark:bg-[#212936] bg-gray-300 ring-1 ring-black ring-opacity-5 flex items-center justify-center overflow-hidden shadow">
        <div
            class="ml-[18px] mr-2 dark:bg-[#565656] bg-gray-50 rounded-full flex items-center justify-center h-[24px] w-[24px] shrink-0 cursor-pointer ring-1 ring-black ring-opacity-5"
            @click="theme = !theme">
            <span class="dark:text-gray-100 text-gray-900 object-center opacity-80 hover:opacity-100"
                  v-html="theme ? collection.moon_filled.path : collection.sun_filled.path"/>
        </div>
    </section>
</template>
<script setup>
import {onMounted, ref, watch} from 'vue';
import {collection} from '@/Pages/Utilities/assets.js';

let theme = ref(null);

onMounted(() => {
    theme.value = getTheme();
});

function getTheme() {
    const theme = localStorage.getItem('theme');
	
    if (theme === null) {
        localStorage.setItem('theme', 'true');
        return true;
    }
	
    return  theme === 'true';
}

watch(theme, (value) => {
    if (value) {
        localStorage.theme = true;
        document.documentElement.classList.add('dark');
        Event.emit('theme_mode', true);
    } else {
        localStorage.theme = false;
        document.documentElement.classList.remove('dark');
        Event.emit('theme_mode', false);
    }
});
</script>
