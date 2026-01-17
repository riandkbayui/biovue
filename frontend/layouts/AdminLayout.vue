<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const isSidebarOpen = ref(true)
const showNotifications = ref(false)

const notifications = ref([
  { id: 1, title: 'Transaksi Baru', message: 'User A membeli paket Pro', time: '5m lalu', read: false },
  { id: 2, title: 'Pendaftaran User', message: 'User B baru saja mendaftar', time: '1j lalu', read: false },
  { id: 3, title: 'Server Status', message: 'Maintenance dijadwalkan nanti malam', time: '2j lalu', read: true },
])

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value
}

const viewAllNotifications = () => {
    showNotifications.value = false
    router.push('/admin/notifications')
}

const menuItems = [
  { name: 'Dashboard Admin', icon: 'bi-speedometer2', path: '/admin/dashboard' },
  { name: 'Transaksi', icon: 'bi-cash-stack', path: '/admin/transactions' },
  { name: 'Manajemen Halaman', icon: 'bi-files', path: '/admin/pages' },
  { name: 'Manajemen Pengguna', icon: 'bi-people-fill', path: '/admin/users' },
  { name: 'Paket Langganan', icon: 'bi-card-checklist', path: '/admin/plans' },
  { name: 'Manajemen FAQ', icon: 'bi-question-circle', path: '/admin/faq' },
  { name: 'Pengaturan Sistem', icon: 'bi-gear-fill', path: '/admin/settings' },
]

const handleLogout = () => {
    router.push('/login')
}

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value
}

const handleNavItemClick = () => {
  if (window.innerWidth < 1024) {
    isSidebarOpen.value = false
  }
}
</script>

<template>
  <div class="h-screen bg-slate-50 flex overflow-hidden">
    <!-- Backdrop for mobile -->
    <div
      v-if="isSidebarOpen"
      @click="toggleSidebar"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm z-45 lg:hidden transition-opacity border-none"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed inset-y-0 left-0 bg-gradient-to-b from-indigo-700 to-indigo-900 text-white transition-all duration-300 z-50 overflow-hidden shadow-2xl w-64',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'
      ]"
    >
      <!-- Background Ornaments -->
      <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-10">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-20 w-60 h-60 bg-white rounded-full blur-3xl"></div>
      </div>

      <!-- Sidebar Content -->
      <div class="relative z-10 h-full flex flex-col">
        <!-- Logo -->
        <div class="p-6 flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center font-bold text-indigo-700 flex-shrink-0 shadow-lg">
            A
          </div>
          <span v-if="isSidebarOpen" class="text-xl font-bold tracking-tight whitespace-nowrap">Admin Aksibio</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 mt-4 space-y-1">
          <router-link
            v-for="item in menuItems"
            :key="item.name"
            :to="item.path"
            @click="handleNavItemClick"
            :class="[
              'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group',
              route.path === item.path
                ? 'bg-white/10 text-white border border-white/20 shadow-inner'
                : 'text-indigo-50 hover:bg-white/5 hover:text-white'
            ]"
          >
            <i :class="['bi text-lg', item.icon, route.path === item.path ? 'opacity-100' : 'opacity-70 group-hover:opacity-100']"></i>
            <span :class="['font-medium whitespace-nowrap transition-opacity duration-300', !isSidebarOpen ? 'lg:opacity-0' : 'opacity-100']">{{ item.name }}</span>

            <div v-if="!isSidebarOpen" class="hidden lg:block fixed left-24 bg-gray-900 text-white px-2 py-1 rounded text-xs invisible group-hover:visible shadow-xl border border-white/10 z-[60]">
               {{ item.name }}
            </div>
          </router-link>
        </nav>

        <!-- Logout Section -->
        <div class="p-4 mt-auto">
          <button
            @click="handleLogout"
            class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-indigo-700 hover:bg-indigo-600 hover:text-white transition-all group"
          >
            <i class="bi bi-box-arrow-left text-lg opacity-70 group-hover:opacity-100"></i>
            <span :class="['font-medium transition-opacity duration-300', !isSidebarOpen ? 'lg:opacity-0' : 'opacity-100']">Keluar</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div
        :class="[
            'flex-1 flex flex-col min-w-0 transition-all duration-300 h-full overflow-y-auto',
            isSidebarOpen ? 'lg:pl-64' : 'lg:pl-20'
        ]"
    >
      <!-- Header -->
      <header class="py-4 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40">
        <div class="flex items-center gap-4">
          <button
            @click="toggleSidebar"
            class="p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors"
          >
            <i :class="['bi text-xl', isSidebarOpen ? 'bi-text-indent-left' : 'bi-text-indent-right']"></i>
          </button>
          <h2 class="text-lg sm:text-xl font-bold text-gray-800 truncate">
            {{ menuItems.find(item => item.path === route.path)?.name || 'Admin' }}
          </h2>
        </div>

        <div class="flex items-center gap-3 sm:gap-6">
          <div class="hidden lg:flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-[10px] font-medium uppercase tracking-wider">
             <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
             Super Admin
          </div>

          <div class="relative">
            <button 
              @click="toggleNotifications" 
              class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-indigo-600 transition-all relative border border-gray-100 z-[70]"
            >
              <i class="bi bi-bell text-lg"></i>
              <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <!-- Backdrop -->
            <div v-if="showNotifications" @click="showNotifications = false" class="fixed inset-0 z-[60] bg-transparent cursor-default"></div>

            <!-- Dropdown -->
            <div v-if="showNotifications" class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-[70] animate-fade-in origin-top-right">
                <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 text-sm">Notifikasi</h3>
                    <button class="text-[10px] font-medium text-indigo-600 hover:text-indigo-700">Tandai dibaca</button>
                </div>
                <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
                    <div v-for="notif in notifications" :key="notif.id" :class="['px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 cursor-pointer', !notif.read ? 'bg-indigo-50/30' : '']">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-xs text-gray-800">{{ notif.title }}</span>
                            <span class="text-[10px] text-gray-400">{{ notif.time }}</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ notif.message }}</p>
                    </div>
                </div>
                <div class="px-4 py-2 border-t border-gray-50 text-center">
                    <button @click="viewAllNotifications" class="text-xs font-medium text-gray-500 hover:text-indigo-600 transition-colors py-1">Lihat Semua Aktivitas</button>
                </div>
            </div>
          </div>

          <div class="flex items-center gap-2 sm:gap-3 cursor-pointer hover:opacity-80 transition-opacity" @click="$router.push('/admin/profile')">
             <div class="text-right hidden md:block">
                <p class="text-sm font-bold text-gray-900 leading-none">Bio Admin</p>
                <p class="text-[10px] text-gray-500 mt-1">Akses Master</p>
             </div>
             <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold overflow-hidden shadow-sm">
                <i class="bi bi-person-badge-fill text-xl"></i>
             </div>
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <main class="flex-1 p-4 sm:p-8">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
