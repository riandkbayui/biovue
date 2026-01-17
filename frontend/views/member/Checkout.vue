<template>
  <div class="max-w-4xl mx-auto py-8 animate-fade-in px-4">
    <div class="flex items-center gap-4 mb-8">
      <button @click="$router.back()" class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-50">
        <i class="bi bi-arrow-left"></i>
      </button>
      <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Checkout Details -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Plan Summary -->
        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
          <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-cart3 text-emerald-600"></i>
            Ringkasan Paket
          </h3>
          <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <i class="bi bi-star-fill"></i>
              </div>
              <div>
                <p class="font-bold text-gray-900">Paket {{ $route.query.name || 'Pro' }}</p>
                <p class="text-xs text-gray-500">Berlaku selama 30 hari</p>
              </div>
            </div>
            <p class="font-black text-gray-900">Rp{{ formatNumber($route.query.price || 49000) }}</p>
          </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
          <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-credit-card text-emerald-600"></i>
            Pilih Metode Pembayaran
          </h3>
          <div class="space-y-3">
            <div 
              v-for="method in paymentMethods" 
              :key="method.id"
              @click="selectedMethod = method.id"
              :class="[
                'flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all',
                selectedMethod === method.id ? 'border-emerald-500 bg-emerald-50/30' : 'border-gray-100 hover:border-gray-200'
              ]"
            >
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-white border border-gray-100 flex items-center justify-center text-lg text-indigo-600">
                  <i :class="['bi', method.icon]"></i>
                </div>
                <div>
                  <p class="font-bold text-sm text-gray-900">{{ method.bank }}</p>
                  <p class="text-[10px] text-gray-500 uppercase tracking-wider">Transfer Bank</p>
                </div>
              </div>
              <div :class="['w-5 h-5 rounded-full border-2 flex items-center justify-center', selectedMethod === method.id ? 'border-emerald-500' : 'border-gray-200']">
                <div v-if="selectedMethod === method.id" class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Price Breakdown -->
      <div class="space-y-6">
        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm sticky top-24">
          <h3 class="font-bold text-gray-900 mb-6 text-lg">Detail Pembayaran</h3>
          <div class="space-y-4">
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Subtotal</span>
              <span class="font-bold text-gray-900">Rp{{ formatNumber($route.query.price || 49000) }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Kode Unik</span>
              <span class="font-bold text-emerald-600">Rp{{ uniqueCode }}</span>
            </div>
            <div class="border-t border-dashed border-gray-200 pt-4 mt-4">
              <div class="flex justify-between items-baseline mb-6">
                <span class="font-bold text-gray-900 text-lg">Total</span>
                <span class="text-2xl font-black text-emerald-600">Rp{{ formatNumber(parseInt($route.query.price || 49000) + uniqueCode) }}</span>
              </div>
              <button 
                @click="processCheckout"
                class="w-full py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2"
              >
                Bayar Sekarang
                <i class="bi bi-arrow-right"></i>
              </button>
              <p class="text-[10px] text-gray-400 text-center mt-4 uppercase font-bold tracking-wider">Transaksi Aman & Terenkripsi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const selectedMethod = ref(1)
const uniqueCode = ref(Math.floor(Math.random() * 900) + 100)

const paymentMethods = [
  { id: 1, bank: 'BCA Transfer', icon: 'bi-bank' },
  { id: 2, bank: 'Mandiri Transfer', icon: 'bi-bank2' },
  { id: 3, bank: 'BNI Transfer', icon: 'bi-building-columns' },
]

const formatNumber = (num) => {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

const processCheckout = () => {
  if (!selectedMethod.value) {
    alert('Silakan pilih metode pembayaran')
    return
  }
  
  router.push({
    name: 'member-invoice',
    query: { 
      price: route.query.price || 49000, 
      unique: uniqueCode.value 
    }
  })
}
</script>
