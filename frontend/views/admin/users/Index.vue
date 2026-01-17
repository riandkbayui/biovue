<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengguna</h1>
        <p class="text-gray-500 mt-1">Kelola dan pantau pengguna aplikasi Anda</p>
      </div>
      <div class="flex gap-3">
        <div class="relative">
          <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input type="text" placeholder="Cari pengguna..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none w-64">
        </div>
        <Button variant="primary" @click="$router.push({ name: 'admin-users-create' })">
          <i class="bi bi-person-plus mr-2"></i> Tambah Pengguna
        </Button>
      </div>
    </div>

    <Card>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="px-6 py-4">Pengguna</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4">Paket</th>
              <th class="px-6 py-4">Halaman</th>
              <th class="px-6 py-4">Tanggal Bergabung</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                    {{ user.name[0] }}
                  </div>
                  <div>
                    <div class="font-bold text-gray-900">{{ user.name }}</div>
                    <div class="text-xs text-gray-500">{{ user.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <Badge :variant="user.status === 'Aktif' ? 'success' : 'secondary'">{{ user.status }}</Badge>
              </td>
              <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ user.plan }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ user.pages }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.date }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3" @click="$router.push({ name: 'admin-users-edit', params: { id: user.id } })">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="text-red-600 hover:text-red-900" @click="deleteUser(user.id)">
                  <i class="bi bi-slash-circle"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <template #footer>
        <div class="flex items-center justify-between">
          <p class="text-sm text-gray-500">Menampilkan {{ users.length }} pengguna</p>
          <div class="flex gap-2">
            <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50" disabled>Sebelumnya</button>
            <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Berikutnya</button>
          </div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Card from '../../../components/Card.vue';
import Button from '../../../components/Button.vue';
import Badge from '../../../components/Badge.vue';

const router = useRouter();

const users = ref([
  { id: 1, name: 'Alex Johnson', email: 'alex@example.com', status: 'Aktif', plan: 'Pro', pages: 5, date: '12 Jan 2026' },
  { id: 2, name: 'Sarah Miller', email: 'sarah@example.com', status: 'Aktif', plan: 'Gratis', pages: 1, date: '10 Jan 2026' },
  { id: 3, name: 'Mike Brown', email: 'mike@example.com', status: 'Tidak Aktif', plan: 'Pro', pages: 12, date: '05 Jan 2026' },
  { id: 4, name: 'Emma Wilson', email: 'emma@example.com', status: 'Aktif', plan: 'Enterprise', pages: 45, date: '01 Jan 2026' },
  { id: 5, name: 'Rian DK', email: 'rian@example.com', status: 'Aktif', plan: 'Gratis', pages: 2, date: '15 Des 2025' },
]);

const deleteUser = (id) => {
    if(confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        users.value = users.value.filter(u => u.id !== id);
    }
}
</script>