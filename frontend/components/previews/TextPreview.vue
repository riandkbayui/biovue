<template>
  <p :class="['text-gray-700', `text-${data?.align || 'left'}`]">
    {{ data?.content || 'Text content' }}
  </p>
</template>

<script setup>
defineProps({
  data: Object
})
</script>
