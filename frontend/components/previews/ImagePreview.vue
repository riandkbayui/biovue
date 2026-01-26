<template>
  <div v-if="data?.url" :class="['rounded-xl overflow-hidden', getSizeClass(data?.size)]">
    <Image :src="data.url" :alt="data.alt || ''" class="w-full h-auto" />
  </div>
</template>

<script setup>
import Image from '@/components/Image.vue'

defineProps({
  data: Object
})

const getSizeClass = (size) => {
  const sizes = {
    small: 'max-w-xs mx-auto',
    medium: 'max-w-md mx-auto',
    large: 'w-full'
  }
  return sizes[size] || sizes.medium
}
</script>
