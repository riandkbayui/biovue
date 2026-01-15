<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    <Navbar />
    
    <main class="pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Kebijakan Privasi</h1>
        
        <div class="prose prose-emerald bg-white p-8 md:p-12 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 mb-8">Terakhir diperbarui: 15 Januari 2026</p>

            <p>
                Di Aksibio, privasi Anda adalah prioritas kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat Anda menggunakan layanan kami.
            </p>

            <h3>1. Informasi yang Kami Kumpulkan</h3>
            <p>
                Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami, seperti saat Anda membuat akun, memperbarui profil Anda, atau menghubungi dukungan pelanggan. Informasi ini mungkin termasuk nama, alamat email, dan konten profil Anda.
            </p>

            <h3>2. Bagaimana Kami Menggunakan Informasi Anda</h3>
            <p>Kami menggunakan informasi yang kami kumpulkan untuk:</p>
            <ul>
                <li>Menyediakan, memelihara, dan meningkatkan layanan kami.</li>
                <li>Memproses transaksi dan mengirimkan pemberitahuan terkait.</li>
                <li>Menanggapi komentar, pertanyaan, dan permintaan layanan pelanggan Anda.</li>
                <li>Mengirimkan komunikasi teknis, pembaruan keamanan, dan pesan administratif.</li>
            </ul>

            <h3>3. Berbagi Informasi</h3>
            <p>
                Kami tidak menjual informasi pribadi Anda kepada pihak ketiga. Kami hanya membagikan informasi dalam keadaan terbatas, seperti untuk mematuhi hukum, melindungi hak kami, atau dengan penyedia layanan yang bekerja atas nama kami.
            </p>

            <h3>4. Keamanan Data</h3>
            <p>
                Kami mengambil langkah-langkah keamanan yang wajar untuk melindungi informasi Anda dari akses, pengungkapan, perubahan, atau penghancuran yang tidak sah. Namun, harap diingat bahwa tidak ada metode transmisi melalui internet yang 100% aman.
            </p>

            <h3>5. Hubungi Kami</h3>
            <p>
                Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami di privacy@aksibio.com.
            </p>
        </div>
    </main>

    <Footer />
  </div>
</template>
