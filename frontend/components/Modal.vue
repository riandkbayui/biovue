<template>
  <teleport to="body">
    <transition name="fade">
      <div
        v-if="modelValue"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        @click.self="$emit('update:modelValue', false)"
      >
        <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3">
          <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200">
            <h3 class="text-lg font-semibold">
              <slot name="header">Modal Title</slot>
            </h3>
            <button @click="$emit('update:modelValue', false)" class="text-gray-400 hover:text-gray-500">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="p-4">
            <slot></slot>
          </div>
          <div v-if="$slots.footer" class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script setup>
defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
});

defineEmits(['update:modelValue']);
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
