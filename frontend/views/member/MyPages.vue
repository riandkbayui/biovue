<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
      <div>
        <h3 class="text-2xl font-bold text-gray-900">Halaman Saya</h3>
        <p class="text-gray-500 mt-1">Kelola semua bio link Anda di sini.</p>
      </div>
      <router-link to="/member/pages/create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Buat Halaman Baru
      </router-link>
    </div>

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
        {{ error }}
    </div>

    <!-- Empty State -->
    <div v-else-if="pages.length === 0" class="text-center py-16 bg-white rounded-3xl border border-gray-100 border-dashed">
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-layers text-4xl text-emerald-300"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada halaman</h3>
        <p class="text-gray-500 max-w-sm mx-auto mb-6">Mulai buat halaman bio link pertama Anda dan bagikan ke audiens Anda.</p>
        <router-link to="/member/pages/create" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition-colors inline-flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Buat Sekarang
        </router-link>
    </div>

    <!-- Grid List -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 sm:gap-8">
      <div v-for="page in pages" :key="page.id" class="bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 group relative">
        
        <!-- Action: Delete (Top Right - Always Visible for Mobile First) -->
        <button 
          @click="handleDelete(page.id)"
          class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-red-500 hover:text-white transition-all z-10 shadow-lg border border-white/10"
          title="Hapus Halaman"
        >
          <i class="bi bi-trash text-xs"></i>
        </button>

        <!-- Header: Background & Initial -->
        <div class="h-28 bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-400 relative overflow-hidden p-6">
          <div class="absolute inset-0 opacity-20 transform -rotate-12 translate-y-4">
            <i class="bi bi-link-45deg text-[10rem] -ml-8"></i>
          </div>
          
          <div class="relative flex justify-between items-start">
            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white font-black text-2xl shadow-xl">
              {{ (page.title || 'A').charAt(0).toUpperCase() }}
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6 pt-6">
          <div class="mb-5">
            <div class="flex items-center justify-between gap-3">
                <h4 class="font-black text-lg text-gray-900 leading-tight truncate">{{ page.title }}</h4>
                <span :class="['px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest border shrink-0', 
                page.status === 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-gray-50 text-gray-500 border-gray-100']">
                {{ page.status }}
                </span>
            </div>
            <div class="flex items-center gap-2 mt-1.5 group/link">
              <span class="text-xs font-bold text-gray-400 flex items-center gap-1">
                <i class="bi bi-globe2"></i> aksibio.com/{{ page.slug }}
              </span>
              <button @click="copyLink(page.slug)" class="w-6 h-6 rounded-md bg-gray-50 text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all flex items-center justify-center opacity-0 group-hover/link:opacity-100" title="Salin Link">
                <i class="bi bi-clipboard"></i>
              </button>
            </div>
          </div>

          <!-- Bottom Actions -->
          <div class="flex items-center gap-3 pt-6 border-t border-gray-50">
            <router-link 
              :to="'/member/page-builder/' + page.id" 
              class="flex-1 h-12 rounded-xl bg-emerald-600 text-white font-bold text-sm flex items-center justify-center gap-2 hover:bg-emerald-700 hover:scale-[1.02] transition-all shadow-lg shadow-emerald-600/20"
            >
              <i class="bi bi-pencil-square"></i>
              Edit Builder
            </router-link>
            
            <a 
              :href="'/' + page.slug" 
              target="_blank" 
              class="w-12 h-12 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-transparent hover:border-emerald-100"
              title="Lihat Live"
            >
              <i class="bi bi-box-arrow-up-right text-lg"></i>
            </a>
          </div>

          <div class="mt-4 flex items-center justify-between text-[10px] text-gray-300 font-bold uppercase tracking-widest">
            <span>Dibuat pada</span>
            <span>{{ formatDate(page.created_at?.date) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination Controls -->
    <div v-if="pagination.pageCount > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-gray-100">
        <p class="text-sm text-gray-500 font-medium">
            Menampilkan <span class="text-gray-900 font-bold">{{ pages.length }}</span> dari <span class="text-gray-900 font-bold">{{ pagination.total }}</span> halaman
        </p>
        
        <div class="flex items-center gap-1 bg-white p-1 rounded-2xl border border-gray-100 shadow-sm">
            <button 
                @click="changePage(pagination.currentPage - 1)"
                :disabled="pagination.currentPage === 1"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-500 transition-all font-bold"
            >
                <i class="bi bi-chevron-left"></i>
            </button>

            <button 
                v-for="p in pagination.pageCount" 
                :key="p"
                @click="changePage(p)"
                :class="[
                    'w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-all',
                    pagination.currentPage === p 
                    ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 scale-110' 
                    : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600'
                ]"
            >
                {{ p }}
            </button>

            <button 
                @click="changePage(pagination.currentPage + 1)"
                :disabled="pagination.currentPage === pagination.pageCount"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-gray-500 transition-all font-bold"
            >
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePages } from '@/composables/usePages'

const { pages, pagination, fetchPages, deletePage, isLoading, error } = usePages()

onMounted(() => {
    fetchPages()
})

const changePage = (page) => {
    if (page < 1 || page > pagination.value.pageCount) return
    fetchPages(page)
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

const handleDelete = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus halaman ini?')) {
        await deletePage(id)
    }
}

const copyLink = (slug) => {
    const url = `${window.location.origin}/${slug}`
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berhasil disalin ke clipboard!')
    })
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('id-ID', options)
}
</script>
