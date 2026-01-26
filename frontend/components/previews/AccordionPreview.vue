<template>
  <div class="space-y-3">
    <div
        v-for="(item, index) in safeItems"
        :key="index"
        class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm bg-white transition-all"
        :class="{ 'ring-2 ring-emerald-500/20 border-emerald-100': activeIndex === index }"
    >
      <!-- Header -->
      <div
        @click="toggle(index)"
        class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 transition-colors"
      >
        <span class="font-bold text-sm text-gray-900 pr-4">{{ item.title || 'Accordion Title' }}</span>
        <i
            :class="['bi bi-chevron-down transition-transform duration-300', activeIndex === index ? 'rotate-180' : '']"
            :style="{ color: theme?.accentColor || '#059669' }"
        ></i>
      </div>

      <!-- Content Area with Transition -->
      <div
        v-if="activeIndex === index"
        class="px-4 pb-4 animate-fade-in"
      >
        <div class="pt-2 border-t border-gray-50 text-xs text-gray-500 leading-relaxed whitespace-pre-wrap">
            {{ item.content || 'No content provided.' }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  data: Object,
  theme: Object
})

const activeIndex = ref(null)

const safeItems = computed(() => {
  if (Array.isArray(props.data)) return props.data
  return props.data?.items || []
})

const toggle = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index
}
</script>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out forwards;
}
</style>
