import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminFaqs() {
    const faqs = ref([])
    const isLoading = ref(false)

    const fetchFaqs = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/faqs')
            faqs.value = response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const saveFaq = async (data) => {
        if (data.id) {
            await api.put(`/admin/faqs/update/${data.id}`, data)
        } else {
            await api.post('/admin/faqs/create', data)
        }
        await fetchFaqs()
    }

    const deleteFaq = async (id) => {
        await api.delete(`/admin/faqs/delete/${id}`)
        await fetchFaqs()
    }

    return { faqs, isLoading, fetchFaqs, saveFaq, deleteFaq }
}
