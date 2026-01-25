<template>
  <div class="text-center">
    <p v-if="data?.title" class="text-sm text-gray-500 mb-3 font-medium">{{ data.title }}</p>

    <div v-if="data?.style === 'cards'" class="flex justify-center gap-3 sm:gap-4">
      <div v-for="unit in timeUnits" :key="unit.label" class="flex flex-col items-center">
        <div
          class="text-white w-14 h-14 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center shadow-lg mb-2 animate-pulse-slow border-2 border-white/20"
          :style="{ backgroundColor: theme?.accentColor || '#0f172a' }"
        >
          <span class="text-2xl sm:text-3xl font-black font-mono tracking-tighter">{{ unit.value }}</span>
        </div>
        <span class="text-[12px] font-extrabold text-gray-500 uppercase tracking-widest">{{ unit.label }}</span>
      </div>
    </div>

    <div v-else class="flex justify-center items-center gap-4 py-4 px-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div v-for="(unit, index) in timeUnits" :key="unit.label" class="flex items-center">
            <div class="flex flex-col items-center">
                <span class="text-3xl font-black font-mono tracking-tighter leading-none" :style="{ color: theme?.accentColor || '#0f172a' }">
                    {{ unit.value }}
                </span>
                <span class="text-[9px] font-bold text-gray-400 uppercase mt-1">{{ unit.label }}</span>
            </div>
            <span v-if="index < timeUnits.length - 1" class="mx-3 text-gray-200 text-2xl font-light mb-4">:</span>
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const timeLeft = ref({
  days: '00',
  hours: '00',
  minutes: '00',
  seconds: '00'
})

let timer = null

const timeUnits = computed(() => [
  { label: 'Hari', value: timeLeft.value.days },
  { label: 'Jam', value: timeLeft.value.hours },
  { label: 'Menit', value: timeLeft.value.minutes },
  { label: 'Detik', value: timeLeft.value.seconds },
])

const calculateTimeLeft = () => {
  const targetStr = props.data?.targetDate || props.data?.datetime
  if (!targetStr) return

  const target = new Date(targetStr).getTime()
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

onMounted(() => {
  calculateTimeLeft()
  timer = setInterval(calculateTimeLeft, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>

<style scoped>
.animate-pulse-slow {
  animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.9; }
}
</style>
