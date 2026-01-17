<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="(stat, index) in adminStats" :key="index" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
          <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center text-xl', stat.bg]">
            <i :class="['bi', stat.icon, stat.color]"></i>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">{{ stat.label }}</p>
            <h3 class="text-2xl font-bold text-gray-900">{{ stat.value }}</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Recent Users -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between mb-8">
          <h3 class="text-xl font-bold text-gray-900">Pengguna Terbaru</h3>
          <button class="text-sm font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</button>
        </div>
        
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                <th class="pb-4 pr-4">Pengguna</th>
                <th class="pb-4 px-4">Status</th>
                <th class="pb-4 px-4">Paket</th>
                <th class="pb-4 pl-4">Bergabung</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="user in recentUsers" :key="user.id" class="text-sm group hover:bg-gray-50 transition-colors">
                <td class="py-4 pr-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                      {{ user.name[0] }}
                    </div>
                    <div>
                      <p class="font-bold text-gray-900">{{ user.name }}</p>
                      <p class="text-xs text-gray-500">{{ user.email }}</p>
                    </div>
                  </div>
                </td>
                <td class="py-4 px-4">
                  <span :class="['px-2 py-0.5 rounded-full text-[10px] font-bold uppercase', user.active ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500']">
                    {{ user.active ? 'Aktif' : 'Tidak Aktif' }}
                  </span>
                </td>
                <td class="py-4 px-4 font-medium text-gray-600">{{ user.plan }}</td>
                <td class="py-4 pl-4 text-gray-500">{{ user.joined }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h3>
        <div class="space-y-3">
          <button v-for="action in quickActions" :key="action.label" class="w-full flex items-center gap-4 p-4 rounded-2xl border border-gray-100 hover:border-indigo-600 hover:bg-indigo-50 transition-all text-left group">
            <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white flex items-center justify-center text-gray-500 group-hover:text-indigo-600 transition-colors">
              <i :class="['bi', action.icon]"></i>
            </div>
            <span class="font-bold text-gray-900 text-sm">{{ action.label }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const adminStats = [
  { label: 'Total Pengguna', value: '12,450', icon: 'bi-people-fill', color: 'text-indigo-600', bg: 'bg-indigo-50' },
  { label: 'Halaman Aktif', value: '45,200', icon: 'bi-file-earmark-text-fill', color: 'text-emerald-600', bg: 'bg-emerald-50' },
  { label: 'Pendapatan', value: 'Rp 82.5M', icon: 'bi-cash-stack', color: 'text-amber-600', bg: 'bg-amber-50' },
  { label: 'Laporan', value: '124', icon: 'bi-exclamation-triangle-fill', color: 'text-red-600', bg: 'bg-red-50' },
]

const recentUsers = [
  { id: 1, name: 'Alex Johnson', email: 'alex@example.com', active: true, plan: 'Pro', joined: '2 jam yang lalu' },
  { id: 2, name: 'Sarah Miller', email: 'sarah@example.com', active: true, plan: 'Gratis', joined: '5 jam yang lalu' },
  { id: 3, name: 'Mike Brown', email: 'mike@example.com', active: false, plan: 'Pro', joined: '1 hari yang lalu' },
  { id: 4, name: 'Emma Wilson', email: 'emma@example.com', active: true, plan: 'Enterprise', joined: '2 hari yang lalu' },
]

const quickActions = [
  { label: 'Siaran Pesan', icon: 'bi-megaphone' },
  { label: 'Buat Laporan', icon: 'bi-file-earmark-pdf' },
  { label: 'Pemeliharaan Sistem', icon: 'bi-hammer' },
  { label: 'Tinjau Banding', icon: 'bi-shield-exclamation' },
]
</script>