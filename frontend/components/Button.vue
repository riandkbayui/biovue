<template>
  <button :class="buttonClasses">
    <slot></slot>
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) =>
      ['primary', 'secondary', 'dark', 'light', 'info', 'warning', 'danger', 'success'].includes(value),
  },
  outline: {
    type: Boolean,
    default: false,
  },
});

const buttonClasses = computed(() => {
  const baseClasses = 'px-4 py-2 rounded-md font-semibold';
  
  const solidClasses = {
    primary: 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm',
    secondary: 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50',
    dark: 'bg-gray-800 hover:bg-gray-900 text-white',
    light: 'bg-gray-100 hover:bg-gray-200 text-gray-900',
    info: 'bg-blue-600 hover:bg-blue-700 text-white',
    warning: 'bg-yellow-500 hover:bg-yellow-600 text-white',
    danger: 'bg-red-600 hover:bg-red-700 text-white',
    success: 'bg-teal-600 hover:bg-teal-700 text-white',
  };

  const outlineClasses = {
    primary: 'border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-50',
    secondary: 'border-2 border-gray-500 text-gray-500 hover:bg-gray-50',
    dark: 'border-2 border-gray-800 text-gray-800 hover:bg-gray-50',
    light: 'border-2 border-gray-200 text-gray-500 hover:bg-gray-50',
    info: 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50',
    warning: 'border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-50',
    danger: 'border-2 border-red-600 text-red-600 hover:bg-red-50',
    success: 'border-2 border-teal-600 text-teal-600 hover:bg-teal-50',
  };

  const variantSet = props.outline ? outlineClasses : solidClasses;
  const variantClass = variantSet[props.variant] || variantSet['primary'];

  return `${baseClasses} ${variantClass}`;
});
</script>
