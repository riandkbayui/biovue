import { ref } from 'vue'
import api from '@/utils/axios'

export function useUpload() {
    const isUploading = ref(false)
    const error = ref(null)

    const uploadImage = async (file, folder = 'others') => {
        isUploading.value = true
        error.value = null

        const formData = new FormData()
        formData.append('file', file)
        formData.append('folder', folder)

        try {
            const response = await api.post('/upload/create', formData)
            return response.data.data // { file_name: '...', url: '...' }
        } catch (err) {
            error.value = err.response?.data?.message || 'Gagal mengupload gambar.'
            throw err
        } finally {
            isUploading.value = false
        }
    }

    return {
        isUploading,
        error,
        uploadImage
    }
}
