<template>
  <div v-if="embedUrl" class="aspect-video bg-gray-100 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
    <iframe
      :src="embedUrl"
      class="w-full h-full"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    ></iframe>
  </div>
  <div v-else-if="data?.url" class="aspect-video bg-gray-50 rounded-2xl flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200">
    <i class="bi bi-play-circle text-4xl text-gray-300"></i>
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Format Video Tidak Didukung</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object
})

const embedUrl = computed(() => {
  const url = props.data?.url
  if (!url) return null

  // YouTube
  const ytMatch = url.match(/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/)
  if (ytMatch) {
    const id = ytMatch[1].split('&')[0].split('?')[0]
    return `https://www.youtube.com/embed/${id}`
  }

  // Vimeo
  const vMatch = url.match(/(?:https?:\/\/)?(?:www\.)?(?:vimeo\.com)\/(.+)/)
  if (vMatch) {
    const id = vMatch[1].split('?')[0]
    return `https://player.vimeo.com/video/${id}`
  }

  return null
})
</script>
