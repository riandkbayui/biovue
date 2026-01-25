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

    <!-- Preview (Real-time in Editor) -->
    <div class="p-6 bg-gray-50 rounded-2xl border border-gray-200 text-center">
      <p v-if="localData.title" class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ localData.title }}</p>

      <div v-if="localData.style === 'cards'" class="flex justify-center gap-2">
        <div v-for="unit in editorTimeUnits" :key="unit.label" class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 min-w-[55px]">
          <span class="block text-xl font-black text-gray-900 font-mono">{{ unit.value }}</span>
          <span class="text-[9px] font-bold uppercase text-gray-400">{{ unit.label }}</span>
        </div>
      </div>
      <div v-else class="text-2xl font-black text-gray-900 tracking-tighter font-mono bg-white inline-block px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
        {{ timeLeft.days }} : {{ timeLeft.hours }} : {{ timeLeft.minutes }} : {{ timeLeft.seconds }}
      </div>

      <p v-if="!localData.targetDate" class="mt-3 text-[10px] text-amber-600 font-medium">
        <i class="bi bi-info-circle mr-1"></i> Pilih waktu target untuk memulai hitungan
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue', 'update'])

const localData = ref({
  title: props.modelValue?.content?.title || '',
  targetDate: props.modelValue?.content?.targetDate || props.modelValue?.content?.datetime || '',
  style: props.modelValue?.content?.style || 'cards'
})

// Countdown Logic for Editor Preview
const timeLeft = ref({ days: '00', hours: '00', minutes: '00', seconds: '00' })
let timer = null

const editorTimeUnits = computed(() => [
  { label: 'Hari', value: timeLeft.value.days },
  { label: 'Jam', value: timeLeft.value.hours },
  { label: 'Menit', value: timeLeft.value.minutes },
  { label: 'Detik', value: timeLeft.value.seconds },
])

const calculateTime = () => {
  if (!localData.value.targetDate) return

  const target = new Date(localData.value.targetDate).getTime()
  const now = new Date().getTime()
  const diff = target - now

  if (diff <= 0) {
    timeLeft.value = { days: '00', hours: '00', minutes: '00', seconds: '00' }
    return
  }

  const d = Math.floor(diff / (1000 * 60 * 60 * 24))
  const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
  const s = Math.floor((diff % (1000 * 60)) / 1000)

  timeLeft.value = {
    days: d.toString().padStart(2, '0'),
    hours: h.toString().padStart(2, '0'),
    minutes: m.toString().padStart(2, '0'),
    seconds: s.toString().padStart(2, '0')
  }
}

const setStyle = (style) => {
  localData.value.style = style
  emitUpdate()
}

const emitUpdate = () => {
  emit('update', localData.value)
  calculateTime()
}

onMounted(() => {
  calculateTime()
  timer = setInterval(calculateTime, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})

watch(() => props.modelValue, (newVal) => {
  if (newVal?.content) {
    localData.value = {
      title: newVal.content.title || '',
      targetDate: newVal.content.targetDate || newVal.content.datetime || '',
      style: newVal.content.style || 'cards'
    }
    calculateTime()
  }
}, { deep: true })
</script>
