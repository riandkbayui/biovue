<script setup>
const currentYear = new Date().getFullYear()
</script>

<template>
  <footer class="py-12 border-t border-gray-200 bg-gray-50 w-full relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-12 mb-12">
          <div class="col-span-2">
              <div class="flex items-center gap-2 mb-6">
                  <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-emerald-600 flex items-center justify-center font-bold text-white">
                  A
                  </div>
                  <span class="text-xl font-bold text-gray-900">Aksibio</span>
              </div>
              <p class="text-gray-600 leading-relaxed max-w-sm">
                  Aksibio membantu kreator, pembisnis, dan profesional membangun identitas digital yang kuat dengan satu tautan sederhana.
              </p>
          </div>
          <div>
              <h4 class="font-bold text-gray-900 mb-6">Navigasi</h4>
              <ul class="space-y-4 text-gray-600">
                  <li><router-link to="/about" class="hover:text-emerald-600 transition-colors">Tentang Kami</router-link></li>
                  <li><router-link to="/blog" class="hover:text-emerald-600 transition-colors">Blog</router-link></li>
                  <li><router-link to="/contact" class="hover:text-emerald-600 transition-colors">Hubungi Kami</router-link></li>
              </ul>
          </div>
          <div>
              <h4 class="font-bold text-gray-900 mb-6">Legal</h4>
              <ul class="space-y-4 text-gray-600">
                  <li><router-link to="/privacy" class="hover:text-emerald-600 transition-colors">Privasi</router-link></li>
                  <li><router-link to="/terms" class="hover:text-emerald-600 transition-colors">Syarat & Ketentuan</router-link></li>
              </ul>
          </div>
      </div>
      <div class="border-t border-gray-200 pt-8 text-center text-gray-500 text-sm">
        &copy; {{ currentYear }} Aksibio. All rights reserved. Made with ❤️ in Indonesia.
      </div>
    </div>
  </footer>
</template>
