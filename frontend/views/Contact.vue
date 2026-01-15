<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import { ref } from 'vue'
import Input from '@/components/Input.vue'
import Button from '@/components/Button.vue'

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
})

const isSubmitting = ref(false)
const showSuccess = ref(false)

const handleSubmit = async () => {
    isSubmitting.value = true
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1500))
    isSubmitting.value = false
    showSuccess.value = true
    form.value = { name: '', email: '', subject: '', message: '' }
    
    setTimeout(() => {
        showSuccess.value = false
    }, 5000)
}
</script>

<template>
  <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    <Navbar />
    
    <main class="pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
            <p class="text-xl text-gray-600">Kami siap membantu Anda. Kirimkan pesan atau pertanyaan Anda kepada kami.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="bg-emerald-600 rounded-3xl p-10 text-white relative overflow-hidden shadow-xl">
                 <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2 opacity-50"></div>
                 <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-500 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2 opacity-50"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-6">Informasi Kontak</h3>
                    <p class="text-emerald-50 mb-10 leading-relaxed">
                        Punya pertanyaan seputar fitur, harga, atau butuh bantuan teknis? Tim support kami akan dengan senang hati membantu Anda.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-2xl">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Email</h4>
                                <p class="text-emerald-50">support@aksibio.com</p>
                                <p class="text-emerald-50">halo@aksibio.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                             <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-2xl">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Lokasi</h4>
                                <p class="text-emerald-50">Jakarta Selatan, Indonesia</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-2xl">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Jam Operasional</h4>
                                <p class="text-emerald-50">Senin - Jumat: 09.00 - 17.00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-3xl p-10 border border-gray-100 shadow-sm">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div v-if="showSuccess" class="p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center gap-3 animate-fade-in">
                        <i class="bi bi-check-circle-fill text-xl"></i>
                        <span>Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.</span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <Input v-model="form.name" type="text" required placeholder="John Doe" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <Input v-model="form.email" type="email" required placeholder="john@example.com" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                         <select v-model="form.subject" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all bg-white">
                            <option value="" disabled selected>Pilih topik...</option>
                            <option value="general">Pertanyaan Umum</option>
                            <option value="support">Bantuan Teknis</option>
                            <option value="billing">Pembayaran & Tagihan</option>
                            <option value="partnership">Kerjasama</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea v-model="form.message" required rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder-gray-400 resize-none" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                    </div>

                    <Button type="submit" variant="primary" class="w-full justify-center" :disabled="isSubmitting">
                        <span v-if="isSubmitting" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin mr-2"></span>
                        <span>{{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan' }}</span>
                    </Button>
                </form>
            </div>
        </div>
    </main>

    <Footer />
  </div>
</template>
