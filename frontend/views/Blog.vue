<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const articles = [
    {
        title: '7 Cara Mengoptimalkan Bio Link Anda untuk Penjualan',
        excerpt: 'Pelajari strategi ampuh untuk mengubah pengunjung profil sosial media menjadi pelanggan setia menggunakan psikologi warna dan copywriting.',
        date: '15 Jan 2026',
        category: 'Tips Bisnis',
        image: 'https://via.placeholder.com/800x400/10b981/ffffff?text=Bio+Link+Strategy' 
    },
    {
        title: 'Tren Desain Bio Link Tahun 2026',
        excerpt: 'Jangan ketinggalan zaman. Temukan gaya visual terbaru yang sedang digemari kreator top dunia tahun ini.',
        date: '10 Jan 2026',
        category: 'Desain',
        image: 'https://via.placeholder.com/800x400/059669/ffffff?text=Design+Trends'
    },
    {
        title: 'Studi Kasus: Bagaimana Kreator Ini Naik Omzet 300%',
        excerpt: 'Kisah inspiratif seorang konten kreator kuliner yang memanfaatkan fitur analitik Aksibio untuk memahami audiensnya.',
        date: '02 Jan 2026',
        category: 'Inspirasi',
        image: 'https://via.placeholder.com/800x400/047857/ffffff?text=Success+Story'
    }
]
</script>

<template>
  <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    <Navbar />
    
    <main class="pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog Aksibio</h1>
            <p class="text-xl text-gray-600">Wawasan, tips, dan inspirasi untuk pertumbuhan digital Anda.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <article v-for="(article, index) in articles" :key="index" class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                <div class="h-48 overflow-hidden bg-gray-200 relative">
                     <!-- Placeholder visual -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400">
                        <i class="bi bi-image text-3xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 font-medium text-xs">{{ article.category }}</span>
                        <span>{{ article.date }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors">
                        <a href="#">{{ article.title }}</a>
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ article.excerpt }}
                    </p>
                    <a href="#" class="inline-flex items-center text-emerald-600 font-medium hover:underline">
                        Baca Selengkapnya <i class="bi bi-arrow-right ml-2"></i>
                    </a>
                </div>
            </article>
        </div>
    </main>

    <Footer />
  </div>
</template>
