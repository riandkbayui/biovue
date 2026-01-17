<template>
  <div class="my-4">
    <div :style="{ borderTop: `2px ${data?.style || 'solid'} ${data?.color || theme?.accentColor || '#e5e7eb'}` }"></div>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})
</script>
