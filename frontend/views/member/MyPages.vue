<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
      <div>
        <h3 class="text-2xl font-bold text-gray-900">Halaman Saya</h3>
        <p class="text-gray-500 mt-1">Kelola semua bio link Anda di sini.</p>
      </div>
      <router-link to="/member/page-builder" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Buat Halaman Baru
      </router-link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="i in 3" :key="i" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-500 relative">
             <div class="absolute inset-0 opacity-10 flex items-center justify-center pointer-events-none">
                 <i class="bi bi-grid-3x3-gap text-7xl"></i>
             </div>
             <div class="absolute -bottom-6 left-6">
                 <div class="w-16 h-16 rounded-2xl bg-white p-1 shadow-lg overflow-hidden border border-gray-100 group-hover:scale-110 transition-transform">
                     <img src="https://api.dicebear.com/7.x/identicon/svg?seed=Page" alt="logo" class="w-full h-full rounded-xl object-cover" />
                 </div>
             </div>
             <div class="absolute top-4 right-4 flex gap-2">
                 <button class="w-8 h-8 rounded-lg bg-black/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/40 transition-colors">
                     <i class="bi bi-three-dots"></i>
                 </button>
             </div>
        </div>
        <div class="p-6 pt-10">
          <div class="flex items-center justify-between">
              <h4 class="font-bold text-lg text-gray-900 leading-none">Personal Bio {{ i }}</h4>
              <span class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">Active</span>
          </div>
          <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
              <i class="bi bi-link-45deg"></i>
              aksibio.com/personal-link-{{ i }}
          </p>
          
          <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-50">
              <div class="flex-1">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Views</p>
                  <p class="font-bold text-gray-900 font-mono">1,240</p>
              </div>
              <div class="flex-1 border-x border-gray-50 px-4">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Clicks</p>
                  <p class="font-bold text-gray-900 font-mono">458</p>
              </div>
              <div class="flex items-center gap-2">
                  <button class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                      <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-blue-50 hover:text-blue-600 transition-all">
                      <i class="bi bi-box-arrow-up-right"></i>
                  </button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
