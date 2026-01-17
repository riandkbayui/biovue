<template>
  <div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Transaksi</h1>
            <p class="text-gray-500 mt-1">Perbarui informasi transaksi dan status pembayaran</p>
        </div>
        <Button variant="secondary" @click="$router.push({ name: 'admin-transactions' })">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </Button>
    </div>

    <Card>
      <form @submit.prevent="saveTransaction" class="space-y-6">
        
        <!-- Read-only Info -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">ID Transaksi</span>
                <span class="font-mono text-sm font-semibold text-gray-700">{{ transactionId }}</span>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Pengguna</span>
                <span class="text-sm font-semibold text-gray-700">{{ form.user }}</span>
            </div>
            <div>
                 <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Tanggal</span>
                 <span class="text-sm font-semibold text-gray-700">{{ form.date }}</span>
            </div>
             <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Paket</span>
                <span class="text-sm font-semibold text-gray-700">{{ form.plan }}</span>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Jumlah</span>
                <span class="text-sm font-semibold text-gray-700">Rp {{ form.amount }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tujuan Pembayaran</h3>
            </div>
            
             <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bank</label>
                <div class="px-3 py-2 border border-gray-200 rounded-md bg-gray-50 text-gray-700">{{ form.bank }}</div>
            </div>
             <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                <div class="px-3 py-2 border border-gray-200 rounded-md bg-gray-50 text-gray-700 font-mono">{{ form.accountNumber }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Atas Nama</label>
                <div class="px-3 py-2 border border-gray-200 rounded-md bg-gray-50 text-gray-700">{{ form.accountName }}</div>
            </div>

            <div class="md:col-span-2 pt-4 border-t border-gray-100">
                 <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Bukti</h3>
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                <select v-model="form.status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white">
                    <option value="Sukses">Sukses</option>
                    <option value="Tertunda">Tertunda</option>
                    <option value="Gagal">Gagal</option>
                </select>
            </div>
             <div class="md:col-span-1">
                 <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer</label>
                 <Button type="button" variant="secondary" class="w-full justify-center" @click="showProofModal = true">
                    <i class="bi bi-file-earmark-image mr-2"></i> Lihat Bukti Pembayaran
                 </Button>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <Button type="button" variant="secondary" @click="$router.push({ name: 'admin-transactions' })">Batal</Button>
            <Button type="submit" variant="primary">
                <i class="bi bi-save mr-2"></i> Simpan Perubahan
            </Button>
        </div>
      </form>
    </Card>

    <!-- Modal Bukti Pembayaran -->
    <Modal v-model="showProofModal">
      <template #header>
        Bukti Pembayaran - {{ transactionId }}
      </template>
      
      <div class="flex justify-center bg-gray-100 rounded-lg p-2">
        <img src="https://via.placeholder.com/600x800?text=Bukti+Transfer" alt="Bukti Transfer" class="max-w-full max-h-[70vh] object-contain rounded shadow-sm">
      </div>

      <template #footer>
        <div class="flex justify-end">
          <Button variant="secondary" @click="showProofModal = false">Tutup</Button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Card from '../../../components/Card.vue';
import Button from '../../../components/Button.vue';
import Input from '../../../components/Input.vue';
import Modal from '../../../components/Modal.vue';

const route = useRoute();
const router = useRouter();
const transactionId = route.params.id;

const showProofModal = ref(false);

const form = reactive({
  user: '',
  plan: '',
  amount: '',
  status: 'Tertunda',
  date: '',
  bank: 'BCA',
  accountNumber: '1234567890',
  accountName: 'PT BioVue Indonesia'
});

onMounted(() => {
    // Mock data fetch
    console.log(`Fetching transaction ${transactionId}`);
    
    // Simulate fetching data based on ID (using the mock data from Transactions.vue)
    // In a real app, this would be an API call
    if (transactionId === 'TXN-882194') {
        form.user = 'Alex Johnson';
        form.plan = 'Pro Bulanan';
        form.amount = '49.000';
        form.status = 'Sukses';
        form.date = '16 Jan 2026';
    } else {
        // Fallback for other IDs just to show something
        form.user = 'Simulated User';
        form.plan = 'Pro Bulanan';
        form.amount = '49.000';
        form.status = 'Tertunda';
        form.date = '16 Jan 2026';
    }
});

const saveTransaction = () => {
  console.log('Saving transaction:', { id: transactionId, ...form });
  router.push({ name: 'admin-transactions' });
};
</script>