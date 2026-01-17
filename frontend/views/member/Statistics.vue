<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Header & Controls -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Statistik</h1>
        <p class="text-gray-500 mt-1">Analisa performa halaman biovue anda</p>
      </div>
      
      <!-- Time Toggle -->
      <div class="bg-gray-100 p-1 rounded-xl inline-flex">
        <button 
          @click="period = 'daily'"
          :class="['px-4 py-2 text-sm font-semibold rounded-lg transition-all', period === 'daily' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700']"
        >
          Harian
        </button>
        <button 
          @click="period = 'monthly'"
          :class="['px-4 py-2 text-sm font-semibold rounded-lg transition-all', period === 'monthly' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700']"
        >
          Bulanan
        </button>
      </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="(stat, index) in currentStats" :key="index" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
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

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Main Bar Chart -->
      <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Traffic Overview</h3>
        <div class="h-80 w-full relative">
           <Bar :data="barChartData" :options="barChartOptions" />
        </div>
      </div>

      <!-- Donut Chart -->
      <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Perangkat Pengunjung</h3>
        <div class="h-64 w-full relative flex items-center justify-center">
           <Doughnut :data="doughnutChartData" :options="doughnutChartOptions" />
        </div>
        <div class="mt-6 space-y-3">
          <div v-for="(item, i) in deviceStats" :key="i" class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full" :style="{ backgroundColor: item.color }"></span>
              <span class="text-gray-600">{{ item.label }}</span>
            </div>
            <span class="font-bold text-gray-900">{{ item.percentage }}%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Top Pages Performance</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Halaman</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Klik</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Views</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">CTR</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Trend</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="page in topPages" :key="page.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs">
                    P
                  </div>
                  <span class="font-medium text-gray-900">{{ page.name }}</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ page.clicks }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ page.views }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-bold text-emerald-600 bg-emerald-50 rounded-full">{{ page.ctr }}%</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                 <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full" :style="{ width: page.trend + '%' }"></div>
                 </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ArcElement
} from 'chart.js'
import { Bar, Doughnut } from 'vue-chartjs'

// Register ChartJS components
ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Title, Tooltip, Legend)

const period = ref('daily'); // 'daily' or 'monthly'

// Mock Data Generators based on period
const currentStats = computed(() => {
    if (period.value === 'daily') {
        return [
            { label: 'Total Klik Hari Ini', value: '1,240', icon: 'bi-cursor-fill', color: 'text-blue-600', bg: 'bg-blue-50' },
            { label: 'Views Hari Ini', value: '3,850', icon: 'bi-eye-fill', color: 'text-emerald-600', bg: 'bg-emerald-50' },
            { label: 'CTR Hari Ini', value: '32.4%', icon: 'bi-activity', color: 'text-purple-600', bg: 'bg-purple-50' },
        ];
    } else {
        return [
             { label: 'Total Klik Bulan Ini', value: '45.2k', icon: 'bi-cursor-fill', color: 'text-blue-600', bg: 'bg-blue-50' },
            { label: 'Views Bulan Ini', value: '120.5k', icon: 'bi-eye-fill', color: 'text-emerald-600', bg: 'bg-emerald-50' },
            { label: 'CTR Rata-rata', value: '37.5%', icon: 'bi-activity', color: 'text-purple-600', bg: 'bg-purple-50' },
        ];
    }
});

// Bar Chart Configuration
const barChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
        display: false
    }
  },
  scales: {
    y: {
        beginAtZero: true,
        grid: {
            color: '#f3f4f6'
        }
    },
    x: {
        grid: {
            display: false
        }
    }
  }
}

const barChartData = computed(() => {
    const isDaily = period.value === 'daily';
    return {
        labels: isDaily 
            ? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] 
            : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Clicks',
                backgroundColor: '#10b981', // emerald-500
                borderRadius: 6,
                data: isDaily 
                    ? [120, 190, 150, 220, 180, 250, 310] 
                    : [3500, 4200, 3800, 5100, 4800, 5900, 6200, 7100, 6800, 7500, 8100, 8500]
            }
        ]
    }
});

// Doughnut Chart Configuration
const doughnutChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    },
    cutout: '70%'
}

const deviceStats = [
    { label: 'Mobile', percentage: 65, color: '#10b981' },
    { label: 'Desktop', percentage: 25, color: '#3b82f6' },
    { label: 'Tablet', percentage: 10, color: '#f59e0b' },
]

const doughnutChartData = {
    labels: ['Mobile', 'Desktop', 'Tablet'],
    datasets: [
        {
            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
            data: [65, 25, 10],
            borderWidth: 0
        }
    ]
}

// Table Data
const topPages = [
    { id: 1, name: '/bio/landing-page', clicks: 1240, views: 3500, ctr: 35.4, trend: 85 },
    { id: 2, name: '/bio/contact', clicks: 850, views: 2100, ctr: 40.2, trend: 70 },
    { id: 3, name: '/bio/portfolio', clicks: 620, views: 1800, ctr: 34.4, trend: 60 },
    { id: 4, name: '/bio/socials', clicks: 410, views: 1200, ctr: 34.1, trend: 45 },
    { id: 5, name: '/bio/about', clicks: 320, views: 950, ctr: 33.6, trend: 40 },
]

</script>