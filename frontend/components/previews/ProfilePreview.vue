<template>
  <div :class="['space-y-2', `text-${data?.align || 'center'}`]">
    <div v-if="data?.avatar" class="flex justify-center">
      <img 
        :src="data.avatar" 
        class="w-24 h-24 rounded-full border-2 shadow-lg object-cover" 
        :style="{ borderColor: theme?.accentColor || '#059669' }"
      />
    </div>
    <div>
      <h2 class="text-xl font-bold text-gray-900">{{ data?.name || 'Nama Anda' }}</h2>
      <p class="text-sm text-gray-500">{{ data?.bio || 'Bio singkat Anda...' }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})
</script>
