<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    <Navbar />
    
    <main class="pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Tentang Aksibio</h1>
            <p class="text-xl text-gray-600">Misi kami adalah mendemokratisasi identitas digital untuk semua orang.</p>
        </div>

        <div class="prose prose-lg prose-emerald mx-auto bg-white p-10 rounded-3xl border border-gray-100 shadow-sm">
            <p>
                Aksibio didirikan dengan satu tujuan sederhana: memudahkan kreator, profesional, dan pemilik bisnis untuk membagikan siapa mereka dan apa yang mereka lakukan hanya dalam satu tautan.
            </p>
            <p>
                Di era digital yang serba cepat ini, audiens Anda tersebar di berbagai platform—Instagram, TikTok, YouTube, LinkedIn, dan banyak lagi. Aksibio menyatukan semua itu menjadi sebuah halaman arahan mikro yang indah, responsif, dan mudah dikelola.
            </p>
            <h3>Nilai Kami</h3>
            <ul>
                <li><strong>Simplicity:</strong> Kami percaya bahwa teknologi harus mudah digunakan oleh siapa saja.</li>
                <li><strong>Estetika:</strong> Fungsi itu penting, tetapi keindahanlah yang membuat orang bertahan.</li>
                <li><strong>Transparansi:</strong> Tidak ada biaya tersembunyi atau syarat yang rumit.</li>
            </ul>
             <div class="my-10 p-6 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-start gap-4">
                <i class="bi bi-quote text-4xl text-emerald-300"></i>
                <div>
                    <p class="italic text-gray-700 font-medium mb-4">"Aksibio bukan hanya tentang tautan. Ini tentang memberi Anda kendali penuh atas bagaimana dunia melihat Anda secara online."</p>
                    <div class="font-bold text-gray-900">— CEO Aksibio</div>
                </div>
            </div>
            <p>
                Bergabunglah dengan kami dalam perjalanan ini untuk membuat internet menjadi tempat yang lebih terhubung dan personal.
            </p>
        </div>
    </main>

    <Footer />
  </div>
</template>
