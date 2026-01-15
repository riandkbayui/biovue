<template>
  <div class="space-y-3">
    <input 
      v-model="localData.title"
      @input="emitUpdate"
      type="text"
      placeholder="Judul link"
      class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
    />
    <input 
      v-model="localData.url"
      @input="emitUpdate"
      type="url"
      placeholder="https://example.com"
      class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
    />
    <div class="flex flex-wrap items-center gap-2">
      <span class="text-sm font-medium text-gray-700">Style:</span>
      <button 
        v-for="style in ['filled', 'outline', 'minimal']" 
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
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  title: props.modelValue?.data?.title || '',
  url: props.modelValue?.data?.url || '',
  style: props.modelValue?.data?.style || 'filled'
})

const setStyle = (style) => {
  localData.value.style = style
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
