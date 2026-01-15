<template>
  <span :class="badgeClasses">
    <slot></slot>
  </span>
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
});

const badgeClasses = computed(() => {
  const baseClasses = 'px-2.5 py-0.5 rounded-full text-xs font-semibold';
  let variantClasses = '';

  switch (props.variant) {
    case 'primary':
      variantClasses = 'bg-green-100 text-green-800';
      break;
    case 'secondary':
      variantClasses = 'bg-gray-100 text-gray-800';
      break;
    case 'dark':
      variantClasses = 'bg-gray-800 text-white';
      break;
    case 'light':
      variantClasses = 'bg-gray-200 text-gray-800';
      break;
    case 'info':
      variantClasses = 'bg-blue-100 text-blue-800';
      break;
    case 'warning':
      variantClasses = 'bg-yellow-100 text-yellow-800';
      break;
    case 'danger':
      variantClasses = 'bg-red-100 text-red-800';
      break;
    case 'success':
      variantClasses = 'bg-teal-100 text-teal-800';
      break;
    default:
      variantClasses = 'bg-green-100 text-green-800';
  }

  return `${baseClasses} ${variantClasses}`;
});
</script>
