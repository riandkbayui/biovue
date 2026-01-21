import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminDashboard() {
    const stats = ref({
        total_users: 0,
        total_pages: 0,
        total_transactions: 0,
        total_revenue: 0,
        recent_users: [],
        recent_transactions: []
    })
    const isLoading = ref(false)
    const error = ref(null)

    const fetchStats = async () => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.get('/admin/dashboard')
            stats.value = response.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal mengambil data dashboard admin.'
            console.error(err)
        } finally {
            isLoading.value = false
        }
    }

    return {
        stats,
        isLoading,
        error,
        fetchStats
    }
}
