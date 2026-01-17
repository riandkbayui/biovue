<template>
  <div :class="['p-4 rounded-xl flex items-start gap-3', getTypeClasses(data?.type)]">
    <i :class="['bi text-lg mt-0.5', getTypeIcon(data?.type)]"></i>
    <div class="text-sm font-medium whitespace-pre-wrap">
      {{ data?.content || 'Alert content' }}
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: Object
})

const getTypeClasses = (type) => {
  const classes = {
    info: 'bg-blue-50 text-blue-700',
    success: 'bg-emerald-50 text-emerald-700',
    warning: 'bg-amber-50 text-amber-700',
    danger: 'bg-red-50 text-red-700',
  }
  return classes[type] || classes.info
}

const getTypeIcon = (type) => {
  const icons = {
    info: 'bi-info-circle-fill',
    success: 'bi-check-circle-fill',
    warning: 'bi-exclamation-triangle-fill',
    danger: 'bi-exclamation-octagon-fill',
  }
  return icons[type] || icons.info
}
</script>
