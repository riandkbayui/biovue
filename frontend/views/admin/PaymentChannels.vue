<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Saluran Pembayaran</h1>
        <p class="text-gray-500 mt-1">Kelola rekening tujuan pembayaran untuk langganan</p>
      </div>
      <Button variant="primary" @click="openModal()">
        <i class="bi bi-plus-lg mr-2"></i> Tambah Saluran
      </Button>
    </div>

    <Card>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="px-6 py-4">Bank</th>
              <th class="px-6 py-4">Atas Nama</th>
              <th class="px-6 py-4">Nomor Rekening</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="(channel, index) in channels" :key="index" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 text-sm">
                {{ channel.bankName }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ channel.accountName }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                {{ channel.accountNumber }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <Badge :variant="channel.active ? 'success' : 'secondary'">
                  {{ channel.active ? 'Aktif' : 'Nonaktif' }}
                </Badge>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <button @click="editChannel(index)" class="text-indigo-600 hover:text-indigo-900 mr-3">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button @click="deleteChannel(index)" class="text-red-600 hover:text-red-900">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Card>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal"></div>
      <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 animate-fade-in">
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ isEditing ? 'Edit Saluran' : 'Tambah Saluran Baru' }}</h3>
        
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Pilih Bank</label>
            <select v-model="form.bankName" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
              <option disabled value="">Pilih Bank...</option>
              <option v-for="bank in availableBanks" :key="bank" :value="bank">{{ bank }}</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Atas Nama</label>
            <Input v-model="form.accountName" placeholder="Contoh: PT. Aksibio Indonesia" />
          </div>
          
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Nomor Rekening</label>
            <Input v-model="form.accountNumber" placeholder="Contoh: 1234567890" />
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" v-model="form.active" id="active" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="active" class="text-sm font-medium text-gray-700 cursor-pointer">Aktifkan Saluran Ini</label>
          </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
          <Button variant="secondary" @click="closeModal">Batal</Button>
          <Button variant="primary" @click="saveChannel">Simpan</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import Card from '@/components/Card.vue';
import Button from '@/components/Button.vue';
import Badge from '@/components/Badge.vue';
import Input from '@/components/Input.vue';

const availableBanks = ['BCA', 'Mandiri', 'BNI', 'BRI', 'Permata', 'CIMB Niaga'];

const channels = ref([
  { bankName: 'BCA', accountName: 'PT. Aksibio Indonesia', accountNumber: '1234567890', active: true },
  { bankName: 'Mandiri', accountName: 'PT. Aksibio Indonesia', accountNumber: '0987654321', active: true },
]);

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingIndex = ref(-1);

const form = reactive({
  bankName: '',
  accountName: '',
  accountNumber: '',
  active: true
});

const openModal = () => {
  isEditing.value = false;
  form.bankName = '';
  form.accountName = '';
  form.accountNumber = '';
  form.active = true;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const editChannel = (index) => {
  isEditing.value = true;
  editingIndex.value = index;
  const item = channels.value[index];
  form.bankName = item.bankName;
  form.accountName = item.accountName;
  form.accountNumber = item.accountNumber;
  form.active = item.active;
  isModalOpen.value = true;
};

const saveChannel = () => {
  if (isEditing.value) {
    channels.value[editingIndex.value] = { ...form };
  } else {
    channels.value.push({ ...form });
  }
  closeModal();
};

const deleteChannel = (index) => {
  if (confirm('Yakin ingin menghapus saluran pembayaran ini?')) {
    channels.value.splice(index, 1);
  }
};
</script>
