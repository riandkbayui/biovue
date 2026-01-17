<template>
  <div v-if="data?.links?.length > 0" class="flex justify-center gap-3 flex-wrap">
    <a 
      v-for="(link, index) in data.links" 
      :key="index"
      :href="link.url || '#'"
      target="_blank"
      class="social-link w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 transition-all"
      :style="{ '--accent-color': theme?.accentColor || '#059669' }"
    >
      <i :class="['bi', getSocialIcon(link.platform)]"></i>
    </a>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})

const getSocialIcon = (platform) => {
  const icons = {
    Instagram: 'bi-instagram',
    Facebook: 'bi-facebook',
    Twitter: 'bi-twitter',
    LinkedIn: 'bi-linkedin',
    TikTok: 'bi-tiktok',
    YouTube: 'bi-youtube',
  }
  return icons[platform] || 'bi-link'
}
</script>

<style scoped>
.social-link:hover {
  background-color: var(--accent-color);
  color: white;
  transform: translateY(-2px);
}
</style>
