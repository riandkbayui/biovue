<template>
  <div class="space-y-3">
    <input 
      v-model="localData.url"
      @input="emitUpdate"
      type="url"
      placeholder="URL video (YouTube, Vimeo, dll)"
      class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
    />
    <div class="flex flex-wrap items-center gap-2">
      <span class="text-sm font-medium text-gray-700">Platform:</span>
      <button 
        v-for="platform in ['youtube', 'vimeo', 'tiktok']" 
        :key="platform"
        @click="setPlatform(platform)"
        :class="[
          'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors capitalize',
          localData.platform === platform ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        {{ platform }}
      </button>
    </div>
    <div v-if="localData.url" class="aspect-video bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200">
      <div class="text-center">
        <i class="bi bi-play-circle text-4xl text-gray-400 mb-2"></i>
        <p class="text-sm text-gray-500">Video Preview</p>
      </div>
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
  url: props.modelValue?.data?.url || '',
  platform: props.modelValue?.data?.platform || 'youtube'
})

const setPlatform = (platform) => {
  localData.value.platform = platform
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
