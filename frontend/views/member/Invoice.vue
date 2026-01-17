<template>
  <div class="max-w-3xl mx-auto py-8 animate-fade-in px-4">
    <!-- Header Invoice -->
    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm mb-8 relative overflow-hidden">
      <div class="relative z-10 flex flex-col md:flex-row justify-between gap-6">
        <div>
          <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Invoice #INV-{{ invoiceId }}</p>
          <h1 class="text-2xl font-black text-gray-900">Menunggu Pembayaran</h1>
          <p class="text-sm text-gray-500 mt-1">Segera selesaikan pembayaran sebelum <span class="font-bold text-gray-700">24 jam</span></p>
        </div>
        <div class="text-left md:text-right">
          <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
          <h2 class="text-3xl font-black text-emerald-600">Rp{{ formatNumber(totalAmount) }}</h2>
        </div>
      </div>
      <!-- Decoration -->
      <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full blur-2xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Left: Instructions -->
      <div class="space-y-6">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
          <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-bank2 text-emerald-600"></i>
            Tujuan Transfer
          </h3>
          <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-4">
            <div>
              <p class="text-[10px] text-gray-400 uppercase font-bold">Bank</p>
              <p class="font-bold text-gray-900">{{ paymentMethod.bank }}</p>
            </div>
            <div>
              <p class="text-[10px] text-gray-400 uppercase font-bold">Nomor Rekening</p>
              <div class="flex items-center justify-between">
                <p class="font-mono font-bold text-lg text-gray-900">{{ paymentMethod.accountNumber }}</p>
                <button @click="copyText(paymentMethod.accountNumber)" class="text-emerald-600 text-xs font-bold hover:underline">Salin</button>
              </div>
            </div>
            <div>
              <p class="text-[10px] text-gray-400 uppercase font-bold">Atas Nama</p>
              <p class="font-bold text-gray-900">{{ paymentMethod.accountName }}</p>
            </div>
          </div>
          
          <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-3">
            <i class="bi bi-exclamation-triangle-fill text-amber-500 text-lg"></i>
            <p class="text-xs text-amber-800 leading-relaxed">
              Pastikan nominal transfer sesuai hingga <span class="font-bold">3 digit terakhir</span> untuk mempercepat proses verifikasi otomatis.
            </p>
          </div>
        </div>
      </div>

      <!-- Right: Upload Proof -->
      <div class="space-y-6">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
          <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-cloud-upload text-emerald-600"></i>
            Konfirmasi Pembayaran
          </h3>
          
          <div class="space-y-4">
            <div v-if="!proofImage" class="relative">
              <input 
                type="file" 
                accept="image/*" 
                @change="handleFileUpload" 
                class="hidden" 
                ref="fileInput"
              >
              <button 
                @click="$refs.fileInput.click()"
                class="w-full py-12 border-2 border-dashed border-gray-200 rounded-2xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex flex-col items-center justify-center gap-3 text-gray-400 group"
              >
                <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                  <i class="bi bi-image text-2xl"></i>
                </div>
                <div class="text-center px-4">
                  <p class="text-sm font-bold text-gray-600">Klik untuk upload bukti</p>
                  <p class="text-xs mt-1">Format JPG, PNG atau PDF (Maks. 2MB)</p>
                </div>
              </button>
            </div>

            <!-- Preview Bukti -->
            <div v-else class="relative rounded-2xl overflow-hidden border-2 border-emerald-500">
              <img :src="proofImage" class="w-full h-auto" alt="Bukti Transfer">
              <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                <button @click="proofImage = null" class="bg-white text-red-600 px-4 py-2 rounded-xl font-bold text-sm">
                  Ganti Gambar
                </button>
              </div>
            </div>

            <button 
              @click="submitProof"
              :disabled="!proofImage"
              :class="[
                'w-full py-4 rounded-2xl font-bold transition-all flex items-center justify-center gap-2',
                proofImage ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20' : 'bg-gray-100 text-gray-400 cursor-not-allowed'
              ]"
            >
              Kirim Konfirmasi
              <i class="bi bi-send-fill"></i>
            </button>
          </div>
        </div>

        <button @click="$router.push('/member/dashboard')" class="w-full py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
          Kembali ke Dashboard
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const invoiceId = ref(Math.random().toString(36).substr(2, 9).toUpperCase())
const totalAmount = ref(0)
const proofImage = ref(null)

const paymentMethod = {
  bank: 'BCA (Bank Central Asia)',
  accountNumber: '8830 1234 567',
  accountName: 'PT. AKSIBIO INDONESIA'
}

onMounted(() => {
  // Get price from query params
  const price = parseInt(route.query.price) || 49000
  const unique = parseInt(route.query.unique) || 0
  totalAmount.value = price + unique
})

const formatNumber = (num) => {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

const copyText = (text) => {
  navigator.clipboard.writeText(text)
  alert('Nomor rekening berhasil disalin!')
}

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (!file) return

  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file maksimal 2MB')
    return
  }

  const reader = new FileReader()
  reader.onload = (e) => {
    proofImage.value = e.target.result
  }
  reader.readAsDataURL(file)
}

const submitProof = () => {
  alert('Bukti pembayaran berhasil dikirim! Kami akan melakukan verifikasi dalam maksimal 1x24 jam.')
  router.push('/member/bills')
}
</script>
