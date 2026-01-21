import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminPaymentChannels() {
    const channels = ref([])
    const isLoading = ref(false)

    const fetchChannels = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/payment-channels')
            channels.value = response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const saveChannel = async (data) => {
        if (data.id) {
            await api.put(`/admin/payment-channels/update/${data.id}`, data)
        } else {
            await api.post('/admin/payment-channels/create', data)
        }
        await fetchChannels()
    }

    const deleteChannel = async (id) => {
        await api.delete(`/admin/payment-channels/delete/${id}`)
        await fetchChannels()
    }

    return { channels, isLoading, fetchChannels, saveChannel, deleteChannel }
}
