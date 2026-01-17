<template>
  <div v-if="data?.images?.length > 0" class="rounded-2xl overflow-hidden relative aspect-video bg-gray-100">
    <img :src="data.images[0].url" class="w-full h-full object-cover" />
    <div v-if="data.images[0].caption" class="absolute bottom-0 left-0 right-0 bg-black/50 p-2 text-white text-xs text-center">
      {{ data.images[0].caption }}
    </div>
    <!-- Note: In a real app, this would be a real slider. For preview, we show the first image. -->
    <div v-if="data.images.length > 1" class="absolute bottom-2 right-2 px-2 py-1 rounded text-[10px] text-white font-bold" :style="{ backgroundColor: theme?.accentColor || '#059669' }">
      1 / {{ data.images.length }}
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})
</script>
