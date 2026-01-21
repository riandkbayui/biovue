<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengguna</h1>
      <router-link to="/admin/users/create" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Tambah Pengguna
      </router-link>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-4">
      <div class="flex-1 relative">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input v-model="searchQuery" type="text" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
      </div>
      <select v-model="filterRole" class="px-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
        <option value="">Semua Role</option>
        <option value="admin">Admin</option>
        <option value="member">Member</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
      <div v-if="isLoading" class="p-8 text-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto"></div>
      </div>
      
      <table v-else class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider">
            <th class="py-4 px-6">User</th>
            <th class="py-4 px-6">Role</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6">Bergabung</th>
            <th class="py-4 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-for="user in filteredUsers" :key="user.id" class="group hover:bg-gray-50 transition-colors">
            <td class="py-4 px-6">
              <div class="flex items-center gap-3">
                <img :src="user.photo || `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.username}`" class="w-10 h-10 rounded-full bg-gray-100 object-cover">
                <div>
                  <p class="font-bold text-gray-900">{{ user.name }}</p>
                  <p class="text-xs text-gray-500">{{ user.email }}</p>
                </div>
              </div>
            </td>
            <td class="py-4 px-6">
              <span :class="['px-2 py-1 rounded-lg text-xs font-bold uppercase', user.role === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600']">
                {{ user.role }}
              </span>
            </td>
            <td class="py-4 px-6">
              <span :class="['px-2 py-1 rounded-lg text-xs font-bold uppercase', user.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600']">
                {{ user.status }}
              </span>
            </td>
            <td class="py-4 px-6 text-sm text-gray-500">
              {{ formatDate(user.created_at.date || user.created_at) }}
            </td>
            <td class="py-4 px-6 text-right">
              <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <router-link :to="`/admin/users/${user.id}/edit`" class="p-2 rounded-lg bg-white border border-gray-200 text-gray-600 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm">
                  <i class="bi bi-pencil-fill"></i>
                </router-link>
                <button @click="handleDelete(user.id)" class="p-2 rounded-lg bg-white border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="filteredUsers.length === 0">
            <td colspan="5" class="py-8 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAdminUsers } from '@/composables/useAdminUsers'

const { users, fetchUsers, deleteUser, isLoading } = useAdminUsers()
const searchQuery = ref('')
const filterRole = ref('')

onMounted(() => {
    fetchUsers()
})

const filteredUsers = computed(() => {
    return users.value.filter(user => {
        const matchesSearch = user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                              user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
        const matchesRole = filterRole.value ? user.role === filterRole.value : true
        return matchesSearch && matchesRole
    })
})

const formatDate = (dateString) => {
    if (!dateString) return '-'
    return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
}

const handleDelete = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')) {
        await deleteUser(id)
    }
}
</script>
