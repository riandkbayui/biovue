<template>
  <div class="space-y-8 animate-fade-in pb-20">
    <!-- Header -->
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Tagihan</h1>
      <p class="text-gray-500 mt-1">Kelola langganan dan riwayat pembayaran anda</p>
    </div>

    <!-- Summary Card -->
    <div class="bg-emerald-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-200">
      <div class="flex items-center justify-between mb-4">
        <span class="text-emerald-100 text-sm font-medium">Total Tagihan Aktif</span>
        <i class="bi bi-wallet2 text-xl"></i>
      </div>
      <div class="flex items-end gap-2">
        <h2 class="text-3xl font-bold">Rp 49.000</h2>
        <span class="text-emerald-100 text-sm mb-1">/ bulan</span>
      </div>
      <div class="mt-6 pt-6 border-t border-emerald-500/30 flex items-center justify-between">
        <div class="text-sm">
          <p class="text-emerald-100">Jatuh Tempo Selanjutnya</p>
          <p class="font-bold mt-0.5">20 Februari 2026</p>
        </div>
        <button class="bg-white text-emerald-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-50 transition-colors">
          Bayar Sekarang
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
      <button 
        v-for="filter in ['Semua', 'Pending', 'Lunas', 'Gagal']" 
        :key="filter"
        @click="activeFilter = filter"
        :class="['px-5 py-2 rounded-xl text-sm font-bold whitespace-nowrap transition-all', activeFilter === filter ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 border border-gray-100 hover:bg-gray-50']"
      >
        {{ filter }}
      </button>
    </div>

    <!-- Bills List (Cards for Mobile) -->
    <div class="space-y-4">
      <div v-for="bill in filteredBills" :key="bill.id" class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
        <div class="flex items-start justify-between mb-4">
          <div class="flex items-center gap-4">
            <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center text-xl', bill.status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600']">
              <i :class="['bi', bill.status === 'paid' ? 'bi-check-circle-fill' : 'bi-clock-history']"></i>
            </div>
            <div>
              <h4 class="font-bold text-gray-900">{{ bill.name }}</h4>
              <p class="text-xs text-gray-400 mt-0.5">{{ bill.id }} • {{ bill.date }}</p>
            </div>
          </div>
          <Badge :variant="bill.variant">{{ bill.statusText }}</Badge>
        </div>
        
        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
          <div>
            <p class="text-xs text-gray-500">Jumlah Tagihan</p>
            <p class="font-bold text-gray-900">{{ bill.amount }}</p>
          </div>
          <div class="flex gap-2">
            <button class="p-2 text-gray-400 hover:text-emerald-600 transition-colors">
              <i class="bi bi-download"></i>
            </button>
            <button v-if="bill.status === 'pending'" class="text-sm font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-xl hover:bg-emerald-100 transition-colors">
              Bayar
            </button>
            <button v-else class="text-sm font-bold text-gray-600 bg-gray-50 px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors">
              Detail
            </button>
          </div>
        </div>
      </div>
      
      <!-- Empty State -->
      <div v-if="filteredBills.length === 0" class="text-center py-12">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="bi bi-receipt text-3xl text-gray-300"></i>
        </div>
        <p class="text-gray-500 font-medium">Tidak ada tagihan ditemukan</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Badge from '@/components/Badge.vue';

const activeFilter = ref('Semua');

const bills = [
  { 
    id: 'INV-2026-001', 
    name: 'Paket Pro - Bulanan', 
    date: '20 Jan 2026', 
    amount: 'Rp 49.000', 
    status: 'pending', 
    statusText: 'Belum Bayar',
    variant: 'warning' 
  },
  { 
    id: 'INV-2025-125', 
    name: 'Paket Pro - Bulanan', 
    date: '20 Des 2025', 
    amount: 'Rp 49.000', 
    status: 'paid', 
    statusText: 'Lunas',
    variant: 'success' 
  },
  { 
    id: 'INV-2025-110', 
    name: 'Paket Pro - Bulanan', 
    date: '20 Nov 2025', 
    amount: 'Rp 49.000', 
    status: 'paid', 
    statusText: 'Lunas',
    variant: 'success' 
  },
  { 
    id: 'INV-2025-098', 
    name: 'Add-on: Custom Domain', 
    date: '15 Okt 2025', 
    amount: 'Rp 150.000', 
    status: 'failed', 
    statusText: 'Gagal',
    variant: 'danger' 
  },
];

const filteredBills = computed(() => {
  if (activeFilter.value === 'Semua') return bills;
  
  const statusMap = {
    'Pending': 'pending',
    'Lunas': 'paid',
    'Gagal': 'failed'
  };
  
  return bills.filter(bill => bill.status === statusMap[activeFilter.value]);
});
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>