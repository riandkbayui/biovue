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
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="page in pages" :key="page.id" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-500 relative">
             <div class="absolute inset-0 opacity-10 flex items-center justify-center pointer-events-none">
                 <i class="bi bi-grid-3x3-gap text-7xl"></i>
             </div>
             <div class="absolute -bottom-6 left-6">
                 <div class="w-16 h-16 rounded-2xl bg-white p-1 shadow-lg overflow-hidden border border-gray-100 group-hover:scale-110 transition-transform">
                     <div class="w-full h-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-2xl rounded-xl">
                        {{ page.title.substring(0, 1).toUpperCase() }}
                     </div>
                 </div>
             </div>
             <div class="absolute top-4 right-4 relative">
                 <div class="dropdown dropdown-end">
                    <button tabindex="0" class="w-8 h-8 rounded-lg bg-black/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/40 transition-colors">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 mt-2 text-gray-700">
                        <li><a @click="handleDelete(page.id)" class="text-red-600"><i class="bi bi-trash"></i> Hapus</a></li>
                    </ul>
                 </div>
             </div>
        </div>
        <div class="p-6 pt-10">
          <div class="flex items-center justify-between">
              <h4 class="font-bold text-lg text-gray-900 leading-none truncate pr-2">{{ page.title }}</h4>
              <span :class="['px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider', page.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500']">
                {{ page.status }}
              </span>
          </div>
          <p class="text-sm text-gray-500 mt-2 flex items-center gap-1 truncate">
              <i class="bi bi-link-45deg"></i>
              <a :href="'/' + page.slug" target="_blank" class="hover:underline">aksibio.com/{{ page.slug }}</a>
          </p>
          
          <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-50">
              <div class="flex-1">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Created</p>
                  <p class="font-bold text-gray-900 font-mono text-xs">{{ formatDate(page.created_at.date) }}</p>
              </div>
              <div class="flex items-center gap-2">
                  <router-link :to="'/member/page-builder/' + page.id" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-600 transition-all" title="Edit Halaman (Page Builder)">
                      <i class="bi bi-pencil-square"></i>
                  </router-link>
                  <a :href="'/' + page.slug" target="_blank" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-blue-50 hover:text-blue-600 transition-all" title="Lihat Halaman">
                      <i class="bi bi-box-arrow-up-right"></i>
                  </a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePages } from '@/composables/usePages'

const { pages, fetchPages, deletePage, isLoading, error } = usePages()

onMounted(() => {
    fetchPages()
})

const handleDelete = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus halaman ini?')) {
        await deletePage(id)
    }
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('id-ID', options)
}
</script>
