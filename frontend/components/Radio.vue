<template>
  <label class="inline-flex items-center">
    <input
      type="radio"
      :checked="modelValue === value"
      :value="value"
      @change="$emit('update:modelValue', value)"
      :class="radioClasses"
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
    type: [String, Number, Boolean],
    default: '',
  },
  value: {
    type: [String, Number, Boolean],
    required: true,
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (value) =>
      ['primary', 'secondary', 'dark', 'light', 'info', 'warning', 'danger', 'success'].includes(value),
  }
});

defineEmits(['update:modelValue']);

const radioClasses = computed(() => {
  const baseClasses = 'form-radio h-4 w-4 border-gray-300';
  let variantClasses = '';
  switch (props.variant) {
    case 'primary':
      variantClasses = 'text-green-600 focus:ring-green-500';
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
      variantClasses = 'text-green-600 focus:ring-green-500';
  }
  return `${baseClasses} ${variantClasses}`;
});
</script>