import { ref } from 'vue'
import api from '@/utils/axios'

export function useBlocks() {
    const blocks = ref([])
    const isLoading = ref(false)
    const error = ref(null)

    const fetchBlocks = async (pageId) => {
        isLoading.value = true
        error.value = null
        try {
            const response = await api.get(`/member/blocks/show/${pageId}`)
            blocks.value = response.data.data.map(block => {
                // Parse JSON data if string
                if (typeof block.data === 'string') {
                    try {
                        block.content = JSON.parse(block.data)
                    } catch (e) {
                        block.content = block.data
                    }
                } else {
                    block.content = block.data
                }
                return block
            })
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal mengambil data blok.'
        } finally {
            isLoading.value = false
        }
    }

    const addBlock = async (pageId, type, content) => {
        isLoading.value = true
        try {
            const response = await api.post('/member/blocks/create', { page_id: pageId, type, content })
            const newBlock = response.data.data
            // Parse data for frontend
            newBlock.content = typeof newBlock.data === 'string' ? JSON.parse(newBlock.data) : newBlock.data
            blocks.value.push(newBlock)
            return response.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menambah blok.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const updateBlock = async (id, data) => {
        isLoading.value = true
        try {
            const response = await api.put(`/member/blocks/update/${id}`, data)
            
            // Cari index block yang diupdate
            const index = blocks.value.findIndex(b => b.id === id)
            if (index !== -1) {
                // Jika server mengembalikan data terbaru, gunakan itu
                if (response.data && response.data.data) {
                    const updated = response.data.data
                    updated.content = typeof updated.data === 'string' ? JSON.parse(updated.data) : updated.data
                    blocks.value[index] = { ...blocks.value[index], ...updated }
                } else {
                    // Jika tidak, biarkan data lokal yang sudah diupdate oleh v-model tetap ada
                    // Kita hanya memastikan ID tetap terjaga
                    blocks.value[index].id = id 
                }
            }
            
            return response.data
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal memperbarui blok.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const deleteBlock = async (id) => {
        isLoading.value = true
        try {
            await api.delete(`/member/blocks/delete/${id}`)
            blocks.value = blocks.value.filter(b => b.id !== id)
            return true
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal menghapus blok.'
            throw err
        } finally {
            isLoading.value = false
        }
    }

    const reorderBlocks = async (pageId, ids) => {
        try {
            await api.post('/member/blocks/reorder', { page_id: pageId, ids })
            return true
        } catch (err) {
            console.error('Gagal mengurutkan blok', err)
            return false
        }
    }

    return {
        blocks,
        isLoading,
        error,
        fetchBlocks,
        addBlock,
        updateBlock,
        deleteBlock,
        reorderBlocks
    }
}
