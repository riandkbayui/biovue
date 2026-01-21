import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminTransactions() {
    const transactions = ref([])
    const transaction = ref(null)
    const isLoading = ref(false)

    const fetchTransactions = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/transactions')
            transactions.value = response.data.data
        } catch (error) {
            console.error('Error fetching transactions:', error)
        } finally {
            isLoading.value = false
        }
    }

    const fetchTransaction = async (id) => {
        isLoading.value = true
        try {
            const response = await api.get(`/admin/transactions/show/${id}`)
            transaction.value = response.data.data
        } catch (error) {
            console.error('Error fetching transaction:', error)
        } finally {
            isLoading.value = false
        }
    }

    const confirmPayment = async (id) => {
        isLoading.value = true
        try {
            const response = await api.post(`/admin/transactions/confirm/${id}`)
            return response.data
        } catch (error) {
            console.error('Error confirming payment:', error)
            throw error
        } finally {
            isLoading.value = false
        }
    }

    const rejectPayment = async (id) => {
        isLoading.value = true
        try {
            const response = await api.post(`/admin/transactions/reject/${id}`)
            return response.data
        } catch (error) {
            console.error('Error rejecting payment:', error)
            throw error
        } finally {
            isLoading.value = false
        }
    }

    return { 
        transactions, 
        transaction, 
        isLoading, 
        fetchTransactions, 
        fetchTransaction, 
        confirmPayment, 
        rejectPayment 
    }
}