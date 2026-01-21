import { ref } from 'vue'
import api from '@/utils/axios'

export function useAdminPlans() {
    const plans = ref([])
    const plan = ref(null)
    const isLoading = ref(false)
    const error = ref(null)

    const fetchPlans = async () => {
        isLoading.value = true
        try {
            const response = await api.get('/admin/plans')
            plans.value = response.data.data.map(p => {
                try {
                    p.features_list = typeof p.features === 'string' ? JSON.parse(p.features) : (p.features || [])
                } catch(e) {
                    p.features_list = []
                }
                return p
            })
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memuat paket.'
        } finally {
            isLoading.value = false
        }
    }

    const fetchPlan = async (id) => {
        isLoading.value = true
        try {
            const response = await api.get(`/admin/plans/show/${id}`)
            plan.value = response.data.data
            try {
                plan.value.features_list = typeof plan.value.features === 'string' ? JSON.parse(plan.value.features) : (plan.value.features || [])
            } catch(e) {
                plan.value.features_list = []
            }
            return plan.value
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memuat detail paket.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const savePlan = async (id, data) => {
        isLoading.value = true
        try {
            if (id) {
                await api.put(`/admin/plans/update/${id}`, data)
            } else {
                await api.post('/admin/plans/create', data)
            }
            await fetchPlans()
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menyimpan paket.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const deletePlan = async (id) => {
        isLoading.value = true
        try {
            await api.delete(`/admin/plans/delete/${id}`)
            await fetchPlans()
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menghapus paket.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    return { 
        plans, 
        plan, 
        isLoading, 
        error, 
        fetchPlans, 
        fetchPlan, 
        savePlan, 
        deletePlan 
    }
}