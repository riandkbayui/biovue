<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen FAQ</h1>
        <p class="text-gray-500 mt-1">Kelola pertanyaan umum dan tutorial untuk member</p>
      </div>
      <Button variant="primary" @click="openModal()"><i class="bi bi-plus-lg mr-2"></i> Tambah FAQ</Button>
    </div>

    <Card>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="px-6 py-4">Pertanyaan</th>
              <th class="px-6 py-4">Kategori</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="(faq, index) in faqs" :key="index" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4">
                <div class="font-bold text-gray-900 text-sm mb-1">{{ faq.question }}</div>
                <div class="text-sm text-gray-500 line-clamp-2">{{ faq.answer }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <Badge variant="info">{{ faq.category }}</Badge>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <button @click="editFaq(index)" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="bi bi-pencil-square"></i></button>
                <button @click="deleteFaq(index)" class="text-red-600 hover:text-red-900"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Card>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal"></div>
      <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 animate-fade-in">
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ isEditing ? 'Edit FAQ' : 'Tambah FAQ Baru' }}</h3>
        
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Pertanyaan</label>
            <Input v-model="form.question" placeholder="Contoh: Bagaimana cara mengganti password?" />
          </div>
          
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Jawaban</label>
            <Textarea v-model="form.answer" rows="4" placeholder="Tulis jawaban lengkap di sini..." />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Kategori</label>
            <select v-model="form.category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
              <option>Umum</option>
              <option>Akun</option>
              <option>Pembayaran</option>
              <option>Teknis</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
          <Button variant="secondary" @click="closeModal">Batal</Button>
          <Button variant="primary" @click="saveFaq">Simpan</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import Card from '../../components/Card.vue';
import Button from '../../components/Button.vue';
import Badge from '../../components/Badge.vue';
import Input from '../../components/Input.vue';
import Textarea from '../../components/Textarea.vue';

const faqs = ref([
  { question: 'Bagaimana cara membuat halaman baru?', answer: 'Masuk ke dashboard, klik menu "My Pages", lalu tekan tombol "Buat Halaman".', category: 'Umum' },
  { question: 'Apakah saya bisa menggunakan domain sendiri?', answer: 'Ya, fitur custom domain tersedia untuk pengguna paket Pro dan Enterprise.', category: 'Teknis' },
  { question: 'Bagaimana metode pembayarannya?', answer: 'Kami menerima transfer bank, e-wallet (OVO, GoPay), dan kartu kredit.', category: 'Pembayaran' },
]);

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingIndex = ref(-1);

const form = reactive({
  question: '',
  answer: '',
  category: 'Umum'
});

const openModal = () => {
  isEditing.value = false;
  form.question = '';
  form.answer = '';
  form.category = 'Umum';
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const editFaq = (index) => {
  isEditing.value = true;
  editingIndex.value = index;
  const item = faqs.value[index];
  form.question = item.question;
  form.answer = item.answer;
  form.category = item.category;
  isModalOpen.value = true;
};

const saveFaq = () => {
  if (isEditing.value) {
    faqs.value[editingIndex.value] = { ...form };
  } else {
    faqs.value.push({ ...form });
  }
  closeModal();
};

const deleteFaq = (index) => {
  if (confirm('Yakin ingin menghapus FAQ ini?')) {
    faqs.value.splice(index, 1);
  }
};
</script>
