<template>
  <div class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Judul Countdown (Opsional)</label>
      <input 
        v-model="localData.title"
        @input="emitUpdate"
        type="text"
        placeholder="Contoh: Promo Berakhir Dalam..."
        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Target</label>
      <input 
        v-model="localData.targetDate"
        @input="emitUpdate"
        type="datetime-local"
        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Tampilan</label>
      <div class="flex items-center gap-2">
        <button 
          v-for="style in ['simple', 'cards']" 
          :key="style"
          @click="setStyle(style)"
          :class="[
            'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors capitalize',
            localData.style === style ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
          ]"
        >
          {{ style }}
        </button>
      </div>
    </div>

    <!-- Preview (Static) -->
    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-center">
      <p v-if="localData.title" class="text-sm text-gray-500 mb-2">{{ localData.title }}</p>
      <div v-if="localData.style === 'cards'" class="flex justify-center gap-2">
        <div v-for="unit in ['Hari', 'Jam', 'Menit', 'Detik']" :key="unit" class="bg-white p-2 rounded-lg shadow-sm border border-gray-100 min-w-[60px]">
          <span class="block text-xl font-bold text-gray-900">00</span>
          <span class="text-[10px] uppercase text-gray-500">{{ unit }}</span>
        </div>
      </div>
      <div v-else class="text-3xl font-bold text-gray-900 tracking-widest font-mono">
        00 : 00 : 00 : 00
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
  title: props.modelValue?.data?.title || '',
  targetDate: props.modelValue?.data?.targetDate || '',
  style: props.modelValue?.data?.style || 'cards'
})

const setStyle = (style) => {
  localData.value.style = style
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
