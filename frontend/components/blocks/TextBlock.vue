<template>
  <div class="space-y-3">
    <textarea 
      v-model="localData.content"
      @input="emitUpdate"
      rows="3"
      placeholder="Tulis teks di sini..."
      :style="{ 
        color: localData.textColor === 'accent' ? '#059669' : localData.textColor, 
        textAlign: localData.align,
        fontSize: getFontSizePx(localData.fontSize),
        fontWeight: localData.fontWeight,
        fontStyle: localData.isItalic ? 'italic' : 'normal'
      }"
      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
    ></textarea>
    <div class="flex flex-wrap items-center gap-4">
      <!-- Size & Style -->
      <div class="flex items-center gap-2">
        <select 
          v-model="localData.fontSize" 
          @change="emitUpdate"
          class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 bg-white outline-none focus:ring-1 focus:ring-emerald-500"
        >
          <optgroup label="Paragraph">
            <option value="xs">Extra Small (XS)</option>
            <option value="sm">Small (SM)</option>
            <option value="md">Medium (MD)</option>
            <option value="lg">Large (LG)</option>
          </optgroup>
          <optgroup label="Heading">
            <option value="h6">Heading 6</option>
            <option value="h5">Heading 5</option>
            <option value="h4">Heading 4</option>
            <option value="h3">Heading 3</option>
            <option value="h2">Heading 2</option>
            <option value="h1">Heading 1</option>
          </optgroup>
        </select>

        <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-xl">
          <button 
            @click="toggleBold"
            :class="[
              'w-8 h-8 rounded-lg flex items-center justify-center transition-all',
              localData.fontWeight === 'bold' ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500'
            ]"
            title="Bold"
          >
            <i class="bi bi-type-bold"></i>
          </button>
          <button 
            @click="toggleItalic"
            :class="[
              'w-8 h-8 rounded-lg flex items-center justify-center transition-all',
              localData.isItalic ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500'
            ]"
            title="Italic"
          >
            <i class="bi bi-type-italic"></i>
          </button>
        </div>
      </div>

      <!-- Alignment -->
      <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-xl">
        <button 
          v-for="align in ['left', 'center', 'right']" 
          :key="align"
          @click="setAlign(align)"
          :class="[
            'w-8 h-8 rounded-lg flex items-center justify-center transition-all',
            localData.align === align ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500 hover:text-gray-700'
          ]"
        >
          <i :class="['bi', `bi-text-${align}`]"></i>
        </button>
      </div>

      <!-- Text Color -->
      <div class="flex items-center gap-2">
        <div class="flex flex-wrap gap-1">
          <!-- Accent Color Choice -->
          <button 
            @click="setColor('accent')"
            title="Gunakan Warna Aksen Halaman"
            :class="[
              'w-5 h-5 rounded-full border-2 transition-all flex items-center justify-center',
              localData.textColor === 'accent' ? 'ring-2 ring-offset-1 ring-emerald-500 border-transparent scale-110' : 'border-gray-300 hover:scale-110'
            ]"
          >
            <i class="bi bi-star-fill text-[10px] text-amber-500"></i>
          </button>

          <button 
            v-for="color in colorPresets" 
            :key="color.hex"
            @click="setColor(color.hex)"
            :title="color.name"
            :class="[
              'w-5 h-5 rounded-full border transition-all',
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
  { name: 'Zinc 400', hex: '#a1a1aa' },
  { name: 'White', hex: '#ffffff' },
  { name: 'Blue 600', hex: '#2563eb' },
  { name: 'Emerald 600', hex: '#059669' },
  { name: 'Rose 600', hex: '#e11d48' },
  { name: 'Amber 600', hex: '#d97706' },
  { name: 'Indigo 600', hex: '#4f46e5' },
]

const localData = ref({
  content: props.modelValue?.content || '',
  align: props.modelValue?.align || 'left',
  textColor: props.modelValue?.textColor || '#0f172a',
  fontSize: props.modelValue?.fontSize || 'md',
  fontWeight: props.modelValue?.fontWeight || 'normal',
  isItalic: props.modelValue?.isItalic || false
})

const setAlign = (align) => {
  localData.value.align = align
  emitUpdate()
}

const setColor = (hex) => {
  localData.value.textColor = hex
  emitUpdate()
}

const toggleBold = () => {
  localData.value.fontWeight = localData.value.fontWeight === 'bold' ? 'normal' : 'bold'
  emitUpdate()
}

const toggleItalic = () => {
  localData.value.isItalic = !localData.value.isItalic
  emitUpdate()
}

const emitUpdate = () => {
  emit('update', localData.value)
}

const getFontSizePx = (size) => {
  const map = {
    xs: '12px',
    sm: '14px',
    md: '16px',
    lg: '18px',
    h6: '20px',
    h5: '24px',
    h4: '28px',
    h3: '32px',
    h2: '36px',
    h1: '48px'
  }
  return map[size] || '16px'
}

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    localData.value = { 
      content: newVal.content || '',
      align: newVal.align || 'left',
      textColor: newVal.textColor || '#0f172a',
      fontSize: newVal.fontSize || 'md',
      fontWeight: newVal.fontWeight || 'normal',
      isItalic: newVal.isItalic || false
    }
  }
}, { deep: true })
</script>
