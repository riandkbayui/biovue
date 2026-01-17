<template>
  <div class="max-w-5xl mx-auto space-y-12 py-8 animate-fade-in">
    <div class="text-center space-y-4">
      <h1 class="text-3xl sm:text-4xl font-black text-gray-900">Pilih Paket Terbaikmu</h1>
      <p class="text-gray-500 max-w-2xl mx-auto">Tingkatkan kreativitas dan jangkauan halaman bio Anda dengan fitur-fitur premium dari Aksibio.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div v-for="plan in plans" :key="plan.id" 
        :class="[
          'bg-white rounded-[2.5rem] p-8 border-2 transition-all duration-300 flex flex-col',
          plan.isPopular ? 'border-emerald-500 shadow-2xl shadow-emerald-500/10 scale-105 relative' : 'border-gray-100 hover:border-emerald-200 shadow-sm'
        ]"
      >
        <div v-if="plan.isPopular" class="absolute -top-5 left-1/2 -translate-x-1/2 px-4 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full uppercase tracking-widest shadow-lg">
          Paling Populer
        </div>

        <div class="mb-8">
          <div :class="['w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6', plan.iconBg]">
            <i :class="['bi', plan.icon, plan.iconColor]"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">{{ plan.name }}</h3>
          <div class="flex items-baseline gap-1">
            <span class="text-3xl font-black text-gray-900">Rp{{ formatNumber(plan.price) }}</span>
            <span class="text-gray-400 text-sm">/bulan</span>
          </div>
        </div>

        <ul class="space-y-4 mb-10 flex-1">
          <li v-for="feature in plan.features" :key="feature" class="flex items-start gap-3 text-sm text-gray-600">
            <i class="bi bi-check2-circle text-emerald-500 text-lg leading-none"></i>
            <span>{{ feature }}</span>
          </li>
          <li v-for="not in plan.notIncluded" :key="not" class="flex items-start gap-3 text-sm text-gray-400">
            <i class="bi bi-x-circle text-gray-200 text-lg leading-none"></i>
            <span class="line-through">{{ not }}</span>
          </li>
        </ul>

        <button 
          @click="selectPlan(plan)"
          :class="[
            'w-full py-4 rounded-2xl font-bold transition-all',
            plan.isPopular 
              ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20' 
              : 'bg-gray-50 text-gray-900 hover:bg-gray-100'
          ]"
        >
          {{ plan.price === 0 ? 'Paket Saat Ini' : 'Pilih Paket' }}
        </button>
      </div>
    </div>

    <!-- FAQ Preview -->
    <div class="bg-indigo-50/50 rounded-[3rem] p-8 sm:p-12 text-center">
      <h3 class="text-xl font-bold text-gray-900 mb-2">Butuh bantuan memilih?</h3>
      <p class="text-gray-500 text-sm mb-6">Tim kami siap membantu menjawab pertanyaan Anda seputar paket langganan.</p>
      <router-link to="/member/tutorial" class="text-emerald-600 font-bold hover:underline">Lihat FAQ & Panduan</router-link>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const plans = [
  {
    id: 1,
    name: 'Gratis',
    price: 0,
    icon: 'bi-lightning-charge',
    iconBg: 'bg-blue-50',
    iconColor: 'text-blue-600',
    features: ['Hingga 3 Halaman Bio', 'Basic Block (Teks, Link, Gambar)', 'Warna Solid Background', 'Statistik Kunjungan Harian'],
    notIncluded: ['Custom Background Image', 'Pro Blocks (Grid, Timer, dll)', 'Email Support']
  },
  {
    id: 2,
    name: 'Pro',
    price: 49000,
    isPopular: true,
    icon: 'bi-star-fill',
    iconBg: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    features: ['Halaman Tak Terbatas', 'Semua Fitur Pro Blocks', 'Custom Background Image', 'Statistik Detail (7 hari)', 'Prioritas Support'],
    notIncluded: ['Custom Domain']
  },
  {
    id: 3,
    name: 'Enterprise',
    price: 129000,
    icon: 'bi-gem',
    iconBg: 'bg-indigo-50',
    iconColor: 'text-indigo-600',
    features: ['Semua Fitur Pro', 'Custom Domain', 'Statistik Mendalam (30 hari)', 'Dedicated Account Manager'],
    notIncluded: []
  }
]

const formatNumber = (num) => {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

const selectPlan = (plan) => {
  if (plan.price === 0) return
  // Redirect to checkout with plan info (in real app, use store)
  router.push({
    name: 'member-checkout',
    query: { planId: plan.id, name: plan.name, price: plan.price }
  })
}
</script>
