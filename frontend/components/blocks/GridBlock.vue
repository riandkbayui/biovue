<template>
  <div class="space-y-4">
    <!-- Grid Items -->
    <div v-if="localData.items.length > 0" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div v-for="(item, index) in localData.items" :key="index" class="relative group bg-gray-50 rounded-xl p-3 border border-gray-200">
        <!-- Item Header (Type & Actions) -->
        <div class="flex items-center justify-between mb-2 pb-2 border-b border-gray-200">
          <span class="text-[10px] font-bold uppercase text-gray-500">{{ item.type }}</span>
          <div class="flex items-center gap-1">
             <button 
              @click="moveItem(index, -1)" 
              :disabled="index === 0"
              class="text-gray-400 hover:text-gray-600 disabled:opacity-30"
            >
              <i class="bi bi-arrow-left-circle-fill"></i>
            </button>
            <button 
              @click="moveItem(index, 1)" 
              :disabled="index === localData.items.length - 1"
              class="text-gray-400 hover:text-gray-600 disabled:opacity-30"
            >
              <i class="bi bi-arrow-right-circle-fill"></i>
            </button>
            <button 
              @click="removeItem(index)"
              class="text-red-400 hover:text-red-600 ml-1"
            >
              <i class="bi bi-trash-fill"></i>
            </button>
          </div>
        </div>

        <!-- Dynamic Block Component -->
        <component 
          :is="getComponent(item.type)"
          :model-value="item"
          @update="updateItem(index, $event)"
        />
      </div>
    </div>

    <!-- Add Item Area -->
    <div class="bg-gray-50 rounded-xl p-4 border-2 border-dashed border-gray-300">
      <p class="text-sm text-gray-500 font-medium text-center mb-3">Tambah ke Grid</p>
      <div class="grid grid-cols-4 gap-2">
        <button 
          v-for="block in allowedBlocks" 
          :key="block.type"
          @click="addItem(block.type)"
          class="flex flex-col items-center gap-1 p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all"
          :title="block.name"
        >
          <div :class="['w-8 h-8 rounded-lg flex items-center justify-center text-lg', block.bgColor]">
            <i :class="['bi', block.icon]"></i>
          </div>
          <span class="text-[10px] text-gray-600 truncate w-full text-center">{{ block.name }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

// Import Sub-Blocks
import TextBlock from './TextBlock.vue'
import ImageBlock from './ImageBlock.vue'
import LinkBlock from './LinkBlock.vue'
import VideoBlock from './VideoBlock.vue'
import SocialBlock from './SocialBlock.vue'
import CountdownBlock from './CountdownBlock.vue'
import AlertBlock from './AlertBlock.vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  items: props.modelValue?.data?.items || []
})

const allowedBlocks = [
  { type: 'text', name: 'Text', icon: 'bi-text-left', bgColor: 'bg-blue-50 text-blue-600' },
  { type: 'image', name: 'Image', icon: 'bi-image', bgColor: 'bg-purple-50 text-purple-600' },
  { type: 'link', name: 'Button', icon: 'bi-link-45deg', bgColor: 'bg-emerald-50 text-emerald-600' },
  { type: 'video', name: 'Video', icon: 'bi-play-circle', bgColor: 'bg-red-50 text-red-600' },
  { type: 'social', name: 'Social', icon: 'bi-share', bgColor: 'bg-pink-50 text-pink-600' },
  { type: 'alert', name: 'Alert', icon: 'bi-megaphone-fill', bgColor: 'bg-yellow-50 text-yellow-600' },
  { type: 'countdown', name: 'Timer', icon: 'bi-stopwatch-fill', bgColor: 'bg-rose-50 text-rose-600' },
]

const getComponent = (type) => {
  const map = {
    text: TextBlock,
    image: ImageBlock,
    link: LinkBlock,
    video: VideoBlock,
    social: SocialBlock,
    countdown: CountdownBlock,
    alert: AlertBlock
  }
  return map[type] || TextBlock
}

const getDefaultData = (type) => {
  const defaults = {
    text: { content: 'Teks grid...', align: 'center', textColor: '#0f172a', fontSize: 'md', fontWeight: 'normal', isItalic: false },
    link: { title: 'Link', url: 'https://', style: 'filled', backgroundColor: '#059669', textColor: '#ffffff' },
    image: { url: '', alt: '', size: 'small' },
    video: { url: '', platform: 'youtube' },
    social: { links: [] },
    alert: { content: 'Info', type: 'info' },
    countdown: { title: '', targetDate: '', style: 'simple' },
  }
  return defaults[type] || {}
}

const addItem = (type) => {
  localData.value.items.push({
    type,
    data: getDefaultData(type)
  })
  emitUpdate()
}

const updateItem = (index, event) => {
  // Merge existing item data with new data from event
  localData.value.items[index] = {
    ...localData.value.items[index],
    ...event // event is { data: { ... } }
  }
  emitUpdate()
}

const removeItem = (index) => {
  localData.value.items.splice(index, 1)
  emitUpdate()
}

const moveItem = (index, direction) => {
  const newIndex = index + direction
  if (newIndex >= 0 && newIndex < localData.value.items.length) {
    const temp = localData.value.items[index]
    localData.value.items[index] = localData.value.items[newIndex]
    localData.value.items[newIndex] = temp
    emitUpdate()
  }
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
