<template>
  <div class="space-y-6 animate-fade-in max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Semua Notifikasi</h1>
        <p class="text-gray-500 mt-1">Pantau aktivitas terbaru dalam sistem</p>
      </div>
      <div class="flex gap-2">
         <button 
            v-for="filter in filters" 
            :key="filter.value"
            @click="activeFilter = filter.value"
            :class="['px-4 py-2 rounded-xl text-sm font-medium transition-all', activeFilter === filter.value ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200']"
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
                :class="['p-6 flex gap-4 transition-colors hover:bg-gray-50 group', !notif.read ? 'bg-indigo-50/40' : '']"
            >
                <!-- Icon based on type -->
                <div :class="['w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0', getIconStyle(notif.type)]">
                    <i :class="['bi', getIcon(notif.type)]"></i>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                             <h3 :class="['font-semibold text-gray-900', !notif.read ? 'text-indigo-900' : '']">{{ notif.title }}</h3>
                             <p class="text-gray-600 mt-1 text-sm">{{ notif.message }}</p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ notif.time }}</span>
                    </div>
                    <div class="mt-3 flex gap-4 text-xs text-gray-500 items-center">
                        <span>{{ notif.date }}</span>
                        <span v-if="!notif.read" class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        
                        <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                             <button @click="markAsRead(notif.id)" v-if="!notif.read" class="text-indigo-600 hover:text-indigo-800 font-medium">Tandai dibaca</button>
                             <button @click="deleteNotif(notif.id)" class="text-red-500 hover:text-red-700"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-center pt-4">
        <button class="text-sm text-gray-500 hover:text-indigo-600 font-medium transition-colors">Muat Lebih Banyak</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const activeFilter = ref('all');

const filters = [
    { label: 'Semua', value: 'all' },
    { label: 'Belum Dibaca', value: 'unread' },
    { label: 'Sistem', value: 'system' },
];

// Mock Data
const notifications = ref([
  { id: 1, type: 'transaction', title: 'Transaksi Baru #TXN-882194', message: 'Pembayaran sukses dari Alex Johnson untuk paket Pro Bulanan sebesar Rp 49.000.', time: '5 menit yang lalu', date: '16 Jan 2026', read: false },
  { id: 2, type: 'user', title: 'Pendaftaran Pengguna Baru', message: 'Sarah Miller baru saja mendaftar dan memverifikasi emailnya.', time: '1 jam yang lalu', date: '16 Jan 2026', read: false },
  { id: 3, type: 'system', title: 'Pemberitahuan Sistem', message: 'Backup database otomatis berhasil dijalankan.', time: '3 jam yang lalu', date: '16 Jan 2026', read: true },
  { id: 4, type: 'transaction', title: 'Pembayaran Gagal', message: 'Transaksi #TXN-882162 gagal diproses. Metode pembayaran ditolak.', time: 'Kemarin', date: '15 Jan 2026', read: true },
  { id: 5, type: 'alert', title: 'Peringatan Keamanan', message: 'Terdeteksi percobaan login mencurigakan dari IP 192.168.1.55', time: '2 hari lalu', date: '14 Jan 2026', read: true },
]);

const filteredNotifications = computed(() => {
    if (activeFilter.value === 'all') return notifications.value;
    if (activeFilter.value === 'unread') return notifications.value.filter(n => !n.read);
    if (activeFilter.value === 'system') return notifications.value.filter(n => n.type === 'system' || n.type === 'alert');
    return notifications.value;
});

const getIcon = (type) => {
    switch (type) {
        case 'transaction': return 'bi-cash-coin';
        case 'user': return 'bi-person-plus';
        case 'system': return 'bi-hdd-rack';
        case 'alert': return 'bi-shield-exclamation';
        default: return 'bi-bell';
    }
};

const getIconStyle = (type) => {
    switch (type) {
        case 'transaction': return 'bg-green-100 text-green-600';
        case 'user': return 'bg-blue-100 text-blue-600';
        case 'system': return 'bg-gray-100 text-gray-600';
        case 'alert': return 'bg-red-100 text-red-600';
        default: return 'bg-indigo-100 text-indigo-600';
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