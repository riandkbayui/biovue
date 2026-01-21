<template>
  <div class="space-y-8 animate-fade-in py-8">
    <h1 class="text-3xl font-black text-gray-900">Tagihan & Pembayaran</h1>

    <div v-if="isLoading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
    </div>

    <div v-else-if="transactions.length > 0" class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50/50 border-b border-gray-100">
          <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
            <th class="py-6 px-8">No. Transaksi</th>
            <th class="py-6 px-8">Paket</th>
            <th class="py-6 px-8">Jumlah</th>
            <th class="py-6 px-8">Status</th>
            <th class="py-6 px-8">Tanggal</th>
            <th class="py-6 px-8 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-for="t in transactions" :key="t.id" class="group hover:bg-gray-50/50 transition-colors">
            <td class="py-6 px-8 font-black text-gray-900">#{{ t.id }}</td>
            <td class="py-6 px-8 font-bold text-gray-700">{{ t.plan_name }}</td>
            <td class="py-6 px-8 font-black text-emerald-600">{{ formatCurrency(t.amount) }}</td>
            <td class="py-6 px-8">
              <span :class="['px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest', getStatusClass(t.status)]">
                {{ t.status }}
              </span>
            </td>
            <td class="py-6 px-8 text-sm text-gray-500 font-medium">{{ formatDate(t.created_at.date || t.created_at) }}</td>
            <td class="py-6 px-8 text-right">
              <router-link :to="`/member/invoice?id=${t.id}`" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-black rounded-xl hover:bg-emerald-600 hover:text-white transition-all">
                LIHAT DETAIL
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else class="text-center py-24 bg-white rounded-[3rem] border border-gray-100 border-dashed">
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-300">
            <i class="bi bi-receipt text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Belum ada tagihan</h3>
        <p class="text-gray-500 mt-2 mb-8">Upgrade paket Anda untuk menikmati fitur premium.</p>
        <router-link to="/member/upgrade" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
            Pilih Paket Sekarang
        </router-link>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePayments } from '@/composables/usePayments'

const { transactions, isLoading, fetchHistory } = usePayments()

onMounted(() => fetchHistory())

const formatCurrency = (val) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val)
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
}

const getStatusClass = (status) => {
    switch(status) {
        case 'paid': return 'bg-emerald-100 text-emerald-700'
        case 'pending': return 'bg-amber-100 text-amber-700'
        case 'failed': return 'bg-red-100 text-red-700'
        default: return 'bg-gray-100 text-gray-500'
    }
}
</script>
