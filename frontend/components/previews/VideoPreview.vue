<template>
  <div v-if="data?.url" class="aspect-video bg-gray-100 rounded-xl flex items-center justify-center">
    <i class="bi bi-play-circle text-4xl text-gray-400"></i>
  </div>
</template>

<script setup>
defineProps({
  data: Object
})
</script>
