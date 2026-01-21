<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Loading State -->
    <div v-if="isLoading" class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mb-4"></div>
        <p class="text-gray-500 font-medium">Memuat statistik...</p>
    </div>

    <template v-else>
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(stat, index) in mappedStats" :key="index" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
              <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center text-xl', stat.bg]">
                <i :class="['bi', stat.icon, stat.color]"></i>
              </div>
              <div>
                <p class="text-xs font-medium text-gray-500 2xl:text-sm">{{ stat.label }}</p>
                <h3 class="text-xl font-bold text-gray-900 2xl:text-2xl">{{ stat.value }}</h3>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Recent Users -->
          <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
              <h3 class="text-xl font-bold text-gray-900">Pengguna Terbaru</h3>
              <router-link to="/admin/users" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua</router-link>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                    <th class="pb-4 pr-4">Pengguna</th>
                    <th class="pb-4 px-4">Status</th>
                    <th class="pb-4 pl-4">Bergabung</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                  <tr v-for="user in stats.recent_users" :key="user.id" class="text-sm group hover:bg-gray-50 transition-colors">
                    <td class="py-4 pr-4">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                          {{ user.name[0] }}
                        </div>
                        <div>
                          <p class="font-bold text-gray-900">{{ user.name }}</p>
                          <p class="text-xs text-gray-500">{{ user.email }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="py-4 px-4">
                      <span :class="['px-2 py-0.5 rounded-full text-[10px] font-bold uppercase', user.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500']">
                        {{ user.status }}
                      </span>
                    </td>
                    <td class="py-4 pl-4 text-gray-500">{{ formatDate(user.created_at?.date || user.created_at) }}</td>
                  </tr>
                  <tr v-if="stats.recent_users.length === 0">
                    <td colspan="3" class="py-8 text-center text-gray-400">Belum ada pengguna.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h3>
            <div class="space-y-3">
              <router-link v-for="action in quickActions" :key="action.label" :to="action.to" class="w-full flex items-center gap-4 p-4 rounded-2xl border border-gray-100 hover:border-emerald-600 hover:bg-emerald-50 transition-all text-left group">
                <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white flex items-center justify-center text-gray-500 group-hover:text-emerald-600 transition-colors">
                  <i :class="['bi', action.icon]"></i>
                </div>
                <span class="font-bold text-gray-900 text-sm">{{ action.label }}</span>
              </router-link>
            </div>
          </div>
        </div>
    </template>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useAdminDashboard } from '@/composables/useAdminDashboard'

const { stats, fetchStats, isLoading } = useAdminDashboard()

onMounted(() => {
    fetchStats()
})

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value)
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
}

const mappedStats = computed(() => [
  { label: 'Total Pengguna', value: stats.value.total_users.toLocaleString(), icon: 'bi-people-fill', color: 'text-indigo-600', bg: 'bg-indigo-50' },
  { label: 'Total Halaman', value: stats.value.total_pages.toLocaleString(), icon: 'bi-file-earmark-text-fill', color: 'text-emerald-600', bg: 'bg-emerald-50' },
  { label: 'Total Pendapatan', value: formatCurrency(stats.value.total_revenue), icon: 'bi-cash-stack', color: 'text-amber-600', bg: 'bg-amber-50' },
  { label: 'Total Transaksi', value: stats.value.total_transactions.toLocaleString(), icon: 'bi-credit-card-fill', color: 'text-red-600', bg: 'bg-red-50' },
])

const quickActions = [
  { label: 'Manajemen Pengguna', icon: 'bi-people', to: '/admin/users' },
  { label: 'Manajemen Paket', icon: 'bi-star', to: '/admin/plans' },
  { label: 'Konfigurasi Bank', icon: 'bi-bank', to: '/admin/banks' },
  { label: 'Kelola FAQ', icon: 'bi-question-circle', to: '/admin/faq' },
]
</script>