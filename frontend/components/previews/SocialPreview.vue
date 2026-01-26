<template>
  <div v-if="safeLinks.length > 0" class="flex justify-center gap-3 flex-wrap">
    <a
      v-for="(link, index) in safeLinks"
      :key="index"
      :href="formatUrl(link.url)"
      target="_blank"
      class="social-link w-11 h-11 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-500 transition-all hover:scale-110 active:scale-95"
      :style="{ '--accent-color': theme?.accentColor || '#059669' }"
    >
      <i :class="['bi', getSocialIcon(link.platform), 'text-xl']"></i>
    </a>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const safeLinks = computed(() => {
  if (Array.isArray(props.data)) return props.data
  return props.data?.links || []
})

const formatUrl = (url) => {
  if (!url || url === '#') return '#'
  return url.startsWith('http') ? url : `https://${url}`
}

const getSocialIcon = (platform) => {
  const p = platform?.toLowerCase() || ''
  const icons = {
    instagram: 'bi-instagram',
    facebook: 'bi-facebook',
    twitter: 'bi-twitter',
    x: 'bi-twitter-x',
    linkedin: 'bi-linkedin',
    tiktok: 'bi-tiktok',
    youtube: 'bi-youtube',
    github: 'bi-github',
    discord: 'bi-discord',
    twitch: 'bi-twitch',
    whatsapp: 'bi-whatsapp',
    spotify: 'bi-spotify'
  }
  return icons[p] || 'bi-link-45deg'
}
</script>

<style scoped>
.social-link:hover {
  background-color: var(--accent-color);
  color: white;
  transform: translateY(-2px);
}
</style>
