<template>
  <div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
        <p class="text-gray-500 mt-1">Pantau semua aktivitas dan pembaruan akun Anda</p>
      </div>
      <button class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Tandai Semua Dibaca</button>
    </div>

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
      <div class="divide-y divide-gray-50">
        <div v-for="notif in allNotifications" :key="notif.id" :class="['p-6 flex gap-4 hover:bg-gray-50 transition-colors cursor-pointer', !notif.read ? 'bg-emerald-50/20' : '']">
          <div :class="['w-12 h-12 rounded-2xl flex-shrink-0 flex items-center justify-center text-xl', notif.iconBg, notif.iconColor]">
            <i :class="['bi', notif.icon]"></i>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2 mb-1">
              <h3 class="font-bold text-gray-900 truncate">{{ notif.title }}</h3>
              <span class="text-xs text-gray-400 whitespace-nowrap">{{ notif.time }}</span>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">{{ notif.message }}</p>
          </div>
          <div v-if="!notif.read" class="w-2 h-2 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></div>
        </div>
      </div>
      
      <div v-if="allNotifications.length === 0" class="py-20 text-center">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
          <i class="bi bi-bell-slash text-3xl"></i>
        </div>
        <p class="text-gray-500 font-medium">Belum ada notifikasi</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const allNotifications = ref([
  { id: 1, title: 'Selamat Datang!', message: 'Mulai buat halaman bio link pertamamu dengan klik tombol "Buat Halaman" di dashboard.', time: 'Baru saja', read: false, icon: 'bi-stars', iconBg: 'bg-emerald-100', iconColor: 'text-emerald-600' },
  { id: 2, title: 'Tips Optimasi', message: 'Gunakan fitur Pro Blocks untuk meningkatkan interaksi pengunjung halaman Anda.', time: '2 jam lalu', read: false, icon: 'bi-lightning-fill', iconBg: 'bg-amber-100', iconColor: 'text-amber-600' },
  { id: 3, title: 'Update Keamanan', message: 'Kami telah memperbarui sistem keamanan untuk melindungi data Anda lebih baik.', time: '1 hari lalu', read: true, icon: 'bi-shield-check', iconBg: 'bg-blue-100', iconColor: 'text-blue-600' },
  { id: 4, title: 'Tagihan Berhasil', message: 'Pembayaran langganan paket Pro Anda telah diverifikasi.', time: '3 hari lalu', read: true, icon: 'bi-check-circle-fill', iconBg: 'bg-emerald-100', iconColor: 'text-emerald-600' },
])
</script>
