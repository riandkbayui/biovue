<template>
  <div class="p-6 space-y-4">
    <div class="text-center mb-6">
      <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
        {{ pageData.title?.charAt(0) || 'A' }}
      </div>
      <h1 class="text-xl font-bold text-gray-900">{{ pageData.title || 'Your Name' }}</h1>
      <p class="text-sm text-gray-500 mt-1">@{{ pageData.slug || 'username' }}</p>
    </div>

    <div class="space-y-3">
      <div v-for="block in pageData.blocks" :key="block.id">
        <component :is="getPreviewComponent(block.type)" :data="block.data" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import TextPreview from '@/components/previews/TextPreview.vue'
import LinkPreview from '@/components/previews/LinkPreview.vue'
import ImagePreview from '@/components/previews/ImagePreview.vue'
import VideoPreview from '@/components/previews/VideoPreview.vue'
import SocialPreview from '@/components/previews/SocialPreview.vue'
import DividerPreview from '@/components/previews/DividerPreview.vue'

defineProps({
  pageData: Object
})

const getPreviewComponent = (type) => {
  const components = {
    text: TextPreview,
    link: LinkPreview,
    image: ImagePreview,
    video: VideoPreview,
    social: SocialPreview,
    divider: DividerPreview,
  }
  return components[type] || TextPreview
}
</script>
