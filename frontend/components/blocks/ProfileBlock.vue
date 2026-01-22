<template>
  <div class="space-y-4">
    <div class="flex flex-col sm:flex-row gap-4 items-start">
      <!-- Avatar Upload -->
      <div class="flex-shrink-0">
        <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200 bg-gray-50 group">
          <img 
            v-if="localData.avatar" 
            :src="localData.avatar" 
            class="w-full h-full object-cover" 
          />
          <div v-else class="w-full h-full flex items-center justify-center text-gray-300">
            <i class="bi bi-person-fill text-4xl"></i>
          </div>
          
          <!-- Overlay -->
          <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-1 cursor-pointer" @click="$refs.avatarInput.click()">
            <i class="bi bi-camera-fill text-white text-xl"></i>
            <span class="text-[10px] text-white font-medium">Ubah</span>
          </div>
        </div>
        <input 
          type="file"
          accept="image/*"
          @change="handleAvatarUpload"
          class="hidden"
          ref="avatarInput"
        >
      </div>

      <!-- Info Inputs -->
      <div class="flex-1 w-full space-y-3">
        <input 
          v-model="localData.name"
          @input="emitUpdate"
          type="text"
          placeholder="Nama Lengkap / Brand"
          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-bold text-lg"
        />
        <textarea 
          v-model="localData.bio"
          @input="emitUpdate"
          rows="2"
          placeholder="Bio singkat..."
          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none text-sm"
        ></textarea>
      </div>
    </div>

    <!-- Customizations -->
    <div class="flex flex-wrap items-center gap-4 pt-2 border-t border-gray-100">
      <!-- Alignment -->
      <div class="flex items-center gap-2">
        <span class="text-xs font-medium text-gray-500">Posisi:</span>
        <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-lg">
          <button 
            v-for="align in ['left', 'center', 'right']" 
            :key="align"
            @click="setAlign(align)"
            :class="[
              'w-8 h-8 rounded-md flex items-center justify-center transition-all',
              localData.align === align ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500 hover:text-gray-700'
            ]"
          >
            <i :class="['bi', `bi-text-${align}`]"></i>
          </button>
        </div>
      </div>

      <!-- Text Color -->
      <div class="flex items-center gap-2">
        <span class="text-xs font-medium text-gray-500">Warna:</span>
        <div class="flex flex-wrap gap-1">
          <button 
            @click="setColor('accent')"
            title="Gunakan Warna Aksen"
            :class="[
              'w-6 h-6 rounded-full border-2 transition-all flex items-center justify-center',
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
import { useUpload } from '@/composables/useUpload'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])
const { uploadImage, isUploading } = useUpload()

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
  avatar: props.modelValue?.avatar || '',
  name: props.modelValue?.name || '',
  bio: props.modelValue?.bio || '',
  align: props.modelValue?.align || 'center',
  textColor: props.modelValue?.textColor || '#0f172a'
})

const setAlign = (align) => {
  localData.value.align = align
  emitUpdate()
}

const setColor = (color) => {
  localData.value.textColor = color
  emitUpdate()
}

const handleAvatarUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  // Validate file size (max 2MB)
  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file terlalu besar! Maksimal 2MB.')
    return
  }

  // Validate file type
  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar!')
    return
  }

  try {
      const result = await uploadImage(file, 'avatars')
      localData.value.avatar = result.url
      emitUpdate()
  } catch (err) {
      alert('Gagal mengunggah foto: ' + (err.response?.data?.message || 'Terjadi kesalahan'))
  }
}

const emitUpdate = () => {
  emit('update', localData.value)
}

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    localData.value = { ...newVal }
  }
}, { deep: true })
</script>
