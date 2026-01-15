<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="(stat, index) in stats" :key="index" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
        <div class="flex items-center gap-4">
          <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center text-xl transition-transform group-hover:scale-110', stat.bg]">
            <i :class="['bi', stat.icon, stat.color]"></i>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">{{ stat.label }}</p>
            <h3 class="text-2xl font-bold text-gray-900">{{ stat.value }}</h3>
          </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
            <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', stat.trendingUp ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600']">
                {{ stat.trend }}
            </span>
            <span class="text-xs text-gray-400">vs bulan lalu</span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Quick Activity -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h3 class="text-xl font-bold text-gray-900">Performa Link</h3>
            <p class="text-sm text-gray-500 mt-1">Grafik kunjungan 7 hari terakhir</p>
          </div>
          <select class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
            <option>7 Hari Terakhir</option>
            <option>30 Hari Terakhir</option>
          </select>
        </div>
        
        <!-- Placeholder for Chart -->
        <div class="h-64 bg-gray-50 rounded-2xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 flex-col gap-3">
            <i class="bi bi-graph-up text-4xl"></i>
            <p class="text-sm font-medium">Chart Visualization Placeholder</p>
        </div>
      </div>

      <!-- Recent Pages -->
      <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Halaman Terbaru</h3>
        <div class="space-y-4">
            <div v-for="i in 3" :key="i" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 cursor-pointer">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                    P{{ i }}
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-900 text-sm">aksibio.com/page{{ i }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Dibuat 2 jam yang lalu</p>
                </div>
                <i class="bi bi-chevron-right text-gray-300"></i>
            </div>
            <button class="w-full py-3 text-sm font-bold text-emerald-600 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors mt-4">
                Lihat Semua Halaman
            </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const stats = [
  { label: 'Total Views', value: '24.5k', icon: 'bi-eye-fill', color: 'text-emerald-600', bg: 'bg-emerald-50', trend: '+12.5%', trendingUp: true },
  { label: 'Total Clicks', value: '8.2k', icon: 'bi-cursor-fill', color: 'text-blue-600', bg: 'bg-blue-50', trend: '+5.2%', trendingUp: true },
  { label: 'Followers', value: '1.4k', icon: 'bi-people-fill', color: 'text-purple-600', bg: 'bg-purple-50', trend: '-2.1%', trendingUp: false },
  { label: 'Avg CTR', value: '33.5%', icon: 'bi-percent', color: 'text-orange-600', bg: 'bg-orange-50', trend: '+8.7%', trendingUp: true },
]
</script>
