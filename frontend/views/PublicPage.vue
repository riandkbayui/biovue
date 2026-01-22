<template>
  <div v-if="isLoading" class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
  </div>
  
  <div v-else-if="error" class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 text-center">
    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center text-red-600 mb-4">
        <i class="bi bi-exclamation-triangle text-4xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Halaman Tidak Ditemukan</h1>
    <p class="text-gray-500 mb-6 max-w-sm">{{ error }}</p>
    <router-link to="/" class="px-6 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors">
        Kembali ke Beranda
    </router-link>
  </div>

  <div v-else-if="pageData" class="min-h-screen flex justify-center bg-gray-100/50">
     <div class="w-full max-w-md bg-white min-h-screen shadow-[0_0_50px_rgba(0,0,0,0.1)] relative overflow-x-hidden">
        <!-- Kita gunakan PagePreview untuk merender konten publik -->
        <PagePreview :pageData="pageData" :blocks="blocks" />
        
        <!-- Footer "Made with Aksibio" -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-50 w-full flex justify-center pointer-events-none">
            <a href="/" target="_blank" class="px-4 py-2 bg-white/90 backdrop-blur-md border border-gray-100 rounded-full shadow-lg flex items-center gap-2 hover:bg-white transition-all group pointer-events-auto">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Made with</span>
                <span class="text-sm font-black bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">Aksibio</span>
            </a>
        </div>
     </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/utils/axios'
import PagePreview from '@/components/PagePreview.vue'

const route = useRoute()
const isLoading = ref(true)
const error = ref(null)
const pageData = ref(null)
const blocks = ref([])

const fetchPublicPage = async () => {
    isLoading.value = true
    error.value = null
    try {
        const response = await api.get(`/public-page/show/${route.params.slug}`)
        const { page, blocks: rawBlocks } = response.data
        
        // Page Info
        pageData.value = {
            ...page,
            theme: typeof page.theme === 'string' ? JSON.parse(page.theme) : page.theme
        }

        // Standardize Blocks (Flat data, no double nesting)
        blocks.value = rawBlocks.map(block => {
            let content = {}
            if (typeof block.data === 'string') {
                try {
                    const parsed = JSON.parse(block.data)
                    content = (parsed && typeof parsed === 'object' && parsed.data) ? parsed.data : parsed
                } catch (e) {
                    content = {}
                }
            } else {
                content = (block.data && typeof block.data === 'object' && block.data.data) ? block.data.data : block.data
            }
            return { ...block, content }
        })

        // Update Document Title for SEO
        if (page.title) {
            document.title = `${page.title} | Aksibio`
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat memuat halaman.'
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchPublicPage()
})
</script>
