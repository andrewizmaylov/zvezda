<template>
    <section class="flex items-center space-x-4 my-6">
        <span class="btn_main cursor-pointer"
              :class="tab_selected === tab.id ? 'btn_ld':'btn_ld_border'"
              v-for="tab in tabs"
              :key="tab.id"
              @click="selectTab(tab)">{{ tab.name }}</span>
    </section>
</template>
<script setup>
defineProps(['tabs', 'tab_selected']);
let emit = defineEmits(['update_selected']);
function selectTab(tab) {
    emit('update_selected', tab);
}
</script>

