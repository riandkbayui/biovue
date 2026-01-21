import { ref } from 'vue'
import api from '@/utils/axios'

export function usePages() {
    const pages = ref([])
    const page = ref(null)
    const isLoading = ref(false)
    const error = ref(null)

    // Ambil semua halaman
    const fetchPages = async () => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.get('/member/pages')
            pages.value = response.data.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal mengambil data halaman.'
            console.error(err)
        } finally {
            isLoading.value = false
        }
    }

    // Ambil detail halaman
    const fetchPage = async (id) => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.get(`/member/pages/show/${id}`)
            page.value = response.data.data
            return page.value
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal mengambil detail halaman.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    // Buat halaman baru
    const createPage = async (data) => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.post('/member/pages/create', data)
            // Tambahkan ke list jika berhasil
            pages.value.unshift(response.data.data)
            return response.data
        } catch (err) {
            error.value = err.response?.data?.messages || err.response?.data?.message || 'Gagal membuat halaman.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    // Update halaman
    const updatePage = async (id, data) => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.put(`/member/pages/update/${id}`, data)
            // Update item di list
            const index = pages.value.findIndex(p => p.id === id)
            if (index !== -1) {
                pages.value[index] = response.data.data
            }
            page.value = response.data.data
            return response.data
        } catch (err) {
            error.value = err.response?.data?.messages || err.response?.data?.message || 'Gagal memperbarui halaman.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    // Hapus halaman
    const deletePage = async (id) => {
        isLoading.value = true
        error.value = null
        try {
            await api.delete(`/member/pages/delete/${id}`)
            // Hapus dari list
            pages.value = pages.value.filter(p => p.id !== id)
            return true
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menghapus halaman.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    // Simpan semua (Page + Blocks)
    const saveAll = async (id, data) => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.post(`/member/pages/save-all/${id}`, data)
            return response.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menyimpan perubahan.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    return {
        pages,
        page,
        isLoading,
        error,
        fetchPages,
        fetchPage,
        createPage,
        updatePage,
        deletePage,
        saveAll
    }
}
