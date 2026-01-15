<template>
  <label class="inline-flex items-center">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
      :class="checkboxClasses"
    />
    <span class="ml-2 text-gray-700">
      <slot></slot>
    </span>
  </label>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (value) =>
      ['primary', 'secondary', 'dark', 'light', 'info', 'warning', 'danger', 'success'].includes(value),
  }
});

defineEmits(['update:modelValue']);

const checkboxClasses = computed(() => {
  const baseClasses = 'form-checkbox h-5 w-5 border-gray-300 rounded';
  let variantClasses = '';
  switch (props.variant) {
    case 'primary':
      variantClasses = 'text-emerald-600 focus:ring-emerald-500';
      break;
    case 'secondary':
      variantClasses = 'text-gray-600 focus:ring-gray-500';
      break;
    case 'success':
      variantClasses = 'text-teal-600 focus:ring-teal-500';
      break;
    case 'danger':
      variantClasses = 'text-red-600 focus:ring-red-500';
      break;
    case 'warning':
      variantClasses = 'text-yellow-600 focus:ring-yellow-500';
      break;
    case 'info':
      variantClasses = 'text-blue-600 focus:ring-blue-500';
      break;
    case 'dark':
      variantClasses = 'text-gray-800 focus:ring-gray-700';
      break;
    case 'light':
      variantClasses = 'text-gray-400 focus:ring-gray-300';
      break;
    default:
      variantClasses = 'text-emerald-600 focus:ring-emerald-500';
  }
  return `${baseClasses} ${variantClasses}`;
});
</script>