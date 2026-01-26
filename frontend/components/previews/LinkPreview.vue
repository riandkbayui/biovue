<template>
  <a
    :href="formatedUrl"
    target="_blank"
    :class="[
      'flex items-center justify-center gap-2 w-full py-3 px-6 rounded-xl font-bold text-center transition-all hover:scale-[1.02] active:scale-[0.98] shadow-sm',
    ]"
    :style="linkStyle"
  >
    <i v-if="data?.icon" :class="['bi', data.icon, 'text-lg']"></i>
    <span>{{ data?.title || 'Link Title' }}</span>
  </a>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const formatedUrl = computed(() => {
  let url = props.data?.url || '#'
  if (url !== '#' && !url.startsWith('http')) {
    url = 'https://' + url
  }
  return url
})

const linkStyle = computed(() => {
  const style = props.data?.style || 'filled'
  const bgColor = props.data?.backgroundColor || props.theme?.accentColor || '#059669'
  const textColor = props.data?.textColor || '#ffffff'

  if (style === 'outline') {
    return {
      border: `2px solid ${bgColor}`,
      color: bgColor,
      backgroundColor: 'transparent'
    }
  }

  if (style === 'minimal') {
    return {
      color: bgColor,
      backgroundColor: 'transparent'
    }
  }

  // Default: filled
  return {
    backgroundColor: bgColor,
    color: textColor
  }
})
</script>
