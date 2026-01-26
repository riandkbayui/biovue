<template>
  <div v-if="safeImages.length > 0" class="rounded-2xl overflow-hidden relative aspect-video bg-gray-100 group">
    <!-- Slides with Transition -->
    <div class="w-full h-full relative">
      <transition-group name="fade">
        <div
          v-for="(image, index) in safeImages"
          :key="index"
          v-show="currentIndex === index"
          class="absolute inset-0 w-full h-full"
        >
          <Image :src="image.url" class="w-full h-full object-cover" />
          <div v-if="image.caption" class="absolute bottom-0 left-0 right-0 bg-black/50 p-3 text-white text-xs text-center backdrop-blur-sm">
            {{ image.caption }}
          </div>
        </div>
      </transition-group>
    </div>

    <!-- Navigation Dots (Moved to Top) -->
    <div v-if="safeImages.length > 1" class="absolute top-4 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
      <button
        v-for="(_, index) in safeImages"
        :key="index"
        @click="currentIndex = index"
        :class="[
          'w-1.5 h-1.5 rounded-full transition-all shadow-sm',
          currentIndex === index ? 'bg-white w-4' : 'bg-white/20 hover:bg-white/50 backdrop-blur-sm'
        ]"
      ></button>
    </div>

    <!-- Slide Badge -->
    <div v-if="safeImages.length > 1" class="absolute top-3 right-3 px-2 py-1 rounded-lg text-[10px] text-white font-black bg-black/20 backdrop-blur-md border border-white/10 z-10">
      {{ currentIndex + 1 }} / {{ safeImages.length }}
    </div>

    <!-- Navigation Arrows (Hidden on mobile, show on hover desktop) -->
    <button @click="prev" v-if="safeImages.length > 1" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm text-white opacity-0 group-hover:opacity-100 transition-opacity hidden sm:flex items-center justify-center hover:bg-white/40">
      <i class="bi bi-chevron-left"></i>
    </button>
    <button @click="next" v-if="safeImages.length > 1" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm text-white opacity-0 group-hover:opacity-100 transition-opacity hidden sm:flex items-center justify-center hover:bg-white/40">
      <i class="bi bi-chevron-right"></i>
    </button>
  </div>
</template>

<script setup>
import Image from '@/components/Image.vue'
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const currentIndex = ref(0)
let timer = null

const safeImages = computed(() => {
  if (Array.isArray(props.data)) return props.data
  return props.data?.images || []
})

const next = () => {
  if (!safeImages.value.length) return
  currentIndex.value = (currentIndex.value + 1) % safeImages.value.length
}

const prev = () => {
  if (!safeImages.value.length) return
  currentIndex.value = (currentIndex.value - 1 + safeImages.value.length) % safeImages.value.length
}

const startTimer = () => {
  if (safeImages.value.length > 1) {
    timer = setInterval(next, 5000) // Slide setiap 5 detik
  }
}

const stopTimer = () => {
  if (timer) clearInterval(timer)
}

onMounted(() => {
  startTimer()
})

onUnmounted(() => {
  stopTimer()
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.8s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
