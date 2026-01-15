<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const positions = [
    {
        title: 'Senior Frontend Developer (Vue.js)',
        department: 'Engineering',
        location: 'Remote (Indonesia)',
        type: 'Full-time'
    },
    {
        title: 'UI/UX Designer',
        department: 'Product',
        location: 'Jakarta, Indonesia',
        type: 'Full-time'
    },
    {
        title: 'Digital Marketing Specialist',
        department: 'Marketing',
        location: 'Remote',
        type: 'Part-time'
    }
]
</script>

<template>
  <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    <Navbar />
    
    <main class="pt-32 pb-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Bergabung Bersama Kami</h1>
            <p class="text-xl text-gray-600">Bantu kami membangun masa depan identitas digital.</p>
        </div>

        <div class="bg-emerald-600 rounded-3xl p-10 md:p-16 text-center text-white mb-20 shadow-xl overflow-hidden relative">
             <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2 opacity-50"></div>
             <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-500 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2 opacity-50"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-6">Budaya Kerja Kami</h2>
                <p class="text-lg text-emerald-50 mb-8 max-w-2xl mx-auto">
                    Kami percaya pada kerja cerdas, bukan hanya kerja keras. Kami menghargai otonomi, kreativitas, dan keseimbangan kehidupan kerja yang sehat.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/20">
                        <i class="bi bi-laptop text-3xl mb-4 block"></i>
                        <h3 class="font-bold text-lg mb-2">Remote First</h3>
                        <p class="text-sm text-emerald-100">Bekerja dari mana saja yang membuat Anda produktif.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/20">
                        <i class="bi bi-heart-pulse text-3xl mb-4 block"></i>
                        <h3 class="font-bold text-lg mb-2">Kesehatan Mental</h3>
                        <p class="text-sm text-emerald-100">Dukungan penuh untuk kesejahteraan tim kami.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/20">
                        <i class="bi bi-graph-up-arrow text-3xl mb-4 block"></i>
                        <h3 class="font-bold text-lg mb-2">Growth</h3>
                        <p class="text-sm text-emerald-100">Anggaran tahunan untuk pelatihan dan pengembangan diri.</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-8 pl-4 border-l-4 border-emerald-500">Posisi Terbuka</h2>
        <div class="space-y-4">
            <div v-for="(job, index) in positions" :key="index" class="bg-white p-6 rounded-xl border border-gray-200 hover:border-emerald-500 hover:shadow-md transition-all flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ job.title }}</h3>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mt-2">
                        <span class="flex items-center gap-1"><i class="bi bi-building"></i> {{ job.department }}</span>
                        <span class="flex items-center gap-1"><i class="bi bi-geo-alt"></i> {{ job.location }}</span>
                        <span class="flex items-center gap-1"><i class="bi bi-clock"></i> {{ job.type }}</span>
                    </div>
                </div>
                <button class="px-6 py-2 rounded-lg border border-emerald-600 text-emerald-600 font-medium hover:bg-emerald-50 transition-colors whitespace-nowrap">
                    Lamar Sekarang
                </button>
            </div>
        </div>
    </main>

    <Footer />
  </div>
</template>
