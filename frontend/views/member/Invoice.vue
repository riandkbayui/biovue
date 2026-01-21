<template>
  <div class="max-w-3xl mx-auto animate-fade-in py-8 space-y-8">
    <div v-if="isLoading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
    </div>

    <template v-else-if="transaction">
        <!-- Header -->
        <div class="text-center">
            <div :class="['inline-flex items-center gap-2 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4', 
                         transaction.status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700']">
                {{ transaction.status }}
            </div>
            <h1 class="text-3xl font-black text-gray-900">Detail Tagihan</h1>
            <p class="text-gray-500 mt-2">ID Transaksi: #{{ transaction.id }}</p>
        </div>

        <!-- Amount Card -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden text-center">
            <div class="p-8 space-y-2">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Transfer</p>
                <h2 class="text-5xl font-black text-emerald-600">{{ formatCurrency(transaction.amount) }}</h2>
                <p class="text-[10px] text-amber-600 font-bold bg-amber-50 inline-block px-3 py-1 rounded-full mt-2">
                    PENTING: Transfer harus tepat hingga 3 digit terakhir agar sistem dapat mendeteksi otomatis.
                </p>
            </div>
            <div class="bg-gray-50 p-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">Paket: <span class="font-bold text-gray-900">{{ transaction.plan_name }}</span></p>
            </div>
        </div>

        <!-- Bank Details -->
        <div v-if="transaction.status === 'pending'" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-6">
            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                <i class="bi bi-bank text-emerald-600"></i>
                Rekening Tujuan
            </h3>
            <div class="space-y-4">
                <div v-for="ch in channels" :key="ch.id" class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">{{ ch.bank_name }} ({{ ch.bank_code }})</p>
                        <p class="text-lg font-black text-gray-900 font-mono">{{ ch.account_number }}</p>
                        <p class="text-xs text-gray-500">a.n {{ ch.account_name }}</p>
                    </div>
                    <button @click="copy(ch.account_number)" class="text-emerald-600 font-bold text-xs hover:underline">Salin</button>
                </div>
            </div>
        </div>

        <!-- Proof Upload -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-6">
            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                <i class="bi bi-file-earmark-check text-emerald-600"></i>
                Bukti Pembayaran
            </h3>
            
            <div v-if="transaction.payment_proof" class="space-y-4">
                <img :src="transaction.payment_proof" class="w-full h-auto rounded-2xl border-2 border-emerald-100 shadow-lg" alt="Bukti bayar" />
                <p v-if="transaction.status === 'pending'" class="text-center text-sm text-amber-600 font-medium">Bukti sudah terkirim. Menunggu konfirmasi admin.</p>
            </div>

            <div v-else-if="transaction.status === 'pending'" class="space-y-4 text-center">
                <input type="file" @change="handleUploadProof" class="hidden" ref="fileInput" accept="image/*" />
                <div v-if="isUploading" class="py-12 border-2 border-dashed border-emerald-200 rounded-3xl bg-emerald-50/50 flex flex-col items-center gap-3">
                    <div class="animate-spin h-8 w-8 border-4 border-emerald-600 border-t-transparent rounded-full"></div>
                    <p class="text-emerald-600 font-bold text-sm">Mengunggah bukti...</p>
                </div>
                <button v-else @click="$refs.fileInput.click()" class="w-full py-12 border-2 border-dashed border-gray-200 rounded-3xl hover:border-emerald-500 hover:bg-emerald-50 transition-all group">
                    <i class="bi bi-cloud-arrow-up text-4xl text-gray-300 group-hover:text-emerald-500 transition-colors"></i>
                    <p class="mt-4 text-gray-500 font-bold group-hover:text-emerald-600">Klik untuk upload bukti bayar</p>
                    <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">PNG, JPG (MAX 2MB)</p>
                </button>
            </div>
        </div>
    </template>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { usePayments } from '@/composables/usePayments'
import { useUpload } from '@/composables/useUpload'

const route = useRoute()
const { transaction, channels, fetchTransaction, fetchChannels, uploadPaymentProof, isLoading } = usePayments()
const { uploadImage, isUploading } = useUpload()

onMounted(async () => {
    const id = route.query.id
    if (id) {
        await fetchTransaction(id)
        await fetchChannels()
    }
})

const formatCurrency = (val) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(val)
}

const copy = (text) => {
    navigator.clipboard.writeText(text)
    alert('Disalin ke clipboard')
}

const handleUploadProof = async (e) => {
    const file = e.target.files[0]
    if (!file) return

    try {
        const result = await uploadImage(file, 'proofs')
        await uploadPaymentProof(transaction.value.id, result.url)
        // Refresh data
        await fetchTransaction(transaction.value.id)
        alert('Bukti berhasil diunggah!')
    } catch (err) {
        alert('Gagal mengupload bukti bayar.')
    }
}
</script>