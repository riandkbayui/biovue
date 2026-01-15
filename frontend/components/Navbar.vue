<script setup>
import { ref } from 'vue'

const props = defineProps({
  transparent: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <nav class="fixed w-full z-50 top-0 left-0 border-b transition-all duration-300"
       :class="[transparent ? 'bg-transparent border-transparent' : 'bg-white/80 border-gray-200 backdrop-blur-md']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <div class="flex items-center gap-2">
          <router-link to="/" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-emerald-600 flex items-center justify-center font-bold text-white">
              A
            </div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">
              Aksibio
            </span>
          </router-link>
        </div>
        
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-8">
            <template v-if="$route.path === '/'">
              <a href="#fitur" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Fitur</a>
              <a href="#cara-kerja" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Cara Kerja</a>
              <a href="#harga" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Harga</a>
            </template>
            <template v-else>
               <router-link to="/#fitur" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Fitur</router-link>
               <router-link to="/#cara-kerja" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Cara Kerja</router-link>
               <router-link to="/#harga" class="text-gray-600 hover:text-emerald-600 transition-colors duration-300">Harga</router-link>
            </template>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <router-link to="/login" class="text-sm font-medium hover:text-emerald-600 text-gray-600 transition-colors">
            Masuk
          </router-link>
          <router-link to="/register" class="px-5 py-2.5 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] transform hover:-translate-y-0.5">
            Daftar Gratis
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>
