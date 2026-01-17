<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Upgrade Banner -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-lg shadow-emerald-600/20">
      <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-bold uppercase tracking-wider mb-4">
            <i class="bi bi-star-fill text-amber-300"></i>
            Penawaran Terbatas
          </div>
          <h2 class="text-2xl sm:text-3xl font-bold mb-2">Buka Fitur Tanpa Batas!</h2>
          <p class="text-emerald-50 max-w-lg">Upgrade ke paket <span class="font-bold text-white">Pro</span> untuk mendapatkan fitur Grid Layout, Countdown, Custom Background, dan statistik mendalam.</p>
        </div>
        <router-link to="/member/upgrade" class="px-8 py-4 bg-white text-emerald-700 font-bold rounded-2xl hover:bg-emerald-50 transition-all text-center shadow-xl shadow-black/5 whitespace-nowrap">
          Upgrade Sekarang
        </router-link>
      </div>
      <!-- Decorative Ornaments -->
      <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl"></div>
    </div>

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
        
        <!-- Chart -->
        <div class="h-64 relative">
            <Line :data="chartData" :options="chartOptions" />
        </div>
      </div>

      <!-- Recent Pages -->
      <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Halaman Terbaru</h3>
        <div class="space-y-4">
            <div v-for="i in 3" :key="i" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold flex-shrink-0">
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
import { ref, computed } from 'vue'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Filler
} from 'chart.js'
import { Line } from 'vue-chartjs'

// Register ChartJS components
ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
)

const stats = [
  { label: 'Total Views', value: '24.5k', icon: 'bi-eye-fill', color: 'text-emerald-600', bg: 'bg-emerald-50', trend: '+12.5%', trendingUp: true },
  { label: 'Total Clicks', value: '8.2k', icon: 'bi-cursor-fill', color: 'text-blue-600', bg: 'bg-blue-50', trend: '+5.2%', trendingUp: true },
  { label: 'Followers', value: '1.4k', icon: 'bi-people-fill', color: 'text-purple-600', bg: 'bg-purple-50', trend: '-2.1%', trendingUp: false },
  { label: 'Avg CTR', value: '33.5%', icon: 'bi-percent', color: 'text-orange-600', bg: 'bg-orange-50', trend: '+8.7%', trendingUp: true },
]

// Chart Data
const chartData = {
  labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
  datasets: [
    {
      label: 'Kunjungan',
      backgroundColor: 'rgba(16, 185, 129, 0.1)',
      borderColor: '#10b981',
      pointBackgroundColor: '#10b981',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: '#10b981',
      fill: true,
      tension: 0.4,
      data: [1200, 1900, 1500, 2200, 1800, 2500, 3100]
    }
  ]
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    tooltip: {
      mode: 'index',
      intersect: false,
      padding: 12,
      backgroundColor: '#1f2937',
      titleFont: { size: 12, weight: 'bold' },
      bodyFont: { size: 12 },
      cornerRadius: 8
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      grid: {
        color: '#f3f4f6',
        drawBorder: false
      },
      ticks: {
        callback: (value) => value >= 1000 ? (value / 1000) + 'k' : value
      }
    },
    x: {
      grid: {
        display: false
      }
    }
  }
}
</script>
