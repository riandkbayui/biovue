<template>
  <div class="space-y-6 animate-fade-in">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Manajemen Halaman</h1>
      <p class="text-gray-500 mt-1">Tinjau dan kelola halaman bio yang dibuat oleh pengguna</p>
    </div>

    <!-- Page Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="page in pages" :key="page.id" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
        <div class="h-32 bg-slate-100 relative">
          <div class="absolute inset-0 flex items-center justify-center text-slate-300">
            <i class="bi bi-image text-4xl"></i>
          </div>
          <div class="absolute top-4 left-4">
            <Badge :variant="page.status === 'Diterbitkan' ? 'success' : 'warning'">{{ page.status }}</Badge>
          </div>
        </div>
        <div class="p-6">
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="font-bold text-gray-900">/{{ page.slug }}</h3>
              <p class="text-xs text-gray-500">oleh {{ page.owner }}</p>
            </div>
            <div class="text-right">
              <p class="text-sm font-bold text-gray-900">{{ page.views }}</p>
              <p class="text-[10px] text-gray-400 uppercase font-bold">Dilihat</p>
            </div>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-gray-50">
            <div class="flex -space-x-2">
              <div v-for="i in 3" :key="i" class="w-6 h-6 rounded-full border-2 border-white bg-indigo-100 flex items-center justify-center text-[8px] font-bold text-indigo-700">
                {{ i }}
              </div>
            </div>
            <div class="flex gap-2">
              <button class="p-2 text-gray-400 hover:text-indigo-600 transition-colors"><i class="bi bi-eye"></i></button>
              <button class="p-2 text-gray-400 hover:text-red-600 transition-colors"><i class="bi bi-trash"></i></button>
              <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors"><i class="bi bi-three-dots-vertical"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Badge from '../../components/Badge.vue';

const pages = [
  { id: 1, slug: 'aksibio-pro', owner: 'Alex Johnson', status: 'Diterbitkan', views: '2.5k' },
  { id: 2, slug: 'my-link-in-bio', owner: 'Sarah Miller', status: 'Diterbitkan', views: '840' },
  { id: 3, slug: 'portfolio-rian', owner: 'Rian DK', status: 'Draf', views: '0' },
  { id: 4, slug: 'social-links', owner: 'Mike Brown', status: 'Diterbitkan', views: '12.1k' },
  { id: 5, slug: 'coffee-shop', owner: 'Emma Wilson', status: 'Diterbitkan', views: '3.2k' },
  { id: 6, slug: 'personal-blog', owner: 'John Doe', status: 'Diterbitkan', views: '1.2k' },
]
</script>