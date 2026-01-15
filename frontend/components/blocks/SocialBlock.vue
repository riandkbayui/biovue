<template>
  <div class="space-y-3">
    <div class="flex flex-wrap gap-2">
      <button 
        v-for="social in availableSocials" 
        :key="social.name"
        @click="toggleSocial(social.name)"
        :class="[
          'px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2',
          isSelected(social.name) ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        <i :class="['bi', social.icon]"></i>
        {{ social.name }}
      </button>
    </div>
    <div v-if="localData.links.length > 0" class="space-y-2">
      <div v-for="(link, index) in localData.links" :key="index" class="flex items-center gap-2">
        <i :class="['bi', getSocialIcon(link.platform), 'text-gray-500']"></i>
        <input 
          v-model="link.url"
          @input="emitUpdate"
          type="url"
          :placeholder="`URL ${link.platform}`"
          class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
        />
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

const availableSocials = [
  { name: 'Instagram', icon: 'bi-instagram' },
  { name: 'Facebook', icon: 'bi-facebook' },
  { name: 'Twitter', icon: 'bi-twitter' },
  { name: 'LinkedIn', icon: 'bi-linkedin' },
  { name: 'TikTok', icon: 'bi-tiktok' },
  { name: 'YouTube', icon: 'bi-youtube' },
]

const localData = ref({
  links: props.modelValue?.data?.links || []
})

const isSelected = (platform) => {
  return localData.value.links.some(link => link.platform === platform)
}

const toggleSocial = (platform) => {
  const index = localData.value.links.findIndex(link => link.platform === platform)
  if (index > -1) {
    localData.value.links.splice(index, 1)
  } else {
    localData.value.links.push({ platform, url: '' })
  }
  emitUpdate()
}

const getSocialIcon = (platform) => {
  const social = availableSocials.find(s => s.name === platform)
  return social?.icon || 'bi-link'
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
