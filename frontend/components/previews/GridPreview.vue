<template>
  <div class="grid grid-cols-2 gap-3">
    <div v-for="(item, index) in data?.items" :key="index">
      <component 
        :is="getPreviewComponent(item.type)" 
        :data="item.data" 
        :theme="theme"
      />
    </div>
  </div>
</template>

<script setup>
import { defineAsyncComponent } from 'vue'

defineProps({
  data: Object,
  theme: Object
})

const getPreviewComponent = (type) => {
  const components = {
    text: defineAsyncComponent(() => import('./TextPreview.vue')),
    link: defineAsyncComponent(() => import('./LinkPreview.vue')),
    image: defineAsyncComponent(() => import('./ImagePreview.vue')),
    video: defineAsyncComponent(() => import('./VideoPreview.vue')),
    social: defineAsyncComponent(() => import('./SocialPreview.vue')),
    alert: defineAsyncComponent(() => import('./AlertPreview.vue')),
    countdown: defineAsyncComponent(() => import('./CountdownPreview.vue')),
  }
  return components[type] || components.text
}
</script>
