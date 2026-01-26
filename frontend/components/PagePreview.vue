<template>
  <div
    class="min-h-full pl-6 pr-8 py-6 pb-20 space-y-6 transition-all duration-500"
    :style="bgStyle"
  >
    <!-- Default Header (Hanya muncul jika tidak ada Profile Block) -->
    <div v-if="!hasProfileBlock" class="text-center mb-8 animate-fade-in">
      <div
        class="w-20 h-20 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-emerald-500/20 ring-4 ring-white"
        :style="{
          backgroundColor: pageData?.theme?.accentColor || '#059669',
          boxShadow: `0 10px 15px -3px ${pageData?.theme?.accentColor}33`
        }"
      >
        {{ (pageData?.title || 'A').charAt(0) }}
      </div>
      <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ pageData?.title || 'Halaman Baru' }}</h1>
      <p class="text-sm text-gray-500 mt-1">aksibio.com/{{ pageData?.slug || 'username' }}</p>
    </div>

    <!-- Blocks List -->
    <div class="space-y-4">
      <div v-for="block in safeBlocks" :key="block.id" class="animate-slide-up">
        <component
          :is="getPreviewComponent(block.type)"
          :data="block.content"
          :theme="pageData?.theme"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { getFullUrl } from '@/utils/helpers.js'
import TextPreview from '@/components/previews/TextPreview.vue'
import LinkPreview from '@/components/previews/LinkPreview.vue'
import ImagePreview from '@/components/previews/ImagePreview.vue'
import VideoPreview from '@/components/previews/VideoPreview.vue'
import SocialPreview from '@/components/previews/SocialPreview.vue'
import DividerPreview from '@/components/previews/DividerPreview.vue'
import ProfilePreview from '@/components/previews/ProfilePreview.vue'
import SlideshowPreview from '@/components/previews/SlideshowPreview.vue'
import AccordionPreview from '@/components/previews/AccordionPreview.vue'
import AlertPreview from '@/components/previews/AlertPreview.vue'
import CountdownPreview from '@/components/previews/CountdownPreview.vue'
import GridPreview from '@/components/previews/GridPreview.vue'

const props = defineProps({
  pageData: Object,
  blocks: Array
})

const safeBlocks = computed(() => {
  return Array.isArray(props.blocks) ? props.blocks : []
})

const hasProfileBlock = computed(() => {
  return safeBlocks.value.some(b => b.type === 'profile')
})

const bgStyle = computed(() => {
  const theme = props.pageData?.theme || {}
  if (theme.backgroundType === 'image' && theme.backgroundImage) {
    return {
      backgroundImage: `url(${getFullUrl(theme.backgroundImage)})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      backgroundAttachment: 'fixed'
    }
  }
  return {
    backgroundColor: theme.backgroundColor || '#f9fafb'
  }
})

const getPreviewComponent = (type) => {
  const components = {
    text: TextPreview,
    link: LinkPreview,
    image: ImagePreview,
    video: VideoPreview,
    social: SocialPreview,
    divider: DividerPreview,
    profile: ProfilePreview,
    slideshow: SlideshowPreview,
    accordion: AccordionPreview,
    alert: AlertPreview,
    countdown: CountdownPreview,
    grid: GridPreview,
  }
  return components[type] || TextPreview
}
</script>
