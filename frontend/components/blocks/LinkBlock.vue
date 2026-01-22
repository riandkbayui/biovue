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
    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
      <span class="text-sm font-medium text-gray-700">Style:</span>
      <button 
        v-for="s in ['filled', 'outline', 'minimal']" 
        :key="s"
        @click="setStyle(s)"
        :class="[
          'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors capitalize',
          localData.style === s ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        {{ s }}
      </button>
    </div>

    <div class="space-y-4 pt-2 border-t border-gray-100">
      <!-- BG Color -->
      <div class="flex flex-col gap-2">
        <span class="text-xs font-bold text-gray-400 uppercase">Warna Background</span>
        <div class="flex flex-wrap gap-1.5">
          <button 
            v-for="color in colorPresets" 
            :key="color.hex"
            @click="setBgColor(color.hex)"
            :title="color.name"
            :class="[
              'w-6 h-6 rounded-full border transition-all',
              localData.backgroundColor === color.hex ? 'ring-2 ring-offset-1 ring-emerald-500 border-transparent scale-110' : 'border-gray-200 hover:scale-110'
            ]"
            :style="{ backgroundColor: color.hex }"
          ></button>
        </div>
      </div>

      <!-- Text Color -->
      <div class="flex flex-col gap-2">
        <span class="text-xs font-bold text-gray-400 uppercase">Warna Teks</span>
        <div class="flex flex-wrap gap-1.5">
          <button 
            v-for="color in colorPresets" 
            :key="color.hex"
            @click="setTextColor(color.hex)"
            :title="color.name"
            :class="[
              'w-6 h-6 rounded-full border transition-all',
              localData.textColor === color.hex ? 'ring-2 ring-offset-1 ring-emerald-500 border-transparent scale-110' : 'border-gray-200 hover:scale-110'
            ]"
            :style="{ backgroundColor: color.hex }"
          ></button>
        </div>
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

const colorPresets = [
  { name: 'Slate 900', hex: '#0f172a' },
  { name: 'Gray 600', hex: '#4b5563' },
  { name: 'White', hex: '#ffffff' },
  { name: 'Blue 600', hex: '#2563eb' },
  { name: 'Emerald 600', hex: '#059669' },
  { name: 'Rose 600', hex: '#e11d48' },
  { name: 'Amber 600', hex: '#d97706' },
  { name: 'Indigo 600', hex: '#4f46e5' },
]

const localData = ref({
  title: props.modelValue?.title || '',
  url: props.modelValue?.url || '',
  style: props.modelValue?.style || 'filled',
  backgroundColor: props.modelValue?.backgroundColor || '#059669', // Default Emerald 600
  textColor: props.modelValue?.textColor || '#ffffff'
})

const setStyle = (style) => {
  localData.value.style = style
  emitUpdate()
}

const setBgColor = (hex) => {
  localData.value.backgroundColor = hex
  emitUpdate()
}

const setTextColor = (hex) => {
  localData.value.textColor = hex
  emitUpdate()
}

const emitUpdate = () => {
  emit('update', localData.value)
}

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    localData.value = { 
      title: newVal.title || '',
      url: newVal.url || '',
      style: newVal.style || 'filled',
      backgroundColor: newVal.backgroundColor || '#059669',
      textColor: newVal.textColor || '#ffffff'
    }
  }
}, { deep: true })
</script>
