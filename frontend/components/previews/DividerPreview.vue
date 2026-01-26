<template>
  <div class="py-4">
    <div :style="dividerStyle"></div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const dividerStyle = computed(() => {
    const style = props.data?.style || props.data?.data?.style || 'solid'
    const color = props.data?.color || props.data?.data?.color || props.theme?.accentColor || '#e5e7eb'

    return {
        borderTop: `2px ${style} ${color}`,
        width: '100%',
        opacity: style === 'solid' ? '0.5' : '1'
    }
})
</script>
