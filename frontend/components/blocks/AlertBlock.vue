<template>
  <div class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pesan</label>
      <div class="flex flex-wrap gap-2">
        <button 
          v-for="type in types" 
          :key="type.value"
          @click="setType(type.value)"
          :class="[
            'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-2',
            localData.type === type.value 
              ? 'ring-2 ring-offset-1' 
              : 'hover:bg-gray-100',
            getTypeClasses(type.value)
          ]"
        >
          <i :class="['bi', type.icon]"></i>
          {{ type.label }}
        </button>
      </div>
    </div>

    <div>
      <textarea 
        v-model="localData.content"
        @input="emitUpdate"
        rows="3"
        placeholder="Tulis pesan pengumuman di sini..."
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
      ></textarea>
    </div>

    <!-- Preview -->
    <div :class="['p-4 rounded-xl flex items-start gap-3', getTypeClasses(localData.type)]">
      <i :class="['bi text-lg mt-0.5', getTypeIcon(localData.type)]"></i>
      <div class="text-sm font-medium">
        {{ localData.content || 'Preview pesan akan muncul di sini...' }}
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

const types = [
  { value: 'info', label: 'Info', icon: 'bi-info-circle-fill' },
  { value: 'success', label: 'Sukses', icon: 'bi-check-circle-fill' },
  { value: 'warning', label: 'Peringatan', icon: 'bi-exclamation-triangle-fill' },
  { value: 'danger', label: 'Bahaya', icon: 'bi-exclamation-octagon-fill' },
]

const localData = ref({
  content: props.modelValue?.data?.content || '',
  type: props.modelValue?.data?.type || 'info'
})

const setType = (type) => {
  localData.value.type = type
  emitUpdate()
}

const getTypeClasses = (type) => {
  const classes = {
    info: 'bg-blue-50 text-blue-700 ring-blue-500',
    success: 'bg-emerald-50 text-emerald-700 ring-emerald-500',
    warning: 'bg-amber-50 text-amber-700 ring-amber-500',
    danger: 'bg-red-50 text-red-700 ring-red-500',
  }
  return classes[type] || classes.info
}

const getTypeIcon = (type) => {
  const t = types.find(t => t.value === type)
  return t ? t.icon : 'bi-info-circle-fill'
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
