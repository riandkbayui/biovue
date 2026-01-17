<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Paket Langganan</h1>
        <p class="text-gray-500 mt-1">Konfigurasi harga dan fitur paket</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 justify-center">
      <div v-for="plan in plans" :key="plan.id" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 flex flex-col group hover:border-indigo-600 transition-all">
        <div class="mb-8 w-full flex flex-col">
          <Badge variant="light" class="mb-4 w-fit">{{ plan.type }}</Badge>
          <h3 class="text-2xl font-bold text-gray-900">{{ plan.name }}</h3>
          <div class="mt-4 flex items-baseline gap-1">
            <span class="text-3xl font-bold text-gray-900">{{ plan.price }}</span>
            <span class="text-gray-500">/ bulan</span>
          </div>
          <p class="text-gray-500 text-sm mt-4">{{ plan.description }}</p>
        </div>

        <ul class="space-y-4 mb-8 flex-1 w-full">
          <li v-for="feature in plan.features" :key="feature" class="flex items-center gap-3 text-sm text-gray-600">
            <i class="bi bi-check2-circle text-indigo-600"></i>
            {{ feature }}
          </li>
        </ul>

        <div class="pt-6 border-t border-gray-50 w-full">
          <router-link :to="`/admin/plans/${plan.id}/edit`" class="block w-full">
            <Button variant="secondary" class="w-full">Edit</Button>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from '../../../components/Button.vue';
import Badge from '../../../components/Badge.vue';

const plans = ref([
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
]);
</script>