<template>
  <div class="relative">
    <input
      :id="id"
      :name="name"
      :type="showPassword ? 'text' : 'password'"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      :autocomplete="autocomplete"
      @input="$emit('update:modelValue', $event.target.value)"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors pr-10"
    />
    <button
      type="button"
      @click="showPassword = !showPassword"
      class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-emerald-600 focus:outline-none"
      tabindex="-1"
    >
      <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: '********',
  },
  id: {
    type: String,
    default: '',
  },
  name: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
  autocomplete: {
    type: String,
    default: 'off',
  },
});

defineEmits(['update:modelValue']);

const showPassword = ref(false);
</script>
