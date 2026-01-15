<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const router = useRouter()

const features = [
  {
    title: 'Tanpa Batas',
    description: 'Buat tautan sebanyak yang Anda butuhkan tanpa batasan kuota.',
    icon: 'M13 10V3L4 14h7v7l9-11h-7z'
  },
  {
    title: 'Analitik Lengkap',
    description: 'Pantau performa tautan Anda dengan data real-time yang akurat.',
    icon: 'M3 3v18h18 M18 9l-5 5-4-4-5 5'
  },
  {
    title: 'Desain Premium',
    description: 'Pilih dari berbagai tema profesional yang siap pakai.',
    icon: 'M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'
  }
]

const stats = [
  { label: 'Pengguna Aktif', value: '10K+' },
  { label: 'Tautan Dibuat', value: '500K+' },
  { label: 'Klik Terlacak', value: '2M+' }
]

const steps = [
  {
    title: 'Daftar Akun',
    description: 'Mulai dengan membuat akun gratis Anda hanya dalam hitungan detik.',
    icon: 'bi bi-person-plus'
  },
  {
    title: 'Custom Link',
    description: 'Tambahkan tautan sosial media, website, dan konten penting Anda.',
    icon: 'bi bi-link-45deg'
  },
  {
    title: 'Bagikan',
    description: 'Bagikan satu link ajaib Anda di bio Instagram, TikTok, dan lainnya.',
    icon: 'bi bi-share'
  }
]

const pricingPlans = [
  {
    name: 'Gratis',
    price: '0',
    description: 'Cocok untuk pemula yang ingin memulai kehadiran digital.',
    features: ['Link Tak Terbatas', 'Tema Dasar', 'Analitik Standar', 'Branding Aksibio'],
    buttonText: 'Mulai Gratis',
    highlighted: false
  },
  {
    name: 'Pro',
    price: '49K',
    description: 'Fitur lengkap untuk profesional dan pelaku bisnis.',
    features: ['Semua Fitur Gratis', 'Tema Premium Custom', 'Analitik Mendalam', 'Tanpa Branding Aksibio', 'Integrasi Pixel'],
    buttonText: 'Langganan Sekarang',
    highlighted: true
  }
]

const testimonials = [
  {
    name: "Rina Kartika",
    role: "Content Creator",
    image: "https://randomuser.me/api/portraits/women/44.jpg",
    content: "Aksibio benar-benar mengubah cara saya mengelola traffic dari Instagram. Desainnya cantik dan analitiknya sangat membantu!"
  },
  {
    name: "Budi Santoso",
    role: "Digital Marketer",
    image: "https://randomuser.me/api/portraits/men/32.jpg",
    content: "Fitur pixel tracking-nya juara. Saya bisa retargeting audiens dengan mudah. Wajib punya buat pebisnis online."
  },
  {
    name: "Siti Aminah",
    role: "UMKM Owner",
    image: "https://randomuser.me/api/portraits/women/68.jpg",
    content: "Simpel banget pakainya. Gak perlu jago coding udah bisa bikin landing page mini yang profesional. Suka banget!"
  }
]

const benefits = [
  {
    title: "Tingkatkan Konversi",
    description: "Arahkan pengikut Anda ke tempat yang tepat dan ubah mereka menjadi pelanggan loyal.",
    icon: "bi bi-graph-up-arrow"
  },
  {
    title: "Kelola Mudah",
    description: "Update link kapan saja tanpa perlu mengubah bio di semua media sosial Anda.",
    icon: "bi bi-sliders"
  },
  {
    title: "Data Real-time",
    description: "Dapatkan wawasan mendalam tentang siapa yang mengklik link Anda dan dari mana mereka berasal.",
    icon: "bi bi-pie-chart"
  },
  {
    title: "Kustomisasi Penuh",
    description: "Sesuaikan tampilan dengan warna brand Anda agar terlihat lebih profesional dan terpercaya.",
    icon: "bi bi-palette"
  }
]

const faqs = [
  {
    question: "Apakah ada biaya bulanan?",
    answer: "Tersedia paket Gratis selamanya dengan fitur dasar. Untuk fitur lanjutan, Anda bisa upgrade ke paket Pro mulai Rp 49rb/bulan."
  },
  {
    question: "Bisa pakai domain sendiri?",
    answer: "Saat ini fitur custom domain sedang dalam pengembangan dan akan segera tersedia untuk pengguna Pro."
  },
  {
    question: "Apakah data saya aman?",
    answer: "Tentu saja. Kami menggunakan enkripsi standar industri untuk melindungi data Anda dan tidak akan pernah menjualnya ke pihak ketiga."
  }
]



const currentYear = new Date().getFullYear()

// Typing effect logic
const typedText = ref('')
const roles = ['contentcreator', 'bisnis', 'influencer', 'fotografer', 'umkm']
let roleIndex = 0
let charIndex = 0
let isDeleting = false

const type = () => {
    const currentRole = roles[roleIndex]
    
    if (isDeleting) {
        typedText.value = currentRole.substring(0, charIndex - 1)
        charIndex--
    } else {
        typedText.value = currentRole.substring(0, charIndex + 1)
        charIndex++
    }

    let typeSpeed = 150

    if (isDeleting) {
        typeSpeed /= 2
    }

    if (!isDeleting && charIndex === currentRole.length) {
        typeSpeed = 2000
        isDeleting = true
    } else if (isDeleting && charIndex === 0) {
        isDeleting = false
        roleIndex = (roleIndex + 1) % roles.length
        typeSpeed = 500
    }

    setTimeout(type, typeSpeed)
}

onMounted(() => {
    type()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 text-gray-900 selection:bg-emerald-500 selection:text-white font-sans overflow-x-hidden">
    <!-- Navbar -->
    <!-- Navbar -->
    <Navbar />

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute top-0 right-0 -z-10 w-[800px] h-[800px] bg-emerald-500/10 rounded-full blur-[120px] translate-x-1/3 -translate-y-1/3"></div>
      <div class="absolute bottom-0 left-0 -z-10 w-[600px] h-[600px] bg-cyan-500/10 rounded-full blur-[100px] -translate-x-1/3 translate-y-1/3"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-center lg:text-left">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-medium mb-6 animate-fade-in-up">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Salah satu platform Bio Link terbaik di Indonesia
          </div>
          
          <h1 class="text-5xl lg:text-7xl font-bold tracking-tight mb-8 leading-tight">
            Satu Link untuk <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500 animate-gradient">
              Semua Identitas
            </span>
          </h1>
          
          <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
            Gabungkan semua profil sosial media, portofolio, dan konten terbaik Anda dalam satu halaman yang menakjubkan. Tingkatkan personal branding Anda sekarang.
          </p>
          
          <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
            <button class="w-full sm:w-auto px-8 py-4 rounded-full bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-xl hover:shadow-2xl hover:shadow-emerald-500/20 transform hover:-translate-y-1">
              Mulai Sekarang — Gratis
            </button>
            <button class="w-full sm:w-auto px-8 py-4 rounded-full bg-white border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-all backdrop-blur-sm flex items-center justify-center gap-2 group">
              <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Lihat Demo
            </button>
          </div>

          <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 opacity-40 grayscale hover:grayscale-0 transition-all duration-500 text-gray-900">
            <!-- Simple placeholders for logos -->
            <span class="text-xl font-bold">TikTok</span>
            <span class="text-xl font-bold">Instagram</span>
            <span class="text-xl font-bold">YouTube</span>
            <span class="text-xl font-bold">Linkedin</span>
          </div>
        </div>

        <div class="relative lg:h-[600px] flex items-center justify-center perspective-1000 group">
            <!-- Hero Image Container -->
            <div class="relative z-10 w-full max-w-md mx-auto transform transition-transform duration-700 hover:rotate-y-6 hover:rotate-x-6 rotate-y-12 floating-animation">
                <!-- Glow Effect -->
                <div class="absolute inset-0 bg-emerald-500/20 blur-[60px] rounded-full"></div>
                
                <img 
                    src="/hero-illustration.svg" 
                    alt="Biolink App Interface" 
                    class="relative w-full rounded-[2.5rem] shadow-2xl border-4 border-white/50 backdrop-blur-sm"
                />

                <!-- Floating Cards -->
                <div class="absolute -right-12 top-24 p-4 rounded-2xl bg-white/90 backdrop-blur-md border border-white/40 shadow-xl animate-float-delayed hidden lg:block">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-pink-500 to-orange-400 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.85-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.85-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Pengikut Baru</div>
                            <div class="text-sm font-bold text-gray-900">+1,240</div>
                        </div>
                    </div>
                </div>

                <div class="absolute -left-8 bottom-32 p-4 rounded-2xl bg-white/90 backdrop-blur-md border border-white/40 shadow-xl animate-float hidden lg:block">
                     <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Total Klik</div>
                            <div class="text-sm font-bold text-gray-900">85.4K</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 border-y border-gray-200 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <div class="text-4xl font-bold text-gray-900 mb-2">{{ stat.value }}</div>
            <div class="text-emerald-600 font-medium">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Live Example Section -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                     <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-medium mb-6">
                        <i class="bi bi-lightning-charge-fill"></i> Coba Sekarang
                    </div>
                    <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900 leading-tight">
                        Satu Link untuk <br />
                        <span class="text-emerald-600">aksibio.com/</span><span class="text-emerald-500 border-r-4 border-emerald-500 pr-1 animate-pulse">{{ typedText }}</span>
                    </h2>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Klaim username unik Anda sekarang sebelum diambil orang lain. Buat halaman bio yang profesional hanya dalam hitungan menit.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                         <div class="relative flex-grow max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-medium">aksibio.com/</span>
                            </div>
                            <input type="text" class="block w-full pl-28 pr-4 py-4 border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50" placeholder="namaanda">
                         </div>
                        <button class="px-8 py-4 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg hover:shadow-emerald-500/20 whitespace-nowrap">
                            Buat Link
                        </button>
                    </div>
                     <p class="mt-4 text-sm text-gray-500"><i class="bi bi-check-circle text-emerald-500 mr-1"></i> Gratis selamanya. Tidak perlu kartu kredit.</p>
                </div>

                <div class="relative flex justify-center lg:justify-end">
                    <!-- Decor Blobs -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-r from-emerald-200 to-teal-200 rounded-full blur-[100px] opacity-30 animate-pulse"></div>

                    <!-- Phone Mockup -->
                    <div class="relative w-[300px] h-[600px] bg-gray-900 rounded-[3rem] border-8 border-gray-800 shadow-2xl overflow-hidden transform rotate-3 hover:rotate-0 transition-all duration-500">
                         <!-- Notch -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-800 rounded-b-2xl z-20"></div>
                        
                        <!-- Screen Content -->
                        <div class="w-full h-full bg-gray-50 overflow-y-auto no-scrollbar pt-12 px-4 pb-6">
                            <!-- Profile Header -->
                            <div class="flex flex-col items-center mb-6">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-purple-400 to-pink-500 p-1 mb-3">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Profile" class="w-full h-full rounded-full object-cover border-2 border-white">
                                </div>
                                <h3 class="font-bold text-gray-900 text-lg">Sarah Jenkins</h3>
                                <p class="text-sm text-gray-500">Digital Creator & Traveller</p>
                            </div>

                            <!-- Social Icons -->
                            <div class="flex justify-center gap-4 mb-8">
                                <a href="#" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:text-pink-500 transition-colors"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:text-blue-500 transition-colors"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:text-red-500 transition-colors"><i class="bi bi-youtube"></i></a>
                            </div>

                            <!-- Links -->
                            <div class="space-y-3">
                                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-between group cursor-pointer hover:border-emerald-500 hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center"><i class="bi bi-youtube text-xl"></i></div>
                                        <span class="font-medium text-gray-700">Video Terbaru</span>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400 group-hover:text-emerald-500"></i>
                                </div>
                                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-between group cursor-pointer hover:border-emerald-500 hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center"><i class="bi bi-cart text-xl"></i></div>
                                        <span class="font-medium text-gray-700">Toko Online Saya</span>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400 group-hover:text-emerald-500"></i>
                                </div>
                                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-between group cursor-pointer hover:border-emerald-500 hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-500 flex items-center justify-center"><i class="bi bi-whatsapp text-xl"></i></div>
                                        <span class="font-medium text-gray-700">Konsultasi Gratis</span>
                                    </div>
                                    <i class="bi bi-chevron-right text-gray-400 group-hover:text-emerald-500"></i>
                                </div>
                                <div class="p-4 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white font-bold cursor-pointer hover:opacity-90 transition-opacity mt-4">
                                    Join Newsletter
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20">
          <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900">Lebih Dari Sekadar Link</h2>
          <p class="text-gray-600 text-lg">Dilengkapi dengan fitur-fitur canggih untuk memaksimalkan kehadiran digital Anda.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="feature in features" :key="feature.title" 
              class="group p-8 rounded-3xl bg-white border border-gray-100 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-emerald-500/5">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
              <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path :d="feature.icon" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4 text-gray-900">{{ feature.title }}</h3>
            <p class="text-gray-600 leading-relaxed">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-24 bg-white relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
          <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900">Cara Kerja</h2>
          <p class="text-gray-600 text-lg">Hanya butuh 3 langkah mudah untuk mengoptimalkan link bio Anda.</p>
        </div>

        <div class="relative">
          <!-- Connector Line (Desktop) -->
          <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2 z-0"></div>
          
          <div class="grid md:grid-cols-3 gap-12 relative z-10">
            <div v-for="(step, index) in steps" :key="step.title" class="text-center group">
              <div class="w-20 h-20 rounded-full bg-white border-4 border-gray-50 shadow-xl flex items-center justify-center mx-auto mb-8 group-hover:border-emerald-500 transition-all duration-500">
                <i :class="[step.icon, 'text-3xl text-emerald-600']"></i>
              </div>
              <h3 class="text-xl font-bold mb-4 text-gray-900">{{ index + 1 }}. {{ step.title }}</h3>
              <p class="text-gray-600">{{ step.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-24 bg-gray-50 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="relative">
             <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-3xl transform rotate-3 scale-105 opacity-20 blur-lg"></div>
             <!-- Ganti placeholder dengan gambar yang lebih relevan jika ada -->
             <div class="relative rounded-3xl shadow-2xl border-4 border-white transform hover:-rotate-1 transition-transform duration-500 w-full h-[500px] bg-gray-200 flex items-center justify-center">
                 <span class="text-gray-400">Dashboard Preview Image</span>
             </div>
          </div>
          <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-gray-200 text-emerald-600 text-sm font-medium mb-6">
              <i class="bi bi-stars"></i> Kenapa Aksibio?
            </div>
            <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900">Solusi Cerdas untuk Pertumbuhan Digital</h2>
            <p class="text-gray-600 text-lg mb-8">Tidak perlu pusing dengan teknis website yang rumit. Fokus saja pada konten dan bisnis Anda.</p>
            
            <div class="grid sm:grid-cols-2 gap-6">
              <div v-for="benefit in benefits" :key="benefit.title" class="bg-white p-6 rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4">
                  <i :class="benefit.icon"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ benefit.title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ benefit.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-white relative">
      <!-- Decor -->
      <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
          <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>
          <div class="absolute top-1/2 -left-24 w-72 h-72 bg-teal-50 rounded-full blur-3xl opacity-50"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900">Apa Kata Mereka?</h2>
          <p class="text-gray-600 text-lg">Bergabunglah dengan ribuan pengguna bahagia lainnya.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="testimoni in testimonials" :key="testimoni.name" class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-1 text-yellow-400 mb-6">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <p class="text-gray-700 mb-8 leading-relaxed">"{{ testimoni.content }}"</p>
            <div class="flex items-center gap-4 border-t border-gray-50 pt-6">
              <img :src="testimoni.image" :alt="testimoni.name" class="w-12 h-12 rounded-full object-cover ring-2 ring-emerald-100">
              <div>
                <div class="font-bold text-gray-900">{{ testimoni.name }}</div>
                <div class="text-sm text-emerald-600 font-medium">{{ testimoni.role }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- App Preview / Benefit Alternating -->
    <section class="py-24 bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl lg:text-5xl font-bold mb-6">Kelola Semuanya dari HP</h2>
                    <p class="text-gray-400 text-lg mb-8">Dashboard mobile-friendly kami memungkinkan Anda mengupdate konten, mengecek statistik, dan mengatur tampilan di mana saja dan kapan saja.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i class="bi bi-check2-circle text-emerald-400 text-xl"></i>
                            <span class="text-gray-300">Tampilan responsif di semua device</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-check2-circle text-emerald-400 text-xl"></i>
                            <span class="text-gray-300">Fast loading & SEO friendly</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-check2-circle text-emerald-400 text-xl"></i>
                            <span class="text-gray-300">Integrasi 50+ platform sosial media</span>
                        </li>
                    </ul>
                </div>
                 <div class="order-1 lg:order-2 flex justify-center">
                    <div class="relative w-72 h-[500px] bg-gray-800 rounded-[3rem] border-8 border-gray-700 shadow-2xl overflow-hidden">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-700 rounded-b-xl z-20"></div>
                        <!-- Mockup Content -->
                        <div class="h-full w-full bg-white overflow-y-auto pt-10 px-4 pb-4 no-scrollbar">
                           <div class="flex flex-col items-center">
                               <div class="w-20 h-20 rounded-full bg-emerald-100 mb-3"></div>
                               <div class="w-32 h-4 bg-gray-200 rounded mb-2"></div>
                               <div class="w-48 h-3 bg-gray-100 rounded mb-6"></div>
                               
                               <div class="w-full space-y-3">
                                   <div class="h-12 w-full bg-emerald-500 rounded-xl"></div>
                                   <div class="h-12 w-full bg-gray-100 rounded-xl"></div>
                                   <div class="h-12 w-full bg-gray-100 rounded-xl"></div>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-900">Pertanyaan Umum</h2>
                <p class="text-gray-600">Jawaban untuk pertanyaan yang sering diajukan.</p>
            </div>
            
            <div class="space-y-4">
                <div v-for="(faq, index) in faqs" :key="index" class="border border-gray-200 rounded-xl p-6 hover:border-emerald-300 transition-colors bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ faq.question }}</h3>
                    <p class="text-gray-600">{{ faq.answer }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="harga" class="py-24 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
          <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-gray-900">Pilih Paket Anda</h2>
          <p class="text-gray-600 text-lg">Investasi kecil untuk branding yang jauh lebih profesional.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <div v-for="plan in pricingPlans" :key="plan.name" 
               :class="[
                 'p-10 rounded-[2.5rem] transition-all duration-300 transform hover:-translate-y-2',
                 plan.highlighted ? 'bg-gray-900 text-white shadow-2xl scale-105 z-10' : 'bg-white text-gray-900 border border-gray-100'
               ]">
            <div class="mb-8">
              <h3 class="text-2xl font-bold mb-2">{{ plan.name }}</h3>
              <p :class="[plan.highlighted ? 'text-gray-400' : 'text-gray-500']">{{ plan.description }}</p>
            </div>
            
            <div class="mb-8 flex items-baseline">
              <span class="text-lg font-medium">Rp</span>
              <span class="text-5xl font-bold mx-1">{{ plan.price }}</span>
              <span :class="[plan.highlighted ? 'text-gray-400' : 'text-gray-500']">/bulan</span>
            </div>

            <ul class="space-y-4 mb-10">
              <li v-for="feature in plan.features" :key="feature" class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-500"></i>
                <span :class="[plan.highlighted ? 'text-gray-300' : 'text-gray-600']">{{ feature }}</span>
              </li>
            </ul>

            <button :class="[
              'w-full py-4 rounded-full font-bold transition-all',
              plan.highlighted ? 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/25' : 'bg-gray-100 hover:bg-gray-200 text-gray-900'
            ]">
              {{ plan.buttonText }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-24 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="relative rounded-[3rem] overflow-hidden bg-emerald-600 py-20 px-8 text-center shadow-2xl shadow-emerald-700/20">
          <!-- Abstract Background Shape -->
          <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
          <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-400 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2 opacity-50"></div>
          
          <div class="relative z-10 max-w-3xl mx-auto">
            <h2 class="text-3xl lg:text-6xl font-bold text-white mb-8">Siap Membangun Link Bio Idaman?</h2>
            <p class="text-emerald-50 text-xl mb-12 opacity-90 leading-relaxed">
              Bergabunglah dengan ribuan kreator lainnya dan buat halaman biolink Anda sendiri hari ini. Tanpa kartu kredit, daftar gratis selamanya.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
              <button @click="router.push('/register')" class="w-full sm:w-auto px-10 py-5 rounded-full bg-white text-emerald-600 font-bold text-lg hover:bg-gray-50 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                Daftar Sekarang
              </button>
              <button @click="router.push('/contact')" class="w-full sm:w-auto px-10 py-5 rounded-full bg-emerald-700/30 border border-white/20 text-white font-bold text-lg hover:bg-emerald-700/50 transition-all backdrop-blur-sm">
                Hubungi Kami
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <!-- Footer -->
    <Footer />
  </div>
</template>

<style scoped>
/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
@keyframes float-delayed {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}
.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
}
.animate-gradient {
    background-size: 200% 200%;
    animation: gradient-flow 3s ease infinite;
}
@keyframes gradient-flow {
    0% { background-position: 0% 50% }
    50% { background-position: 100% 50% }
    100% { background-position: 0% 50% }
}
</style>
