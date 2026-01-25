<template>
  <div
    :style="{
      color: resolvedColor,
      textAlign: data?.align || 'left',
      fontSize: getFontSizePx(data?.fontSize),
      fontWeight: data?.fontWeight || 'normal',
      fontStyle: data?.isItalic ? 'italic' : 'normal'
    }"
    class="px-2 py-1 whitespace-pre-wrap leading-relaxed"
  >
    {{ data?.content || data?.text || 'Tulis teks di sini...' }}
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

const getFontSizePx = (size) => {
  const map = {
    xs: '0.75rem',
    sm: '0.875rem',
    md: '1rem',
    lg: '1.125rem',
    h6: '1.25rem',
    h5: '1.5rem',
    h4: '1.75rem',
    h3: '2rem',
    h2: '2.25rem',
    h1: '3rem'
  }
  return map[size] || '1rem'
}
</script>
