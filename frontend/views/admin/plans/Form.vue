<template>
  <div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
      <router-link to="/admin/plans" class="text-gray-500 hover:text-emerald-600 flex items-center gap-2 mb-4 transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Paket
      </router-link>
      <h2 class="text-2xl font-bold text-gray-900">{{ isEdit ? 'Edit Paket' : 'Tambah Paket Baru' }}</h2>
    </div>

    <div v-if="isLoadingFetch" class="py-12 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mx-auto"></div>
    </div>

    <div v-else class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                <input v-model="form.name" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (IDR)</label>
                <input v-model="form.price" type="number" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea v-model="form.description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center justify-between">
                <span>Fitur-fitur</span>
                <button type="button" @click="addFeature" class="text-xs font-bold text-emerald-600 hover:underline">+ Tambah Fitur</button>
            </label>
            <div class="space-y-2">
                <div v-for="(feat, idx) in form.features" :key="idx" class="flex items-center gap-2">
                    <div class="flex-1 relative">
                        <i class="bi bi-check2 absolute left-3 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                        <input v-model="form.features[idx]" type="text" placeholder="Masukkan nama fitur" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <button type="button" @click="removeFeature(idx)" class="p-2 text-gray-400 hover:text-red-600"><i class="bi bi-x-circle"></i></button>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" @click="router.back()" class="px-6 py-2 text-gray-600 font-bold">Batal</button>
            <button type="submit" :disabled="isLoading" class="px-8 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2">
                <span v-if="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                {{ isEdit ? 'Simpan Perubahan' : 'Buat Paket' }}
            </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAdminPlans } from '@/composables/useAdminPlans'

const router = useRouter()
const route = useRoute()
const { fetchPlan, savePlan, isLoading } = useAdminPlans()

const isEdit = computed(() => !!route.params.id)
const isLoadingFetch = ref(false)

const form = reactive({
    name: '',
    price: 0,
    description: '',
    features: [''],
    status: 'active'
})

onMounted(async () => {
    if (isEdit.value) {
        isLoadingFetch.value = true
        try {
            const data = await fetchPlan(route.params.id)
            form.name = data.name
            form.price = data.price
            form.description = data.description
            form.features = data.features_list.length > 0 ? data.features_list : ['']
            form.status = data.status
        } catch (e) {
            router.push('/admin/plans')
        } finally {
            isLoadingFetch.value = false
        }
    }
})

const addFeature = () => form.features.push('')
const removeFeature = (idx) => form.features.splice(idx, 1)

const handleSubmit = async () => {
    try {
        await savePlan(route.params.id, {
            ...form,
            features: form.features.filter(f => f.trim() !== '')
        })
        router.push('/admin/plans')
    } catch (e) {
        alert('Gagal menyimpan paket.')
    }
}
</script>