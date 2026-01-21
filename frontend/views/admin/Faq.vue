<template>
  <div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-900">Manajemen FAQ</h1>
      <button @click="openModal()" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2 shadow-lg shadow-emerald-600/20">
        <i class="bi bi-plus-lg"></i>
        Tambah FAQ
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-4">
      <div class="flex-1 relative">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input v-model="searchQuery" type="text" placeholder="Cari pertanyaan..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
      </div>
      <select v-model="filterCategory" class="px-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
        <option value="">Semua Kategori</option>
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>

    <!-- FAQ List -->
    <div v-if="isLoading" class="py-12 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mx-auto"></div>
    </div>

    <div v-else class="space-y-4">
      <div v-for="faq in filteredFaqs" :key="faq.id" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group hover:border-emerald-200 transition-all">
        <div class="p-6">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
              <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider mb-2 inline-block">
                {{ faq.category }}
              </span>
              <h3 class="font-bold text-gray-900 text-lg leading-snug">{{ faq.question }}</h3>
              <p class="mt-2 text-gray-600 text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
            <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button @click="openModal(faq)" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors" title="Edit"><i class="bi bi-pencil-square"></i></button>
              <button @click="handleDelete(faq.id)" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus"><i class="bi bi-trash"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="filteredFaqs.length === 0" class="py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
        Belum ada FAQ yang sesuai.
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">{{ form.id ? 'Edit FAQ' : 'Tambah FAQ' }}</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
            </div>
            <form @submit.prevent="handleSubmit" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <input v-model="form.category" type="text" required placeholder="Contoh: Umum, Akun, Fitur" class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                    <input v-model="form.question" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                    <textarea v-model="form.answer" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
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
import { ref, reactive, onMounted, computed } from 'vue'
import { useAdminFaqs } from '@/composables/useAdminFaqs'

const { faqs, isLoading, fetchFaqs, saveFaq, deleteFaq } = useAdminFaqs()

const searchQuery = ref('')
const filterCategory = ref('')
const showModal = ref(false)
const form = reactive({ id: null, question: '', answer: '', category: '', status: 'active' })

onMounted(() => fetchFaqs())

const categories = computed(() => {
    const cats = faqs.value.map(f => f.category)
    return [...new Set(cats)]
})

const filteredFaqs = computed(() => {
    return faqs.value.filter(f => {
        const matchesSearch = f.question.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                              f.answer.toLowerCase().includes(searchQuery.value.toLowerCase())
        const matchesCat = filterCategory.value ? f.category === filterCategory.value : true
        return matchesSearch && matchesCat
    })
})

const openModal = (faq = null) => {
    if (faq) {
        form.id = faq.id
        form.question = faq.question
        form.answer = faq.answer
        form.category = faq.category
        form.status = faq.status
    } else {
        form.id = null
        form.question = ''
        form.answer = ''
        form.category = ''
        form.status = 'active'
    }
    showModal.value = true
}

const handleSubmit = async () => {
    try {
        await saveFaq({ ...form })
        showModal.value = false
    } catch (e) {
        alert('Gagal menyimpan data.')
    }
}

const handleDelete = async (id) => {
    if (confirm('Hapus FAQ ini?')) {
        await deleteFaq(id)
    }
}
</script>