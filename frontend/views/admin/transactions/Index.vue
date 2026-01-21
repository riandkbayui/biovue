<template>
  <div class="space-y-6 animate-fade-in">
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider">
            <th class="py-4 px-6">Pelanggan</th>
            <th class="py-4 px-6">Paket</th>
            <th class="py-4 px-6">Jumlah</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6">Tanggal</th>
            <th class="py-4 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-if="isLoading">
            <td colspan="6" class="py-8 text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto"></div></td>
          </tr>
          <tr v-for="t in transactions" :key="t.id" class="group hover:bg-gray-50 transition-colors">
            <td class="py-4 px-6">
                <p class="font-bold text-gray-900 leading-none">{{ t.user_name }}</p>
                <p class="text-[10px] text-gray-400 mt-1 uppercase">{{ t.user_email }}</p>
            </td>
            <td class="py-4 px-6 font-medium text-gray-700">{{ t.plan_name }}</td>
            <td class="py-4 px-6 font-mono text-sm font-bold">{{ formatCurrency(t.amount) }}</td>
            <td class="py-4 px-6">
              <span :class="['px-2 py-1 rounded-lg text-[10px] font-bold uppercase', getStatusClass(t.status)]">
                {{ t.status }}
              </span>
            </td>
            <td class="py-4 px-6 text-xs text-gray-500">{{ formatDate(t.created_at.date || t.created_at) }}</td>
            <td class="py-4 px-6 text-right">
              <div v-if="t.status === 'pending'" class="flex items-center justify-end gap-2">
                <button @click="handleConfirm(t.id)" class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold hover:bg-emerald-100">Konfirmasi</button>
                <button @click="handleReject(t.id)" class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100">Tolak</button>
              </div>
              <div v-else class="text-xs text-gray-400 italic">No Action</div>
            </td>
          </tr>
          <tr v-if="!isLoading && transactions.length === 0">
            <td colspan="6" class="py-8 text-center text-gray-400">Belum ada riwayat transaksi.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAdminTransactions } from '@/composables/useAdminTransactions'

const { transactions, isLoading, fetchTransactions, confirmPayment, rejectPayment } = useAdminTransactions()

onMounted(() => fetchTransactions())

const formatCurrency = (val) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val)
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    return new Date(dateString).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

const getStatusClass = (status) => {
    switch(status) {
        case 'paid': return 'bg-emerald-50 text-emerald-600'
        case 'pending': return 'bg-amber-50 text-amber-600'
        case 'failed': return 'bg-red-50 text-red-600'
        default: return 'bg-gray-100 text-gray-500'
    }
}

const handleConfirm = async (id) => {
    if (confirm('Konfirmasi pembayaran ini? Paket user akan otomatis diaktifkan.')) {
        try {
            const res = await confirmPayment(id)
            alert(res.message)
        } catch (e) {
            alert('Gagal mengkonfirmasi pembayaran.')
        }
    }
}

const handleReject = async (id) => {
    if (confirm('Tolak pembayaran ini?')) {
        try {
            await rejectPayment(id)
        } catch (e) {
            alert('Gagal menolak transaksi.')
        }
    }
}
</script>
