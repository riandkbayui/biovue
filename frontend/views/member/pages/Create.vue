<template>
  <div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <router-link to="/member/pages" class="text-gray-500 hover:text-emerald-600 flex items-center gap-2 mb-4 transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Saya
        </router-link>
        <h2 class="text-2xl font-bold text-gray-900">Buat Halaman Baru</h2>
        <p class="text-gray-500 mt-1">Isi detail dasar untuk memulai bio link Anda.</p>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
            
            <div v-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                {{ formatError(error) }}
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                <input type="text" id="title" v-model="form.title" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                    placeholder="Contoh: Portofolio Saya" />
                <p class="text-xs text-gray-500 mt-1">Judul ini akan muncul di tab browser dan preview link.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea id="description" v-model="form.description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                    placeholder="Ceritakan sedikit tentang halaman ini..."></textarea>
            </div>

            <div class="pt-4 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isLoading" 
                    class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <span v-if="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                    {{ isLoading ? 'Memproses...' : 'Buat Halaman' }}
                </button>
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { usePages } from '@/composables/usePages'

const router = useRouter()
const { createPage, isLoading, error } = usePages()

const form = reactive({
    title: '',
    description: ''
})

const handleSubmit = async () => {
    try {
        const result = await createPage(form)
        if (result && result.data && result.data.id) {
            router.push('/member/page-builder/' + result.data.id)
        } else {
            router.push('/member/pages')
        }
    } catch (err) {
        // Error handled by composable/template
    }
}

const formatError = (err) => {
    if (typeof err === 'object') {
        return Object.values(err).join(', ')
    }
    return err
}
</script>
