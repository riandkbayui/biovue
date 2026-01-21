<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-900">Manajemen Paket</h1>
      <router-link to="/admin/plans/create" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Tambah Paket
      </router-link>
    </div>

    <div v-if="isLoading" class="py-12 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mx-auto"></div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="p in plans" :key="p.id" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-xl transition-all">
        <div class="p-6 flex-1">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold text-gray-900">{{ p.name }}</h3>
            <span :class="['px-2 py-1 rounded-lg text-[10px] font-bold uppercase', p.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500']">
                {{ p.status }}
            </span>
          </div>
          
          <div class="mb-6">
            <span class="text-3xl font-black text-emerald-600">{{ formatCurrency(p.price) }}</span>
            <span class="text-gray-400 text-sm ml-1">/ bulan</span>
          </div>

          <div class="space-y-3">
            <div v-for="(feat, idx) in p.features_list" :key="idx" class="flex items-start gap-2 text-sm text-gray-600">
                <i class="bi bi-check2-circle text-emerald-500 mt-0.5"></i>
                <span>{{ feat }}</span>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
            <router-link :to="`/admin/plans/${p.id}/edit`" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-emerald-600 transition-colors">
                <i class="bi bi-pencil-square mr-1"></i> Edit
            </router-link>
            <button @click="handleDelete(p.id)" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-red-600 transition-colors">
                <i class="bi bi-trash mr-1"></i> Hapus
            </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAdminPlans } from '@/composables/useAdminPlans'

const { plans, isLoading, fetchPlans, deletePlan } = useAdminPlans()

onMounted(() => fetchPlans())

const formatCurrency = (val) => {
    if (val == 0) return 'Gratis'
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val)
}

const handleDelete = async (id) => {
    if (confirm('Hapus paket ini?')) {
        await deletePlan(id)
    }
}
</script>
