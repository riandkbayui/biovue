<template>
  <div class="grid grid-cols-2 gap-3">
    <div v-for="(item, index) in data?.items" :key="index">
      <!-- Jika item adalah block dinamis (punya type) -->
      <component
        v-if="item.type"
        :is="getPreviewComponent(item.type)"
        :data="item.data"
        :theme="theme"
      />
      <!-- Jika item adalah grid gambar/link sederhana (legacy/seeder format) -->
      <a
        v-else
        :href="item.url || '#'"
        target="_blank"
        class="block group relative rounded-xl overflow-hidden aspect-square"
      >
        <Image
          v-if="item.image"
          :src="item.image"
          :alt="item.title"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
        />
        <div v-if="item.title" class="absolute inset-0 bg-black/40 flex items-center justify-center p-2 opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-[2px]">
          <span class="text-white text-[10px] font-bold text-center uppercase tracking-wider">{{ item.title }}</span>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup>
import { defineAsyncComponent } from 'vue'
import Image from '@/components/Image.vue'

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
