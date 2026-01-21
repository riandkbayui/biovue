<template>
  <div class="space-y-12 animate-fade-in max-w-5xl mx-auto py-8">
    <div class="text-center space-y-4">
      <h1 class="text-4xl font-black text-gray-900">Pilih Paket Terbaik Anda</h1>
      <p class="text-gray-500 max-w-lg mx-auto text-lg">Buka semua fitur premium dan bangun brand Anda lebih profesional dengan paket Pro.</p>
    </div>

    <div v-if="isLoading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <div v-for="plan in plans" :key="plan.id" 
        :class="['relative p-8 rounded-[2.5rem] border-2 transition-all flex flex-col h-full', 
                 plan.price > 0 ? 'border-emerald-500 shadow-2xl shadow-emerald-100 scale-105 bg-white z-10' : 'border-gray-100 bg-gray-50/50']">
        
        <div v-if="plan.price > 0" class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-full">
            Terpopuler
        </div>

        <div class="mb-8">
          <h3 class="text-2xl font-black text-gray-900 mb-2">{{ plan.name }}</h3>
          <p class="text-gray-500 text-sm leading-relaxed">{{ plan.description }}</p>
        </div>

        <div class="mb-8">
          <div class="flex items-baseline gap-1">
            <span class="text-4xl font-black text-gray-900">{{ formatCurrency(plan.price) }}</span>
            <span v-if="plan.price > 0" class="text-gray-400 font-bold">/bulan</span>
          </div>
        </div>

        <div class="space-y-4 mb-10 flex-1">
          <div v-for="(feat, idx) in plan.features_list" :key="idx" class="flex items-start gap-3 text-sm text-gray-700">
            <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="bi bi-check text-emerald-600 text-lg"></i>
            </div>
            <span>{{ feat }}</span>
          </div>
        </div>

        <button 
            @click="handleSelectPlan(plan)"
            :disabled="isCurrentPlan(plan) || isCheckoutLoading"
            :class="['w-full py-4 rounded-2xl font-black transition-all flex items-center justify-center gap-2', 
                     isCurrentPlan(plan) ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 
                     (plan.price > 0 ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200' : 'bg-white border-2 border-gray-200 text-gray-900 hover:bg-gray-50')]">
            <span v-if="isCheckoutLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            {{ isCurrentPlan(plan) ? 'Paket Saat Ini' : (plan.price > 0 ? 'Upgrade Sekarang' : 'Gunakan Gratis') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { usePayments } from '@/composables/usePayments'
import { useAuthStore } from '@/stores/auth'

const { plans, fetchPlans, isLoading, createCheckout } = usePayments()
const authStore = useAuthStore()
const router = useRouter()
const isCheckoutLoading = ref(false)

onMounted(() => fetchPlans())

const formatCurrency = (val) => {
    if (val == 0) return 'Gratis'
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val)
}

const isCurrentPlan = (plan) => {
    return authStore.user.role === 'member' && plan.price === 0 && !authStore.user.is_pro // Simple check
}

const handleSelectPlan = async (plan) => {
    if (plan.price === 0) return
    
    isCheckoutLoading.value = true
    try {
        const transaction = await createCheckout(plan.id)
        router.push(`/member/invoice?id=${transaction.id}`)
    } catch (e) {
        alert('Terjadi kesalahan saat memproses checkout.')
    } finally {
        isCheckoutLoading.value = false
    }
}
</script>