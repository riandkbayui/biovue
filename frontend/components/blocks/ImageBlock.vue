<template>
  <div class="space-y-3">
    <!-- Upload Area -->
    <div v-if="!localData.url" class="relative">
      <input
        type="file"
        accept="image/*"
        @change="handleImageUpload"
        class="hidden"
        ref="imageInput"
      >
      <button
        @click="$refs.imageInput.click()"
        type="button"
        class="w-full py-12 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex flex-col items-center justify-center gap-2 text-gray-500 hover:text-emerald-600"
      >
        <i class="bi bi-image text-4xl"></i>
        <span class="font-medium">Klik untuk upload gambar</span>
        <span class="text-xs">PNG, JPG, GIF (Max 2MB)</span>
      </button>
    </div>

    <!-- Preview Area -->
    <div v-else class="space-y-3">
      <div class="relative rounded-xl overflow-hidden border-2 border-gray-200 bg-gray-50">
        <Image :src="localData.url" :alt="localData.alt" class="w-full h-auto" />
        <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
          <button
            @click="$refs.imageInput.click()"
            type="button"
            class="px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium hover:bg-gray-100 transition-colors flex items-center gap-2"
          >
            <i class="bi bi-arrow-repeat"></i>
            Ganti
          </button>
          <button
            @click="removeImage"
            type="button"
            class="px-3 py-2 rounded-lg bg-red-500 text-white text-sm font-medium hover:bg-red-600 transition-colors flex items-center gap-2"
          >
            <i class="bi bi-trash"></i>
            Hapus
          </button>
        </div>
      </div>

      <input
        v-model="localData.alt"
        @input="emitUpdate"
        type="text"
        placeholder="Deskripsi gambar (alt text)"
        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
      />
    </div>

    <div v-if="localData.url" class="flex flex-wrap items-center gap-2">
      <span class="text-sm font-medium text-gray-700">Ukuran:</span>
      <button
        v-for="size in ['small', 'medium', 'large']"
        :key="size"
        @click="setSize(size)"
        :class="[
          'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors capitalize',
          localData.size === size ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        {{ size }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Image from '@/components/Image.vue'
import { useUpload } from '@/composables/useUpload'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])
const { uploadImage, isUploading } = useUpload()

const imageInput = ref(null)

const localData = ref({
  url: props.modelValue?.url || '',
  alt: props.modelValue?.alt || '',
  size: props.modelValue?.size || 'medium'
})

const setSize = (size) => {
  localData.value.size = size
  emitUpdate()
}

const handleImageUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  // Validate file size (max 2MB)
  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file terlalu besar! Maksimal 2MB.')
    event.target.value = ''
    return
  }

  // Validate file type
  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar!')
    event.target.value = ''
    return
  }

  try {
      const result = await uploadImage(file, 'blocks')
      localData.value.url = result.url
      emitUpdate()
  } catch (err) {
      alert('Gagal mengunggah gambar: ' + (err.response?.data?.message || 'Terjadi kesalahan'))
  }
}

const removeImage = () => {
  localData.value.url = ''
  localData.value.alt = ''
  if (imageInput.value) {
    imageInput.value.value = ''
  }
  emitUpdate()
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
