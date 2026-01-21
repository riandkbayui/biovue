import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminUsers() {
    const users = ref([])
    const user = ref(null)
    const isLoading = ref(false)
    const error = ref(null)

    const fetchUsers = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/users')
            users.value = response.data.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memuat pengguna.'
        } finally {
            isLoading.value = false
        }
    }

    const fetchUser = async (id) => {
        isLoading.value = true
        try {
            const response = await api.get(`/admin/users/show/${id}`)
            user.value = response.data.data
            return user.value
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memuat detail pengguna.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const createUser = async (data) => {
        isLoading.value = true
        try {
            await api.post('/admin/users/create', data)
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal membuat pengguna.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const updateUser = async (id, data) => {
        isLoading.value = true
        try {
            // Jika data adalah FormData, kita harus menggunakan POST karena CI4 PUT 
            // tidak mendukung multipart secara native tanpa library tambahan/manual parsing.
            if (data instanceof FormData) {
                await api.post(`/admin/users/update/${id}`, data)
            } else {
                await api.put(`/admin/users/update/${id}`, data)
            }
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memperbarui pengguna.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const deleteUser = async (id) => {
        isLoading.value = true
        try {
            await api.delete(`/admin/users/delete/${id}`)
            users.value = users.value.filter(u => u.id !== id)
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menghapus pengguna.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    return {
        users,
        user,
        isLoading,
        error,
        fetchUsers,
        fetchUser,
        createUser,
        updateUser,
        deleteUser
    }
}
