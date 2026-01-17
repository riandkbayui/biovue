<template>
  <a 
    :href="data?.url || '#'" 
    target="_blank"
    :class="[
      'block w-full py-3 px-6 rounded-xl font-bold text-center transition-all hover:scale-[1.02] active:scale-[0.98] shadow-sm',
    ]"
    :style="linkStyle"
  >
    {{ data?.title || 'Link Title' }}
  </a>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
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
