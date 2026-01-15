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

      <div class="p-4 sm:p-6 space-y-6">
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
                <input v-model="pageData.slug" type="text" placeholder="your-link" class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
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
              <p class="text-xs text-gray-500 mt-1">{{ pageData.description?.length || 0 }}/160 karakter</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Gambar SEO</label>
              <div class="space-y-3">
                <!-- Upload Area -->
                <div v-if="!pageData.seoImage" class="relative">
                  <input 
                    type="file"
                    accept="image/*"
                    @change="handleSeoImageUpload"
                    class="hidden"
                    ref="seoImageInput"
                  >
                  <button
                    @click="$refs.seoImageInput.click()"
                    type="button"
                    class="w-full py-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex flex-col items-center justify-center gap-2 text-gray-500 hover:text-emerald-600"
                  >
                    <i class="bi bi-cloud-upload text-3xl"></i>
                    <span class="font-medium">Klik untuk upload gambar</span>
                    <span class="text-xs">PNG, JPG, GIF (Max 2MB)</span>
                  </button>
                </div>

                <!-- Preview Area -->
                <div v-else class="relative rounded-xl overflow-hidden border-2 border-gray-200 aspect-video bg-gray-50">
                  <img :src="pageData.seoImage" alt="SEO Preview" class="w-full h-full object-cover" />
                  <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                    <button 
                      @click="$refs.seoImageInput.click()"
                      type="button"
                      class="px-4 py-2 rounded-lg bg-white text-gray-700 font-medium hover:bg-gray-100 transition-colors flex items-center gap-2"
                    >
                      <i class="bi bi-arrow-repeat"></i>
                      Ganti
                    </button>
                    <button 
                      @click="pageData.seoImage = ''"
                      type="button"
                      class="px-4 py-2 rounded-lg bg-red-500 text-white font-medium hover:bg-red-600 transition-colors flex items-center gap-2"
                    >
                      <i class="bi bi-trash"></i>
                      Hapus
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
            <span class="text-sm text-gray-500">{{ pageData.blocks.length }} block</span>
          </div>

          <div v-if="pageData.blocks.length === 0" class="text-center py-12 sm:py-20 border-2 border-dashed border-gray-200 rounded-2xl mb-4">
            <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-3xl text-gray-300 mx-auto mb-4">
              <i class="bi bi-plus-lg"></i>
            </div>
            <p class="text-gray-500 font-medium">Belum ada block</p>
            <p class="text-sm text-gray-400 mt-1">Klik tombol di bawah untuk menambahkan</p>
          </div>

          <draggable 
            v-model="pageData.blocks" 
            item-key="id"
            handle=".drag-handle"
            class="space-y-3 mb-4"
          >
            <template #item="{ element, index }">
              <div class="group relative bg-white rounded-2xl border-2 border-gray-200 hover:border-emerald-500 transition-all overflow-hidden">
                <!-- Drag Handle Area -->
                <div class="drag-handle bg-gray-50 border-b border-gray-200 px-4 py-2 cursor-move active:cursor-grabbing flex items-center gap-2 text-gray-500 hover:bg-gray-100 transition-colors">
                  <i class="bi bi-grip-vertical text-lg"></i>
                  <span class="text-xs font-medium uppercase tracking-wider">{{ getBlockTypeName(element.type) }}</span>
                </div>

                <!-- Content Area -->
                <div class="p-4">
                  <component 
                    :is="getBlockComponent(element.type)" 
                    v-model="pageData.blocks[index]"
                    @update="updateBlock(index, $event)"
                  />
                </div>

                <!-- Actions Area -->
                <div class="border-t border-gray-100 bg-gray-50 px-4 py-3 flex items-center justify-end gap-2">
                  <button 
                    @click="duplicateBlock(index)" 
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                  >
                    <i class="bi bi-files"></i>
                    <span>Duplikat</span>
                  </button>
                  <button 
                    @click="deleteBlock(index)" 
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
              class="flex flex-col items-center gap-3 p-4 rounded-2xl border-2 border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 transition-all group"
            >
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

    <!-- Preview Modal (Mobile) -->
    <div 
      v-if="showPreview"
      @click="showPreview = false"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 sm:hidden"
    >
      <div 
        @click.stop
        class="bg-gray-900 rounded-3xl p-4 shadow-2xl w-full max-w-sm"
      >
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold text-white">Preview</h3>
          <button @click="showPreview = false" class="p-2 rounded-xl hover:bg-white/10 text-white transition-colors">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        <div class="bg-white rounded-2xl overflow-hidden" style="height: 600px; overflow-y: auto;">
          <PagePreview :pageData="pageData" />
        </div>
      </div>
    </div>

    <!-- Preview Sidebar (Desktop) -->
    <div 
      v-if="showPreview"
      class="hidden sm:block fixed right-6 top-24 w-80 bg-white rounded-2xl border border-gray-100 p-6 shadow-xl z-40"
    >
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900 flex items-center gap-2">
          <i class="bi bi-phone"></i>
          Preview
        </h3>
        <button @click="showPreview = false" class="p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <div class="bg-gray-900 rounded-3xl p-4 shadow-2xl">
        <div class="bg-white rounded-2xl overflow-hidden" style="height: 600px; overflow-y: auto;">
          <PagePreview :pageData="pageData" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import draggable from 'vuedraggable'
import TextBlock from '@/components/blocks/TextBlock.vue'
import ImageBlock from '@/components/blocks/ImageBlock.vue'
import LinkBlock from '@/components/blocks/LinkBlock.vue'
import VideoBlock from '@/components/blocks/VideoBlock.vue'
import SocialBlock from '@/components/blocks/SocialBlock.vue'
import DividerBlock from '@/components/blocks/DividerBlock.vue'
import PagePreview from '@/components/PagePreview.vue'

const router = useRouter()
const showPreview = ref(false)
const showBlockModal = ref(false)

const pageData = ref({
  title: '',
  slug: '',
  description: '',
  seoImage: '',
  blocks: []
})

const availableBlocks = [
  { type: 'text', name: 'Text', description: 'Teks atau paragraf', icon: 'bi-text-left', bgColor: 'bg-blue-50 text-blue-600' },
  { type: 'link', name: 'Link Button', description: 'Tombol link', icon: 'bi-link-45deg', bgColor: 'bg-emerald-50 text-emerald-600' },
  { type: 'image', name: 'Image', description: 'Gambar atau foto', icon: 'bi-image', bgColor: 'bg-purple-50 text-purple-600' },
  { type: 'video', name: 'Video', description: 'Embed video', icon: 'bi-play-circle', bgColor: 'bg-red-50 text-red-600' },
  { type: 'social', name: 'Social Links', description: 'Ikon sosial media', icon: 'bi-share', bgColor: 'bg-pink-50 text-pink-600' },
  { type: 'divider', name: 'Divider', description: 'Garis pemisah', icon: 'bi-dash-lg', bgColor: 'bg-gray-50 text-gray-600' },
]

const getBlockComponent = (type) => {
  const components = {
    text: TextBlock,
    image: ImageBlock,
    link: LinkBlock,
    video: VideoBlock,
    social: SocialBlock,
    divider: DividerBlock,
  }
  return components[type] || TextBlock
}

const getBlockTypeName = (type) => {
  const block = availableBlocks.find(b => b.type === type)
  return block?.name || type
}

const addBlock = (type) => {
  const newBlock = {
    id: Date.now(),
    type,
    data: getDefaultBlockData(type)
  }
  pageData.value.blocks.push(newBlock)
}

const addBlockAndClose = (type) => {
  addBlock(type)
  showBlockModal.value = false
}

const getDefaultBlockData = (type) => {
  const defaults = {
    text: { content: 'Tulis teks di sini...', align: 'left' },
    link: { title: 'Link Title', url: 'https://example.com', style: 'filled' },
    image: { url: '', alt: '', size: 'medium' },
    video: { url: '', platform: 'youtube' },
    social: { links: [] },
    divider: { style: 'solid', color: '#e5e7eb' },
  }
  return defaults[type] || {}
}

const updateBlock = (index, data) => {
  pageData.value.blocks[index] = { ...pageData.value.blocks[index], ...data }
}

const duplicateBlock = (index) => {
  const block = { ...pageData.value.blocks[index], id: Date.now() }
  pageData.value.blocks.splice(index + 1, 0, block)
}

const deleteBlock = (index) => {
  pageData.value.blocks.splice(index, 1)
}

const savePage = () => {
  // Mock save logic
  alert('Halaman berhasil disimpan!')
  router.push('/member/my-pages')
}

const handleSeoImageUpload = (event) => {
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

  // Convert to base64
  const reader = new FileReader()
  reader.onload = (e) => {
    pageData.value.seoImage = e.target.result
  }
  reader.readAsDataURL(file)
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

