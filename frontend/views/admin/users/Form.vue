<template>
  <div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
      <router-link to="/admin/users" class="text-gray-500 hover:text-emerald-600 flex items-center gap-2 mb-4 transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pengguna
      </router-link>
      <h2 class="text-2xl font-bold text-gray-900">{{ isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        
        <div v-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            {{ formatError(error) }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input v-model="form.name" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input v-model="form.username" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input v-model="form.email" type="email" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select v-model="form.role" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all bg-white">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all bg-white">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ isEditMode ? 'Password Baru (Kosongkan jika tidak diubah)' : 'Password' }}
            </label>
            <input v-model="form.password" type="password" :required="!isEditMode" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" @click="router.back()" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                Batal
            </button>
            <button type="submit" :disabled="isLoading" class="px-8 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2">
                <span v-if="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                {{ isEditMode ? 'Simpan Perubahan' : 'Buat Pengguna' }}
            </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAdminUsers } from '@/composables/useAdminUsers'

const router = useRouter()
const route = useRoute()
const { fetchUser, createUser, updateUser, isLoading, error } = useAdminUsers()

const isEditMode = computed(() => !!route.params.id)

const form = reactive({
    name: '',
    username: '',
    email: '',
    role: 'member',
    status: 'active',
    password: ''
})

onMounted(async () => {
    if (isEditMode.value) {
        try {
            const user = await fetchUser(route.params.id)
            form.name = user.name
            form.username = user.username
            form.email = user.email
            form.role = user.role
            form.status = user.status
        } catch (err) {
            router.push('/admin/users')
        }
    }
})

const handleSubmit = async () => {
    try {
        if (isEditMode.value) {
            await updateUser(route.params.id, form)
        } else {
            await createUser(form)
        }
        router.push('/admin/users')
    } catch (err) {}
}

const formatError = (err) => {
    if (typeof err === 'object') return Object.values(err).join(', ')
    return err
}
</script>
