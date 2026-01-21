import { ref } from 'vue'
import api from '@/utils/axios'

export function usePayments() {
    const plans = ref([])
    const channels = ref([])
    const transactions = ref([])
    const transaction = ref(null)
    const isLoading = ref(false)

    const fetchPlans = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/member/payments/plans')
            plans.value = response.data.data.map(p => {
                try {
                    p.features_list = typeof p.features === 'string' ? JSON.parse(p.features) : p.features
                } catch(e) { p.features_list = [] }
                return p
            })
        } finally {
            isLoading.value = false
        }
    }

    const fetchChannels = async () => {
        const response = await api.get('/member/payments/channels')
        channels.value = response.data.data
    }

    const createCheckout = async (planId) => {
        isLoading.value = true
        try {
            const response = await api.post('/member/payments/checkout', { plan_id: planId })
            return response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const fetchTransaction = async (id) => {
        isLoading.value = true
        try {
            const response = await api.get(`/member/payments/show/${id}`)
            transaction.value = response.data.data
            return response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const fetchHistory = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/member/payments/history')
            transactions.value = response.data.data
        } finally {
            isLoading.value = false
        }
    }

    const uploadPaymentProof = async (id, imageUrl) => {
        const response = await api.post(`/member/payments/upload-proof/${id}`, { image_url: imageUrl })
        return response.data
    }

    return {
        plans, channels, transactions, transaction, isLoading,
        fetchPlans, fetchChannels, createCheckout, fetchTransaction, fetchHistory, uploadPaymentProof
    }
}
