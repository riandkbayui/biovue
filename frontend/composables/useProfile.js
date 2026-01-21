import { ref } from 'vue'
import api from '@/utils/axios'
import { useAuthStore } from '@/stores/auth'

export function useProfile() {
    const isLoading = ref(false)
    const error = ref(null)
    const successMsg = ref(null)
    const authStore = useAuthStore()

    const updateProfile = async (data) => {
        isLoading.value = true
        error.value = null
        successMsg.value = null
        try {
            // Jika data bukan FormData, kita bisa membiarkan axios menanganinya sebagai JSON,
            // tapi jika ada file, komponen harus mengirimkan instance FormData.
            const response = await api.post('/member/profile/update', data)
            // Update data user di store
            authStore.updateUser(response.data.data)
            successMsg.value = response.data.message
            return response.data
        } catch (err) {
            error.value = err.response?.data?.messages || err.response?.data?.message || 'Gagal memperbarui profil.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const changePassword = async (passwords) => {
        isLoading.value = true
        error.value = null
        successMsg.value = null
        try {
            const response = await api.post('/member/profile/change-password', passwords)
            successMsg.value = response.data.message
            return response.data
        } catch (err) {
            error.value = err.response?.data?.messages || err.response?.data?.message || 'Gagal mengubah kata sandi.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    return {
        isLoading,
        error,
        successMsg,
        updateProfile,
        changePassword
    }
}
