<template>
  <div class="space-y-2">
    <div v-for="(item, index) in data?.items" :key="index" class="border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
      <div class="p-4 flex justify-between items-center cursor-pointer">
        <span class="font-bold text-sm text-gray-900">{{ item.title || 'Accordion Title' }}</span>
        <i class="bi bi-chevron-down" :style="{ color: theme?.accentColor || '#059669' }"></i>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})
</script>
