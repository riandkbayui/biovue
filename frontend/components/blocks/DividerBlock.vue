<template>
  <div class="space-y-3">
    <div class="flex flex-wrap items-center gap-2">
      <span class="text-sm font-medium text-gray-700">Style:</span>
      <button
        v-for="style in ['solid', 'dashed', 'dotted']"
        :key="style"
        @click="setStyle(style)"
        :class="[
          'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors capitalize',
          localData.style === style ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        {{ style }}
      </button>
    </div>
    <div class="h-px" :style="{ borderTop: `2px ${localData.style} ${localData.color}` }"></div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  style: props.modelValue?.style || props.modelValue?.data?.style || 'solid',
  color: props.modelValue?.color || props.modelValue?.data?.color || '#e5e7eb'
})

const setStyle = (style) => {
  localData.value.style = style
  emitUpdate()
}

const emitUpdate = () => {
  emit('update', localData.value)
}

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    localData.value = {
        style: newVal.style || newVal.data?.style || 'solid',
        color: newVal.color || newVal.data?.color || '#e5e7eb'
    }
  }
}, { deep: true })
</script>
