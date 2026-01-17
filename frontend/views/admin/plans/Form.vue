<template>
  <div class="max-w-3xl mx-auto animate-fade-in">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ isEditing ? 'Edit Paket' : 'Buat Paket Baru' }}</h1>
        <p class="text-gray-500 mt-1">Isi informasi detail paket di bawah ini</p>
      </div>
      <router-link to="/admin/plans" class="text-gray-500 hover:text-gray-700">
        <i class="bi bi-arrow-left mr-1"></i> Kembali
      </router-link>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
      <div class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
          <Input v-model="form.name" placeholder="Contoh: Pro" />
        </div>
        <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Tagihan</label>
           <Input v-model="form.type" placeholder="Contoh: Tagihan Bulanan" />
        </div>
        <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
           <Input v-model="form.price" placeholder="Contoh: Rp 49.000" />
        </div>
        <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
           <Textarea v-model="form.description" placeholder="Deskripsi singkat paket..." />
        </div>
        <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">Fitur (Satu per baris)</label>
           <Textarea v-model="form.featuresString" placeholder="Fitur 1
Fitur 2
Fitur 3" rows="8" class="h-48" />
        </div>

        <div class="pt-6 flex justify-end gap-3">
          <router-link to="/admin/plans">
             <Button variant="secondary">Batal</Button>
          </router-link>
          <Button variant="primary" @click="savePlan">Simpan Paket</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Button from '../../../components/Button.vue';
import Input from '../../../components/Input.vue';
import Textarea from '../../../components/Textarea.vue';

const route = useRoute();
const router = useRouter();
const isEditing = computed(() => route.name === 'admin-plans-edit');

// Mock data (in a real app, fetch from API/Store)
const mockPlans = [
  {
    id: 1,
    name: 'Gratis',
    type: 'Tagihan Bulanan',
    price: 'Rp 0',
    description: 'Cocok untuk pemula dan penggunaan pribadi.',
    features: ['1 Halaman Bio', 'Tautan Tak Terbatas', 'Tema Dasar', 'Analitik Standar']
  },
  {
    id: 2,
    name: 'Pro',
    type: 'Tagihan Bulanan',
    price: 'Rp 49.000',
    description: 'Untuk profesional dan merek yang berkembang.',
    features: ['Halaman Tak Terbatas', 'Domain Kustom', 'Tema Premium', 'Analitik Lanjutan', 'Hapus Branding']
  }
];

const form = reactive({
  name: '',
  type: '',
  price: '',
  description: '',
  featuresString: ''
});

onMounted(() => {
  if (isEditing.value) {
    const id = parseInt(route.params.id);
    const plan = mockPlans.find(p => p.id === id);
    if (plan) {
      form.name = plan.name;
      form.type = plan.type;
      form.price = plan.price;
      form.description = plan.description;
      form.featuresString = plan.features.join('\n');
    }
  } else {
     // Defaults for new plan
     form.type = 'Tagihan Bulanan';
  }
});

const savePlan = () => {
  // Logic to save (mock)
  console.log('Saving plan:', { ...form, features: form.featuresString.split('\n').filter(f => f.trim()) });
  
  // Navigate back
  router.push('/admin/plans');
};
</script>
