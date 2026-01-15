<template>
  <div class="space-y-3">
    <textarea 
      v-model="localData.content"
      @input="emitUpdate"
      rows="3"
      placeholder="Tulis teks di sini..."
      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
    ></textarea>
    <div class="flex flex-wrap items-center gap-2">
      <button 
        v-for="align in ['left', 'center', 'right']" 
        :key="align"
        @click="setAlign(align)"
        :class="[
          'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
          localData.align === align ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        <i :class="['bi', `bi-text-${align}`]"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  content: props.modelValue?.data?.content || '',
  align: props.modelValue?.data?.align || 'left'
})

const setAlign = (align) => {
  localData.value.align = align
  emitUpdate()
}

const emitUpdate = () => {
  emit('update', { data: localData.value })
}

watch(() => props.modelValue, (newVal) => {
  if (newVal?.data) {
    localData.value = { ...newVal.data }
  }
}, { deep: true })
</script>
