<template>
  <div class="space-y-6 animate-fade-in max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
        <p class="text-gray-500 mt-1">Pantau semua aktivitas dan pemberitahuan akun Anda</p>
      </div>
      <div class="flex gap-2">
         <button 
            v-for="filter in filters" 
            :key="filter.value"
            @click="activeFilter = filter.value"
            :class="['px-4 py-2 rounded-xl text-sm font-medium transition-all', activeFilter === filter.value ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200']"
         >
            {{ filter.label }}
         </button>
      </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div v-if="filteredNotifications.length === 0" class="p-12 text-center text-gray-500">
            <i class="bi bi-bell-slash text-4xl mb-3 block opacity-20"></i>
            <p>Tidak ada notifikasi untuk ditampilkan.</p>
        </div>
        <div v-else class="divide-y divide-gray-50">
            <div 
                v-for="notif in filteredNotifications" 
                :key="notif.id" 
                :class="['p-6 flex gap-4 transition-colors hover:bg-gray-50 group', !notif.read ? 'bg-emerald-50/40' : '']"
            >
                <!-- Icon based on type -->
                <div :class="['w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0', getIconStyle(notif.type)]">
                    <i :class="['bi', getIcon(notif.type)]"></i>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                             <h3 :class="['font-semibold text-gray-900', !notif.read ? 'text-emerald-900' : '']">{{ notif.title }}</h3>
                             <p class="text-gray-600 mt-1 text-sm">{{ notif.message }}</p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ notif.time }}</span>
                    </div>
                    <div class="mt-3 flex gap-4 text-xs text-gray-500 items-center">
                        <span>{{ notif.date }}</span>
                        <span v-if="!notif.read" class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        
                        <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                             <button @click="markAsRead(notif.id)" v-if="!notif.read" class="text-emerald-600 hover:text-emerald-800 font-medium">Tandai dibaca</button>
                             <button @click="deleteNotif(notif.id)" class="text-red-500 hover:text-red-700"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-center pt-4">
        <button class="text-sm text-gray-500 hover:text-emerald-600 font-medium transition-colors">Muat Lebih Banyak</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const activeFilter = ref('all');

const filters = [
    { label: 'Semua', value: 'all' },
    { label: 'Belum Dibaca', value: 'unread' },
    { label: 'Info', value: 'info' },
];

// Mock Data
const notifications = ref([
  { id: 1, type: 'welcome', title: 'Selamat Datang!', message: 'Mulai buat halaman bio link pertamamu sekarang.', time: 'Baru saja', date: '16 Jan 2026', read: false },
  { id: 2, type: 'promo', title: 'Upgrade ke Pro', message: 'Dapatkan diskon 20% untuk paket Pro tahunan. Promo berakhir besok!', time: '1 hari lalu', date: '15 Jan 2026', read: false },
  { id: 3, type: 'system', title: 'Pembaruan Sistem', message: 'Kami telah memperbarui fitur analitik dengan data yang lebih lengkap.', time: '2 hari lalu', date: '14 Jan 2026', read: true },
  { id: 4, type: 'billing', title: 'Tagihan Lunas', message: 'Pembayaran tagihan bulan Januari berhasil diterima.', time: '1 minggu lalu', date: '10 Jan 2026', read: true },
]);

const filteredNotifications = computed(() => {
    if (activeFilter.value === 'all') return notifications.value;
    if (activeFilter.value === 'unread') return notifications.value.filter(n => !n.read);
    if (activeFilter.value === 'info') return notifications.value.filter(n => n.type === 'system' || n.type === 'welcome');
    return notifications.value;
});

const getIcon = (type) => {
    switch (type) {
        case 'welcome': return 'bi-emoji-smile';
        case 'promo': return 'bi-stars';
        case 'system': return 'bi-info-circle';
        case 'billing': return 'bi-receipt';
        default: return 'bi-bell';
    }
};

const getIconStyle = (type) => {
    switch (type) {
        case 'welcome': return 'bg-emerald-100 text-emerald-600';
        case 'promo': return 'bg-purple-100 text-purple-600';
        case 'system': return 'bg-blue-100 text-blue-600';
        case 'billing': return 'bg-gray-100 text-gray-600';
        default: return 'bg-gray-100 text-gray-600';
    }
};

const markAsRead = (id) => {
    const notif = notifications.value.find(n => n.id === id);
    if (notif) notif.read = true;
};

const deleteNotif = (id) => {
    if(confirm('Hapus notifikasi ini?')) {
        notifications.value = notifications.value.filter(n => n.id !== id);
    }
};
</script>