<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="bg-white border-b border-gray-100 px-4 sm:px-6 py-4 sticky top-0 z-40">
        <div class="flex items-center justify-between gap-3">
          <div class="flex items-center gap-3 min-w-0 flex-1">
            <router-link to="/member/my-pages" class="p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors flex-shrink-0">
              <i class="bi bi-arrow-left text-xl"></i>
            </router-link>
            <div class="min-w-0 flex-1">
              <h1 class="text-lg sm:text-xl font-bold text-gray-900 truncate">{{ pageData.title || 'Halaman Baru' }}</h1>
              <p class="text-xs sm:text-sm text-gray-500 truncate">aksibio.com/{{ pageData.slug || 'your-link' }}</p>
            </div>
          </div>
          <div class="flex items-center gap-2 flex-shrink-0">
            <button @click="showPreview = !showPreview" class="p-2 sm:px-4 sm:py-2 rounded-xl bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
              <i class="bi bi-eye"></i>
              <span class="hidden sm:inline">Preview</span>
            </button>
            <button @click="savePage" class="px-4 py-2 sm:px-6 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2 shadow-lg shadow-emerald-600/20">
              <i class="bi bi-check-lg"></i>
              <span class="hidden sm:inline">Simpan</span>
            </button>
          </div>
        </div>
      </div>

      <div class="py-4 sm:p-6 space-y-6">
        <!-- Loading State -->
        <div v-if="isLoadingPage || isLoadingBlocks" class="bg-white rounded-2xl border border-gray-100 p-12 flex flex-col items-center justify-center gap-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
            <p class="text-gray-500 font-medium">Memuat editor...</p>
        </div>

        <template v-else>
            <!-- Page Settings -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6">
              <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-gear"></i>
                Pengaturan Halaman
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman</label>
                  <input v-model="pageData.title" type="text" placeholder="Masukkan judul halaman" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                  <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 hidden sm:inline">aksibio.com/</span>
                    <input v-model="pageData.slug" type="text" disabled class="flex-1 px-4 py-2 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl cursor-not-allowed">
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (SEO Meta)</label>
                  <textarea 
                    v-model="pageData.description" 
                    rows="3"
                    placeholder="Deskripsi singkat untuk SEO dan preview link"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
                  ></textarea>
                </div>
              </div>
            </div>

            <!-- Theme Settings -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6">
              <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-palette"></i>
                Tema & Gaya
              </h3>
              <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                  <!-- Background Color Picker -->
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center justify-between">
                      Warna Latar
                      <span class="text-[10px] font-mono text-gray-400 uppercase tracking-widest">{{ pageData.theme.backgroundColor }}</span>
                    </label>
                    <div class="flex flex-wrap gap-2 mb-3">
                      <button 
                        v-for="color in bgColors" 
                        :key="color.hex"
                        @click="pageData.theme.backgroundColor = color.hex"
                        :class="[
                          'w-8 h-8 rounded-full border-2 transition-all hover:scale-110 shadow-sm',
                          pageData.theme.backgroundColor === color.hex ? 'border-emerald-500 ring-2 ring-emerald-500/20 scale-110' : 'border-white'
                        ]"
                        :style="{ backgroundColor: color.hex }"
                        :title="color.name"
                      ></button>
                    </div>
                  </div>

                  <!-- Accent Color Picker -->
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center justify-between">
                      Warna Aksen
                      <span class="text-[10px] font-mono text-gray-400 uppercase tracking-widest">{{ pageData.theme.accentColor }}</span>
                    </label>
                    <div class="flex flex-wrap gap-2 mb-3">
                      <button 
                        v-for="color in accentColors" 
                        :key="color.hex"
                        @click="pageData.theme.accentColor = color.hex"
                        :class="[
                          'w-8 h-8 rounded-full border-2 transition-all hover:scale-110 shadow-sm',
                          pageData.theme.accentColor === color.hex ? 'border-emerald-500 ring-2 ring-emerald-500/20 scale-110' : 'border-white'
                        ]"
                        :style="{ backgroundColor: color.hex }"
                        :title="color.name"
                      ></button>
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Font Family</label>
                    <div class="relative">
                      <select v-model="pageData.theme.fontFamily" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all appearance-none bg-white shadow-sm">
                        <option value="sans">Sans Serif (Modern)</option>
                        <option value="serif">Serif (Klasik)</option>
                        <option value="mono">Monospace (Code)</option>
                      </select>
                      <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gaya Tombol</label>
                    <div class="relative">
                      <select v-model="pageData.theme.buttonStyle" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all appearance-none bg-white shadow-sm">
                        <option value="rounded">Rounded</option>
                        <option value="pill">Pill</option>
                        <option value="square">Square</option>
                        <option value="soft">Soft Shadow</option>
                      </select>
                      <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Background Image (Opsional)</label>
                  <div class="flex flex-col sm:flex-row items-center gap-4 p-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
                    <div v-if="pageData.theme.backgroundImage" class="w-full sm:w-32 h-20 rounded-xl overflow-hidden border border-gray-200 bg-white">
                      <img :src="pageData.theme.backgroundImage" class="w-full h-full object-cover">
                    </div>
                    <div v-else class="w-full sm:w-32 h-20 rounded-xl border border-gray-200 bg-white flex items-center justify-center text-gray-300">
                      <i class="bi bi-image text-2xl"></i>
                    </div>
                    <div class="flex-1 w-full">
                      <div class="flex items-center gap-2">
                        <label class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 cursor-pointer transition-all shadow-sm">
                          <i class="bi bi-cloud-arrow-up"></i>
                          <span>{{ isUploading ? 'Mengupload...' : 'Pilih Gambar' }}</span>
                          <input type="file" class="hidden" @change="handleBgImageUpload" accept="image/*" :disabled="isUploading">
                        </label>
                        <button v-if="pageData.theme.backgroundImage" @click="pageData.theme.backgroundImage = ''" class="p-2.5 rounded-xl text-red-600 bg-white border border-red-100 hover:bg-red-50 transition-colors shadow-sm">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                      <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6">
              <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-search"></i>
                Pengaturan SEO
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">SEO Preview Image</label>
                  <div class="flex flex-col sm:flex-row items-center gap-4 p-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
                    <div v-if="pageData.seo_image" class="w-full sm:w-32 h-20 rounded-xl overflow-hidden border border-gray-200 bg-white">
                      <img :src="pageData.seo_image" class="w-full h-full object-cover">
                    </div>
                    <div v-else class="w-full sm:w-32 h-20 rounded-xl border border-gray-200 bg-white flex items-center justify-center text-gray-300">
                      <i class="bi bi-share text-2xl"></i>
                    </div>
                    <div class="flex-1 w-full">
                      <div class="flex items-center gap-2">
                        <label class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 cursor-pointer transition-all shadow-sm">
                          <i class="bi bi-upload"></i>
                          <span>{{ isUploading ? 'Mengupload...' : 'Upload Preview' }}</span>
                          <input type="file" class="hidden" @change="handleSeoImageUpload" accept="image/*" :disabled="isUploading">
                        </label>
                        <button v-if="pageData.seo_image" @click="pageData.seo_image = ''" class="p-2.5 rounded-xl text-red-600 bg-white border border-red-100 hover:bg-red-50 transition-colors shadow-sm">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Blocks Area -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                  <i class="bi bi-grid-3x3-gap"></i>
                  Konten Halaman
                </h3>
                <span class="text-sm text-gray-500">{{ blocks.length }} block</span>
              </div>

              <div v-if="blocks.length === 0" class="text-center py-12 sm:py-20 border-2 border-dashed border-gray-200 rounded-2xl mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-3xl text-gray-300 mx-auto mb-4">
                  <i class="bi bi-plus-lg"></i>
                </div>
                <p class="text-gray-500 font-medium">Belum ada block</p>
                <p class="text-sm text-gray-400 mt-1">Klik tombol di bawah untuk menambahkan</p>
              </div>

              <draggable 
                v-model="blocks" 
                item-key="id"
                handle=".drag-handle"
                class="space-y-3 mb-4"
                @end="handleReorder"
              >
                <template #item="{ element, index }">
                  <div class="group relative bg-white rounded-2xl border-2 border-gray-200 hover:border-emerald-500 transition-all overflow-hidden">
                    <!-- Drag Handle Area -->
                    <div class="bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center justify-between text-gray-500 hover:bg-gray-100 transition-colors">
                      <div class="drag-handle cursor-move active:cursor-grabbing flex items-center gap-2 flex-1">
                        <i class="bi bi-grip-vertical text-lg"></i>
                        <span class="text-xs font-medium uppercase tracking-wider">{{ getBlockTypeName(element.type) }}</span>
                      </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-4">
                      <component 
                        :is="getBlockComponent(element.type)" 
                        :modelValue="blocks[index].content"
                        @update="handleUpdateBlock(element.id, $event)"
                      />
                    </div>

                    <!-- Actions Area -->
                    <div class="border-t border-gray-100 bg-gray-50 px-4 py-3 flex items-center justify-end gap-2">
                      <button 
                        @click="duplicateBlock(element.id)" 
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                      >
                        <i class="bi bi-files"></i>
                        <span>Duplikat</span>
                      </button>
                      <button 
                        @click="handleDeleteBlock(element.id)" 
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors"
                      >
                        <i class="bi bi-trash"></i>
                        <span>Hapus</span>
                      </button>
                    </div>
                  </div>
                </template>
              </draggable>

              <!-- Add Block Button -->
              <button 
                @click="showBlockModal = true"
                class="w-full py-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-emerald-500 hover:bg-emerald-50 text-gray-500 hover:text-emerald-600 font-bold transition-all flex items-center justify-center gap-2"
              >
                <i class="bi bi-plus-circle text-xl"></i>
                Tambah Block
              </button>
            </div>
        </template>
      </div>
    </div>

    <!-- Block Selection Modal -->
    <div 
      v-if="showBlockModal"
      @click="showBlockModal = false"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
    >
      <div 
        @click.stop
        class="bg-white rounded-t-3xl sm:rounded-3xl w-full sm:max-w-lg max-h-[80vh] overflow-hidden flex flex-col animate-slide-up"
      >
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
          <h3 class="text-xl font-bold text-gray-900">Pilih Block</h3>
          <button @click="showBlockModal = false" class="p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
          <div class="grid grid-cols-2 gap-3">
            <button 
              v-for="block in availableBlocks" 
              :key="block.type"
              @click="addBlockAndClose(block.type)"
              class="relative flex flex-col items-center gap-3 p-4 rounded-2xl border-2 border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 transition-all group"
            >
              <!-- Pro Badge -->
              <div v-if="block.isPro" class="absolute top-2 right-2 px-1.5 py-0.5 rounded-md bg-amber-100 text-[8px] font-black text-amber-700 uppercase tracking-tighter ring-1 ring-amber-200">
                PRO
              </div>

              <div :class="['w-14 h-14 rounded-xl flex items-center justify-center text-2xl', block.bgColor]">
                <i :class="['bi', block.icon]"></i>
              </div>
              <div class="text-center">
                <p class="font-bold text-sm text-gray-900">{{ block.name }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ block.description }}</p>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Preview Modal -->
    <div 
      v-if="showPreview"
      @click="showPreview = false"
      class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 flex items-center justify-center p-4"
    >
      <div 
        @click.stop
        class="bg-gray-900 rounded-[3rem] p-4 shadow-2xl w-full max-w-[380px] border-[8px] border-gray-800 animate-slide-up flex flex-col max-h-[90vh]"
      >
        <div class="flex items-center justify-between mb-4 px-4 flex-shrink-0">
          <h3 class="font-bold text-white flex items-center gap-2">
            <i class="bi bi-phone"></i>
            Preview Halaman
          </h3>
          <button @click="showPreview = false" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center border border-white/10">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        <div class="bg-white rounded-[2rem] overflow-x-hidden overflow-y-auto flex-1 scrollbar-hide">
          <PagePreview :pageData="pageData" :blocks="blocks" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import draggable from 'vuedraggable'
import { usePages } from '@/composables/usePages'
import { useBlocks } from '@/composables/useBlocks'
import { useUpload } from '@/composables/useUpload'

// Components
import TextBlock from '@/components/blocks/TextBlock.vue'
import ImageBlock from '@/components/blocks/ImageBlock.vue'
import LinkBlock from '@/components/blocks/LinkBlock.vue'
import VideoBlock from '@/components/blocks/VideoBlock.vue'
import SocialBlock from '@/components/blocks/SocialBlock.vue'
import DividerBlock from '@/components/blocks/DividerBlock.vue'
import SlideshowBlock from '@/components/blocks/SlideshowBlock.vue'
import ProfileBlock from '@/components/blocks/ProfileBlock.vue'
import AccordionBlock from '@/components/blocks/AccordionBlock.vue'
import CountdownBlock from '@/components/blocks/CountdownBlock.vue'
import AlertBlock from '@/components/blocks/AlertBlock.vue'
import GridBlock from '@/components/blocks/GridBlock.vue'
import PagePreview from '@/components/PagePreview.vue'

const router = useRouter()
const route = useRoute()
const pageId = route.params.id

// Composables
const { page, fetchPage, updatePage: apiUpdatePage, saveAll: apiSaveAll, isLoading: isLoadingPage } = usePages()
const { blocks, fetchBlocks, addBlock: apiAddBlock, updateBlock: apiUpdateBlock, deleteBlock: apiDeleteBlock, reorderBlocks: apiReorderBlocks, isLoading: isLoadingBlocks } = useBlocks()
const { uploadImage, isUploading } = useUpload()

const showPreview = ref(false)
const showBlockModal = ref(false)
const isSaving = ref(false)

const pageData = ref({
    title: '',
    slug: '',
    description: '',
    seo_image: '',
    theme: {
        backgroundColor: '#f9fafb',
        accentColor: '#10b981',
        textColor: '#1f2937',
        fontFamily: 'sans',
        buttonStyle: 'rounded'
    }
})

onMounted(async () => {
    try {
        const data = await fetchPage(pageId)
        if (data) {
            pageData.value = {
                ...data,
                theme: (() => {
                    try {
                        if (typeof data.theme === 'string' && data.theme.includes('{')) {
                            return JSON.parse(data.theme)
                        }
                        return (typeof data.theme === 'object' && data.theme !== null) ? data.theme : pageData.value.theme
                    } catch (e) {
                        console.error('Failed to parse theme JSON:', e)
                        return pageData.value.theme
                    }
                })()
            }
        }
        await fetchBlocks(pageId)
    } catch (err) {
        console.error('Error loading page:', err)
    }
})

// Hanya update urutan secara lokal, simpan akan dilakukan di savePage
const handleReorder = () => {
    // Draggable sudah mengupdate array blocks secara otomatis
}

const savePage = async () => {
  isSaving.value = true
  try {
    const payload = {
        title: pageData.value.title,
        description: pageData.value.description,
        seo_image: pageData.value.seo_image,
        theme: JSON.stringify(pageData.value.theme),
        blocks: JSON.stringify(blocks.value.map(b => ({
            id: b.id,
            type: b.type,
            content: b.content
        })))
    }

    await apiSaveAll(pageId, payload)
    alert('Semua perubahan berhasil disimpan!')
  } catch (err) {
    console.error(err)
    alert('Gagal menyimpan perubahan.')
  } finally {
    isSaving.value = false
  }
}

const addBlockAndClose = (type) => {
  const newBlock = {
      id: `new_${Date.now()}`,
      type: type,
      content: getDefaultBlockData(type)
  }
  blocks.value.push(newBlock)
  showBlockModal.value = false
}

const handleUpdateBlock = (id, event) => {
    const index = blocks.value.findIndex(b => b.id === id)
    if (index !== -1) {
        // Standarisasi: Selalu ambil properti 'data' jika ada, jika tidak gunakan seluruh event
        const newData = (event && typeof event === 'object' && event.data) ? event.data : event
        blocks.value[index].content = newData
    }
}

const duplicateBlock = (id) => {
    const original = blocks.value.find(b => b.id === id)
    if (original) {
        const index = blocks.value.indexOf(original)
        const copy = {
            ...JSON.parse(JSON.stringify(original)), // Deep copy
            id: `new_${Date.now()}` // New temporary ID
        }
        blocks.value.splice(index + 1, 0, copy)
    }
}

const handleDeleteBlock = (id) => {
    if (confirm('Hapus blok ini?')) {
        blocks.value = blocks.value.filter(b => b.id !== id)
    }
}

// Helpers...
const bgColors = [
  { name: 'Gray 50', hex: '#f9fafb' },
  { name: 'White', hex: '#ffffff' },
  { name: 'Slate 900', hex: '#0f172a' },
  { name: 'Gray 600', hex: '#4b5563' },
  { name: 'Zinc 400', hex: '#a1a1aa' },
  { name: 'Blue 600', hex: '#2563eb' },
  { name: 'Emerald 600', hex: '#059669' },
  { name: 'Rose 600', hex: '#e11d48' },
  { name: 'Amber 600', hex: '#d97706' },
  { name: 'Indigo 600', hex: '#4f46e5' },
]

const accentColors = [
  { name: 'Slate 900', hex: '#0f172a' },
  { name: 'Gray 600', hex: '#4b5563' },
  { name: 'Zinc 400', hex: '#a1a1aa' },
  { name: 'White', hex: '#ffffff' },
  { name: 'Blue 600', hex: '#2563eb' },
  { name: 'Emerald 600', hex: '#059669' },
  { name: 'Rose 600', hex: '#e11d48' },
  { name: 'Amber 600', hex: '#d97706' },
  { name: 'Indigo 600', hex: '#4f46e5' },
]

const availableBlocks = [
  { type: 'profile', name: 'Profile Header', description: 'Foto, Nama & Bio', icon: 'bi-person-badge', bgColor: 'bg-indigo-50 text-indigo-600', isPro: false },
  { type: 'text', name: 'Text', description: 'Teks atau paragraf', icon: 'bi-text-left', bgColor: 'bg-blue-50 text-blue-600', isPro: false },
  { type: 'link', name: 'Link Button', description: 'Tombol link', icon: 'bi-link-45deg', bgColor: 'bg-emerald-50 text-emerald-600', isPro: false },
  { type: 'image', name: 'Image', description: 'Gambar atau foto', icon: 'bi-image', bgColor: 'bg-purple-50 text-purple-600', isPro: false },
  { type: 'social', name: 'Social Links', description: 'Ikon sosial media', icon: 'bi-share', bgColor: 'bg-pink-50 text-pink-600', isPro: false },
  { type: 'divider', name: 'Divider', description: 'Garis pemisah', icon: 'bi-dash-lg', bgColor: 'bg-gray-50 text-gray-600', isPro: false },
  
  // Pro Blocks
  { type: 'grid', name: 'Grid Layout', description: '2 Kolom (Bebas Block)', icon: 'bi-grid-fill', bgColor: 'bg-cyan-50 text-cyan-600', isPro: true },
  { type: 'alert', name: 'Alert / Notice', description: 'Kotak pengumuman', icon: 'bi-megaphone-fill', bgColor: 'bg-yellow-50 text-yellow-600', isPro: true },
  { type: 'countdown', name: 'Countdown', description: 'Hitung mundur', icon: 'bi-stopwatch-fill', bgColor: 'bg-rose-50 text-rose-600', isPro: true },
  { type: 'video', name: 'Video', description: 'Embed video', icon: 'bi-play-circle', bgColor: 'bg-red-50 text-red-600', isPro: true },
  { type: 'slideshow', name: 'Slideshow', description: 'Galeri foto geser', icon: 'bi-images', bgColor: 'bg-orange-50 text-orange-600', isPro: true },
  { type: 'accordion', name: 'FAQ / Accordion', description: 'Daftar pertanyaan', icon: 'bi-list-ul', bgColor: 'bg-teal-50 text-teal-600', isPro: true },
]

const getBlockComponent = (type) => {
  const components = {
    text: TextBlock,
    link: LinkBlock,
    grid: GridBlock,
    image: ImageBlock,
    alert: AlertBlock,
    countdown: CountdownBlock,
    video: VideoBlock,
    profile: ProfileBlock,
    slideshow: SlideshowBlock,
    accordion: AccordionBlock,
    social: SocialBlock,
    divider: DividerBlock,
  }
  return components[type] || TextBlock
}

const getBlockTypeName = (type) => {
  const block = availableBlocks.find(b => b.type === type)
  return block?.name || type
}

const getDefaultBlockData = (type) => {
  const defaults = {
    text: { content: 'Tulis teks di sini...', align: 'left', textColor: '#0f172a', fontSize: 'md', fontWeight: 'normal', isItalic: false },
    link: { title: 'Link Title', url: 'https://example.com', style: 'filled', backgroundColor: '#059669', textColor: '#ffffff' },
    grid: { items: [] },
    image: { url: '', alt: '', size: 'medium' },
    alert: { content: 'Pesan pengumuman penting!', type: 'info' },
    countdown: { title: 'Segera Hadir', targetDate: '', style: 'cards' },
    slideshow: { images: [] },
    profile: { avatar: '', name: '', bio: '', align: 'center' },
    accordion: { items: [] },
    video: { url: '', platform: 'youtube' },
    social: { links: [] },
    divider: { style: 'solid', color: '#e5e7eb' },
  }
  return defaults[type] || {}
}

const handleSeoImageUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  // Validate file size (max 2MB)
  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file terlalu besar! Maksimal 2MB.')
    return
  }

  // Validate file type
  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar!')
    return
  }

  try {
      const result = await uploadImage(file, 'pages')
      pageData.value.seo_image = result.url
  } catch (err) {
      alert('Gagal mengupload gambar SEO: ' + err.response?.data?.message)
  }
}

const handleBgImageUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file terlalu besar! Maksimal 2MB.')
    return
  }

  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar!')
    return
  }

  try {
      const result = await uploadImage(file, 'pages')
      pageData.value.theme.backgroundImage = result.url
  } catch (err) {
      alert('Gagal mengupload background: ' + err.response?.data?.message)
  }
}
</script>

<style scoped>
@keyframes slide-up {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

.animate-slide-up {
  animation: slide-up 0.3s ease-out;
}
</style>

