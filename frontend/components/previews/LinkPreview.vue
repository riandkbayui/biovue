<template>
  <a 
    :href="data?.url || '#'" 
    target="_blank"
    :class="[
      'block w-full py-3 px-6 rounded-xl font-medium text-center transition-all',
      getStyleClasses(data?.style)
    ]"
  >
    {{ data?.title || 'Link Title' }}
  </a>
</template>

<script setup>
defineProps({
  data: Object
})

const getStyleClasses = (style) => {
  const styles = {
    filled: 'bg-emerald-600 text-white hover:bg-emerald-700',
    outline: 'border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-50',
    minimal: 'text-emerald-600 hover:bg-emerald-50'
  }
  return styles[style] || styles.filled
}
</script>
