<template>
  <div class="space-y-4">
    <!-- Image List -->
    <div v-if="localData.images.length > 0" class="space-y-3">
      <div v-for="(image, index) in localData.images" :key="index" class="relative group bg-gray-50 rounded-xl p-2 border border-gray-200 flex items-center gap-3">
        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-white border border-gray-200">
          <Image :src="image.url" class="w-full h-full object-cover" />
        </div>
        <div class="flex-1 min-w-0">
          <input
            v-model="image.caption"
            @change="emitUpdate"
            type="text"
            placeholder="Caption (opsional)"
            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all mb-2"
          />
          <div class="flex items-center gap-2">
            <button
              @click="moveImage(index, -1)"
              :disabled="index === 0"
              class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-colors"
            >
              <i class="bi bi-arrow-up-circle-fill text-lg"></i>
            </button>
            <button
              @click="moveImage(index, 1)"
              :disabled="index === localData.images.length - 1"
              class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-colors"
            >
              <i class="bi bi-arrow-down-circle-fill text-lg"></i>
            </button>
            <button
              @click="removeImage(index)"
              class="p-1 text-red-400 hover:text-red-600 ml-auto transition-colors"
            >
              <i class="bi bi-trash-fill text-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State / Add Button -->
    <div class="relative">
      <input
        type="file"
        multiple
        accept="image/*"
        @change="handleImageUpload"
        class="hidden"
        ref="imageInput"
      >
      <button
        @click="$refs.imageInput.click()"
        type="button"
        class="w-full py-4 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex items-center justify-center gap-2 text-gray-500 hover:text-emerald-600"
      >
        <i class="bi bi-images text-xl"></i>
        <span class="font-medium">Tambah Gambar</span>
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
  images: props.modelValue?.images || props.modelValue?.data?.images || []
})

const handleImageUpload = async (event) => {
  const files = Array.from(event.target.files)
  if (!files.length) return

  for (const file of files) {
    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      alert(`File ${file.name} terlalu besar! Maksimal 2MB.`)
      continue
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
      alert(`File ${file.name} bukan gambar!`)
      continue
    }

    try {
        const result = await uploadImage(file, 'slideshow')
        localData.value.images.push({
            url: result.url,
            caption: ''
        })
        emitUpdate()
    } catch (err) {
        alert(`Gagal mengunggah ${file.name}: ` + (err.response?.data?.message || 'Terjadi kesalahan'))
    }
  }

  // Reset input
  event.target.value = ''
}

const removeImage = (index) => {
  localData.value.images.splice(index, 1)
  emitUpdate()
}

const moveImage = (index, direction) => {
  const newIndex = index + direction
  if (newIndex >= 0 && newIndex < localData.value.images.length) {
    const temp = localData.value.images[index]
    localData.value.images[index] = localData.value.images[newIndex]
    localData.value.images[newIndex] = temp
    emitUpdate()
  }
}

const emitUpdate = () => {
  emit('update', localData.value)
}

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    const images = newVal.images || newVal.data?.images || []
    localData.value.images = [...images]
  }
}, { deep: true })
</script>
