<template>
    <textarea cols="30"
              :rows="rows"
              class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              :value="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"
              ref="input">
    </textarea>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: ['modelValue', 'rows'],
	
    emits: ['update:modelValue'],
	
    methods: {
        focus() {
            this.$refs.input.focus();
        }
    }
});
</script>
