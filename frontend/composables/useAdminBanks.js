import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminBanks() {
    const banks = ref([])
    const isLoading = ref(false)

    const fetchBanks = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/banks')
            banks.value = response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const saveBank = async (data) => {
        if (data.id) {
            await api.put(`/admin/banks/update/${data.id}`, data)
        } else {
            await api.post('/admin/banks/create', data)
        }
        await fetchBanks()
    }

    const deleteBank = async (id) => {
        await api.delete(`/admin/banks/delete/${id}`)
        await fetchBanks()
    }

    return { banks, isLoading, fetchBanks, saveBank, deleteBank }
}
