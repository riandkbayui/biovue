<template>
  <div class="text-center">
    <p v-if="data?.title" class="text-sm text-gray-500 mb-2 font-medium">{{ data.title }}</p>
    <div v-if="data?.style === 'cards'" class="flex justify-center gap-2">
      <div v-for="unit in ['D', 'H', 'M', 'S']" :key="unit" class="text-white p-2 rounded-lg min-w-[50px] shadow-sm" :style="{ backgroundColor: theme?.accentColor || '#0f172a' }">
        <span class="block text-xl font-bold">00</span>
        <span class="text-[8px] uppercase opacity-70">{{ unit }}</span>
      </div>
    </div>
    <div v-else class="text-3xl font-bold tracking-widest font-mono" :style="{ color: theme?.accentColor || '#0f172a' }">
      00:00:00:00
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: Object,
  theme: Object
})
</script>
