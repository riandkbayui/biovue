<template>
  <div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <router-link to="/member/pages" class="text-gray-500 hover:text-emerald-600 flex items-center gap-2 mb-4 transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Saya
        </router-link>
        <h2 class="text-2xl font-bold text-gray-900">Edit Halaman</h2>
        <p class="text-gray-500 mt-1">Perbarui informasi halaman Anda.</p>
    </div>

    <div v-if="isLoadingFetch" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
    </div>

    <div v-else class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
            
            <div v-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                {{ formatError(error) }}
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                <input type="text" id="title" v-model="form.title" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                    placeholder="Contoh: Portofolio Saya" />
            </div>

             <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                <div class="flex items-center">
                    <span class="px-4 py-3 bg-gray-50 border border-r-0 border-gray-200 rounded-l-xl text-gray-500 text-sm">aksibio.com/</span>
                    <input type="text" id="slug" :value="currentSlug" disabled 
                        class="w-full px-4 py-3 border border-gray-200 bg-gray-50 text-gray-500 rounded-r-xl outline-none cursor-not-allowed" />
                </div>
                <p class="text-xs text-gray-400 mt-1">Slug saat ini tidak dapat diubah secara langsung.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea id="description" v-model="form.description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                    placeholder="Ceritakan sedikit tentang halaman ini..."></textarea>
            </div>

            <div class="pt-4 border-t border-gray-50 flex justify-end gap-3">
                 <button type="button" @click="router.back()" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-all">
                    Batal
                </button>
                <button type="submit" :disabled="isLoading" 
                    class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <span v-if="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                    {{ isLoading ? 'Simpan Perubahan' : 'Simpan Perubahan' }}
                </button>
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { usePages } from '@/composables/usePages'

const router = useRouter()
const route = useRoute()
const { fetchPage, updatePage, isLoading, error } = usePages()

const isLoadingFetch = ref(true)
const currentSlug = ref('')
const form = reactive({
    title: '',
    description: ''
})

onMounted(async () => {
    try {
        const page = await fetchPage(route.params.id)
        form.title = page.title
        form.description = page.description
        currentSlug.value = page.slug
    } catch (err) {
        // Redirect if not found
        router.push('/member/pages')
    } finally {
        isLoadingFetch.value = false
    }
})

const handleSubmit = async () => {
    try {
        await updatePage(route.params.id, form)
        router.push('/member/pages')
    } catch (err) {
        // Error handled
    }
}

const formatError = (err) => {
    if (typeof err === 'object') {
        return Object.values(err).join(', ')
    }
    return err
}
</script>
