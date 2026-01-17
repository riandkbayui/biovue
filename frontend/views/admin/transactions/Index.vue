<template>
  <div class="space-y-6 animate-fade-in">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Transaksi</h1>
      <p class="text-gray-500 mt-1">Riwayat semua pembayaran dan langganan pengguna</p>
    </div>

    <Card>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="px-6 py-4">ID Transaksi</th>
              <th class="px-6 py-4">Pengguna</th>
              <th class="px-6 py-4">Jumlah</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4">Tanggal</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="tx in transactions" :key="tx.id" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-indigo-600">
                #{{ tx.id }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="font-bold text-gray-900 text-sm">{{ tx.user }}</div>
                <div class="text-[10px] text-gray-500 uppercase font-bold">{{ tx.plan }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                {{ tx.amount }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <Badge :variant="tx.status === 'Sukses' ? 'success' : 'warning'">{{ tx.status }}</Badge>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ tx.date }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <button class="text-indigo-600 hover:text-indigo-900 transition-colors" @click="$router.push({ name: 'admin-transactions-edit', params: { id: tx.id } })"><i class="bi bi-pencil-square"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Card>
  </div>
</template>

<script setup>
import Card from '../../../components/Card.vue';
import Badge from '../../../components/Badge.vue';

const transactions = [
  { id: 'TXN-882194', user: 'Alex Johnson', plan: 'Pro Bulanan', amount: 'Rp 49.000', status: 'Sukses', date: '16 Jan 2026' },
  { id: 'TXN-882180', user: 'Mike Brown', plan: 'Pro Bulanan', amount: 'Rp 49.000', status: 'Sukses', date: '15 Jan 2026' },
  { id: 'TXN-882175', user: 'Emma Wilson', plan: 'Enterprise Tahunan', amount: 'Rp 1.990.000', status: 'Sukses', date: '14 Jan 2026' },
  { id: 'TXN-882162', user: 'John Smith', plan: 'Pro Bulanan', amount: 'Rp 49.000', status: 'Tertunda', date: '14 Jan 2026' },
  { id: 'TXN-882155', user: 'Sarah Miller', plan: 'Pro Bulanan', amount: 'Rp 49.000', status: 'Sukses', date: '10 Jan 2026' },
]
</script>