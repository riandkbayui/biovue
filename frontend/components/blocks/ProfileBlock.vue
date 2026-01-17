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

    <!-- Alignment -->
    <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
      <span class="text-xs font-medium text-gray-500">Posisi:</span>
      <button 
        v-for="align in ['left', 'center', 'right']" 
        :key="align"
        @click="setAlign(align)"
        :class="[
          'px-2 py-1 rounded-md text-xs font-medium transition-colors',
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
  avatar: props.modelValue?.data?.avatar || '',
  name: props.modelValue?.data?.name || '',
  bio: props.modelValue?.data?.bio || '',
  align: props.modelValue?.data?.align || 'center'
})

const setAlign = (align) => {
  localData.value.align = align
  emitUpdate()
}

const handleAvatarUpload = (event) => {
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

  // Convert to base64
  const reader = new FileReader()
  reader.onload = (e) => {
    localData.value.avatar = e.target.result
    emitUpdate()
  }
  reader.readAsDataURL(file)
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
