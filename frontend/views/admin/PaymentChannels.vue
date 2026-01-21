<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-900">Saluran Pembayaran</h1>
      <button @click="openModal()" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Tambah Rekening
      </button>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider">
            <th class="py-4 px-6">Bank</th>
            <th class="py-4 px-6">Nama Pemilik</th>
            <th class="py-4 px-6">No. Rekening</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-if="isLoading">
            <td colspan="5" class="py-8 text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto"></div></td>
          </tr>
          <tr v-for="ch in channels" :key="ch.id" class="group hover:bg-gray-50 transition-colors">
            <td class="py-4 px-6">
                <p class="font-bold text-gray-900 leading-none">{{ ch.bank_name }}</p>
                <p class="text-[10px] text-gray-400 font-mono mt-1 uppercase">{{ ch.bank_code }}</p>
            </td>
            <td class="py-4 px-6 font-medium text-gray-700">{{ ch.account_name }}</td>
            <td class="py-4 px-6 font-mono text-sm">{{ ch.account_number }}</td>
            <td class="py-4 px-6">
              <span :class="['px-2 py-1 rounded-lg text-[10px] font-bold uppercase', ch.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500']">
                {{ ch.status }}
              </span>
            </td>
            <td class="py-4 px-6 text-right">
              <div class="flex items-center justify-end gap-2">
                <button @click="openModal(ch)" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors"><i class="bi bi-pencil-fill"></i></button>
                <button @click="handleDelete(ch.id)" class="p-2 text-gray-400 hover:text-red-600 transition-colors"><i class="bi bi-trash-fill"></i></button>
              </div>
            </td>
          </tr>
          <tr v-if="!isLoading && channels.length === 0">
            <td colspan="5" class="py-8 text-center text-gray-400">Belum ada data saluran pembayaran.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">{{ form.id ? 'Edit Rekening' : 'Tambah Rekening' }}</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
            </div>
            <form @submit.prevent="handleSubmit" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank</label>
                    <select v-model="form.bank_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="" disabled>Pilih Bank</option>
                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{ bank.name }} ({{ bank.code }})</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik Rekening</label>
                    <input v-model="form.account_name" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                    <input v-model="form.account_number" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-6 py-2 text-gray-600 font-bold">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useAdminPaymentChannels } from '@/composables/useAdminPaymentChannels'
import { useAdminBanks } from '@/composables/useAdminBanks'

const { channels, isLoading, fetchChannels, saveChannel, deleteChannel } = useAdminPaymentChannels()
const { banks, fetchBanks } = useAdminBanks()

const showModal = ref(false)
const form = reactive({ id: null, bank_id: '', account_name: '', account_number: '', status: 'active' })

onMounted(() => {
    fetchChannels()
    fetchBanks() // Dibutuhkan untuk dropdown pilihan bank
})

const openModal = (ch = null) => {
    if (ch) {
        form.id = ch.id
        form.bank_id = ch.bank_id
        form.account_name = ch.account_name
        form.account_number = ch.account_number
        form.status = ch.status
    } else {
        form.id = null
        form.bank_id = ''
        form.account_name = ''
        form.account_number = ''
        form.status = 'active'
    }
    showModal.value = true
}

const handleSubmit = async () => {
    try {
        await saveChannel({ ...form })
        showModal.value = false
    } catch (e) {
        alert('Gagal menyimpan data.')
    }
}

const handleDelete = async (id) => {
    if (confirm('Hapus rekening ini?')) {
        await deleteChannel(id)
    }
}
</script>