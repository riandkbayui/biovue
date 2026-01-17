<template>
  <div class="space-y-4">
    <!-- Items List -->
    <div v-if="localData.items.length > 0" class="space-y-3">
      <div v-for="(item, index) in localData.items" :key="index" class="bg-gray-50 rounded-xl p-3 border border-gray-200">
        <div class="flex items-start gap-3">
          <div class="flex-1 space-y-2">
            <input 
              v-model="item.title"
              @change="emitUpdate"
              type="text"
              placeholder="Judul Pertanyaan / Bagian"
              class="w-full px-3 py-2 text-sm font-bold border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
            />
            <textarea 
              v-model="item.content"
              @change="emitUpdate"
              rows="2"
              placeholder="Isi konten..."
              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
            ></textarea>
          </div>
          
          <div class="flex flex-col gap-1">
            <button 
              @click="moveItem(index, -1)" 
              :disabled="index === 0"
              class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-colors"
            >
              <i class="bi bi-arrow-up-circle-fill text-lg"></i>
            </button>
            <button 
              @click="moveItem(index, 1)" 
              :disabled="index === localData.items.length - 1"
              class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-colors"
            >
              <i class="bi bi-arrow-down-circle-fill text-lg"></i>
            </button>
            <button 
              @click="removeItem(index)"
              class="p-1 text-red-400 hover:text-red-600 mt-2 transition-colors"
            >
              <i class="bi bi-trash-fill text-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Button -->
    <button
      @click="addItem"
      type="button"
      class="w-full py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex items-center justify-center gap-2 text-gray-500 hover:text-emerald-600"
    >
      <i class="bi bi-plus-circle-fill text-xl"></i>
      <span class="font-medium">Tambah Item</span>
    </button>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  items: props.modelValue?.data?.items || []
})

const addItem = () => {
  localData.value.items.push({
    title: '',
    content: ''
  })
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
