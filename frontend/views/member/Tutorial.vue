<template>
  <div class="space-y-8 animate-fade-in pb-20">
    <!-- Header -->
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Tutorial</h1>
      <p class="text-gray-500 mt-1">Panduan lengkap menggunakan Biovue</p>
    </div>

    <!-- Featured Video -->
    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 group cursor-pointer">
      <div class="relative aspect-video bg-gray-900 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors"></div>
        <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1000&auto=format&fit=crop" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover opacity-50">
        <button class="relative w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform">
          <i class="bi bi-play-fill pl-1"></i>
        </button>
      </div>
      <div class="p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Memulai dengan Biovue</h2>
        <p class="text-gray-600">Pelajari cara membuat halaman bio pertama anda, menambahkan link, dan menyesuaikan tampilan hanya dalam 5 menit.</p>
      </div>
    </div>

    <!-- Accordion Guides -->
    <div>
      <h3 class="text-lg font-bold text-gray-900 mb-4">Panduan Cepat</h3>
      <div class="space-y-4">
        <div 
          v-for="(guide, index) in guides" 
          :key="index"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
          :class="{ 'ring-2 ring-emerald-500/10': openIndex === index }"
        >
          <button 
            @click="toggle(index)"
            class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors"
          >
            <div class="flex items-center gap-4">
              <div 
                :class="['w-10 h-10 rounded-xl flex items-center justify-center transition-colors', openIndex === index ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-500']"
              >
                <i :class="['bi', guide.icon]"></i>
              </div>
              <span class="font-bold text-gray-900">{{ guide.title }}</span>
            </div>
            <i 
              class="bi bi-chevron-down text-gray-400 transition-transform duration-300"
              :class="{ 'rotate-180': openIndex === index }"
            ></i>
          </button>
          
          <div 
            v-show="openIndex === index"
            class="px-6 pb-6 pt-0 animate-fade-in"
          >
            <div class="pl-14 text-gray-600 text-sm leading-relaxed space-y-3 border-l-2 border-emerald-100 ml-5">
              <p v-for="(step, sIndex) in guide.steps" :key="sIndex">
                <span class="font-bold text-emerald-600 mr-2">{{ sIndex + 1 }}.</span> {{ step }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Help Card -->
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-8 text-white shadow-xl shadow-indigo-200">
      <div class="flex items-start justify-between">
        <div>
          <h3 class="text-2xl font-bold mb-2">Butuh Bantuan Lebih?</h3>
          <p class="text-indigo-100 mb-6 max-w-sm">Tim support kami siap membantu anda 24/7 jika anda mengalami kendala teknis.</p>
          <button class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition-colors shadow-lg shadow-black/10">
            <i class="bi bi-whatsapp mr-2"></i>
            Chat Support
          </button>
        </div>
        <i class="bi bi-life-preserver text-8xl text-white/10 hidden sm:block"></i>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const openIndex = ref(0);

const toggle = (index) => {
  openIndex.value = openIndex.value === index ? null : index;
};

const guides = [
  {
    title: 'Cara Membuat Halaman Baru',
    icon: 'bi-file-earmark-plus',
    steps: [
      'Masuk ke menu "My Pages" dari dashboard.',
      'Klik tombol "Buat Halaman Baru" di pojok kanan atas.',
      'Pilih template yang anda sukai atau mulai dari kosong.',
      'Masukkan nama unik untuk URL halaman anda.',
      'Klik "Simpan" untuk membuat halaman.'
    ]
  },
  {
    title: 'Menambahkan Link Social Media',
    icon: 'bi-share',
    steps: [
      'Buka editor halaman yang ingin diedit.',
      'Pilih block "Social Icons" dari menu blocks.',
      'Masukkan username untuk masing-masing platform (Instagram, TikTok, dll).',
      'Atur warna dan gaya icon sesuai keinginan.',
      'Simpan perubahan anda.'
    ]
  },
  {
    title: 'Melihat Statistik Pengunjung',
    icon: 'bi-bar-chart',
    steps: [
      'Buka menu "Statistics" dari sidebar.',
      'Pilih rentang waktu (Harian atau Bulanan).',
      'Lihat grafik kunjungan dan klik pada kartu ringkasan.',
      'Scroll ke bawah untuk melihat detail performa per halaman.'
    ]
  },
  {
    title: 'Mengatur Domain Kustom',
    icon: 'bi-globe',
    steps: [
      'Pastikan anda sudah berlangganan paket Pro.',
      'Pergi ke menu Settings pada halaman editor.',
      'Masukkan nama domain yang sudah anda beli.',
      'Ikuti instruksi konfigurasi DNS (CNAME/A Record).',
      'Tunggu propagasi DNS (maksimal 24 jam).'
    ]
  }
];
</script>