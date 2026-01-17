<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Bank</h1>
        <p class="text-gray-500 mt-1">Kelola daftar bank yang didukung sistem</p>
      </div>
      <Button variant="primary" @click="openModal()">
        <i class="bi bi-plus-lg mr-2"></i> Tambah Bank
      </Button>
    </div>

    <Card>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="px-6 py-4">Nama Bank</th>
              <th class="px-6 py-4">Kode Bank</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="(bank, index) in banks" :key="index" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                    {{ bank.name.substring(0, 3).toUpperCase() }}
                  </div>
                  <span class="font-bold text-gray-900 text-sm">{{ bank.name }}</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <Badge variant="info">{{ bank.code }}</Badge>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <button @click="editBank(index)" class="text-indigo-600 hover:text-indigo-900 mr-3">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button @click="deleteBank(index)" class="text-red-600 hover:text-red-900">
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
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ isEditing ? 'Edit Bank' : 'Tambah Bank Baru' }}</h3>
        
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Nama Bank</label>
            <Input v-model="form.name" placeholder="Contoh: Bank Central Asia (BCA)" />
          </div>
          
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Kode Bank</label>
            <Input v-model="form.code" placeholder="Contoh: 014" />
          </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
          <Button variant="secondary" @click="closeModal">Batal</Button>
          <Button variant="primary" @click="saveBank">Simpan</Button>
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

const banks = ref([
  { name: 'Bank Central Asia (BCA)', code: '014' },
  { name: 'Bank Mandiri', code: '008' },
  { name: 'Bank Negara Indonesia (BNI)', code: '009' },
  { name: 'Bank Rakyat Indonesia (BRI)', code: '002' },
]);

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingIndex = ref(-1);

const form = reactive({
  name: '',
  code: ''
});

const openModal = () => {
  isEditing.value = false;
  form.name = '';
  form.code = '';
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const editBank = (index) => {
  isEditing.value = true;
  editingIndex.value = index;
  const item = banks.value[index];
  form.name = item.name;
  form.code = item.code;
  isModalOpen.value = true;
};

const saveBank = () => {
  if (isEditing.value) {
    banks.value[editingIndex.value] = { ...form };
  } else {
    banks.value.push({ ...form });
  }
  closeModal();
};

const deleteBank = (index) => {
  if (confirm('Yakin ingin menghapus bank ini?')) {
    banks.value.splice(index, 1);
  }
};
</script>
