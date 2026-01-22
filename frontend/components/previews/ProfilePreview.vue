<template>
  <div :class="['space-y-2', `text-${data?.align || 'center'}`]">
    <div v-if="data?.avatar" class="flex justify-center">
      <img 
        :src="data.avatar" 
        class="w-24 h-24 rounded-full border-2 shadow-lg object-cover" 
        :style="{ borderColor: theme?.accentColor || '#059669' }"
      />
    </div>
    <div :style="{ color: resolvedColor }">
      <h2 class="text-xl font-bold">{{ data?.name || 'Nama Anda' }}</h2>
      <p class="text-sm opacity-70">{{ data?.bio || 'Bio singkat Anda...' }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const resolvedColor = computed(() => {
  if (props.data?.textColor === 'accent') {
    return props.theme?.accentColor || '#059669'
  }
  return props.data?.textColor || '#0f172a'
})
</script>
