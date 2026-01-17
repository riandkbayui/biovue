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

            <div class="pt-4 border-t border-gray-100">
              <label class="block text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-palette"></i>
                Tampilan Halaman (Background)
              </label>
              
              <div class="space-y-4">
                <!-- Type Selector -->
                <div class="flex p-1 bg-gray-100 rounded-xl w-fit">
                  <button 
                    @click="pageData.theme.backgroundType = 'color'"
                    :class="['px-4 py-1.5 rounded-lg text-sm font-bold transition-all', pageData.theme.backgroundType === 'color' ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500']"
                  >
                    Warna Solid
                  </button>
                  <button 
                    @click="pageData.theme.backgroundType = 'image'"
                    :class="['px-4 py-1.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2', pageData.theme.backgroundType === 'image' ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500']"
                  >
                    Gambar
                    <span class="px-1 py-0.5 rounded bg-amber-100 text-[8px] text-amber-700 leading-none">PRO</span>
                  </button>
                </div>

                <!-- Color Options -->
                <div v-if="pageData.theme.backgroundType === 'color'" class="flex flex-wrap gap-2">
                  <button 
                    v-for="color in bgColors" 
                    :key="color.hex"
                    @click="pageData.theme.backgroundColor = color.hex"
                    :class="['w-10 h-10 rounded-xl border-2 transition-all', pageData.theme.backgroundColor === color.hex ? 'border-emerald-500 scale-110 shadow-lg' : 'border-transparent hover:scale-105']"
                    :style="{ backgroundColor: color.hex }"
                    :title="color.name"
                  ></button>
                </div>

                <!-- Image Upload -->
                <div v-if="pageData.theme.backgroundType === 'image'" class="space-y-3">
                  <div v-if="!pageData.theme.backgroundImage">
                    <input type="file" accept="image/*" @change="handleBgImageUpload" class="hidden" ref="bgImageInput">
                    <button 
                      @click="$refs.bgImageInput.click()"
                      class="w-full py-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all flex flex-col items-center justify-center gap-2 text-gray-500"
                    >
                      <i class="bi bi-image-plus text-2xl"></i>
                      <span class="text-xs font-bold">Upload Background</span>
                    </button>
                  </div>
                  <div v-else class="relative rounded-xl overflow-hidden border-2 border-gray-200 aspect-video bg-gray-50">
                    <img :src="pageData.theme.backgroundImage" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center gap-2">
                      <button @click="pageData.theme.backgroundImage = ''" class="p-2 rounded-lg bg-red-500 text-white hover:bg-red-600">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
              <label class="block text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-star-fill text-amber-500"></i>
                Aksen Warna Halaman
              </label>
              <div class="flex flex-wrap gap-2">
                <button 
                  v-for="color in bgColors.filter(c => c.hex !== '#f9fafb')" 
                  :key="color.hex"
                  @click="pageData.theme.accentColor = color.hex"
                  :class="['w-10 h-10 rounded-xl border-2 transition-all', pageData.theme.accentColor === color.hex ? 'border-emerald-500 scale-110 shadow-lg' : 'border-transparent hover:scale-105']"
                  :style="{ backgroundColor: color.hex }"
                  :title="color.name"
                ></button>
              </div>
              <p class="text-[10px] text-gray-500 mt-2 italic">*Digunakan untuk warna hover sosmed, border profil, dll.</p>
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
                <div class="bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center justify-between text-gray-500 hover:bg-gray-100 transition-colors">
                  <div class="drag-handle cursor-move active:cursor-grabbing flex items-center gap-2 flex-1">
                    <i class="bi bi-grip-vertical text-lg"></i>
                    <span class="text-xs font-medium uppercase tracking-wider">{{ getBlockTypeName(element.type) }}</span>
                  </div>
                  
                  <div class="flex items-center gap-1">
                    <button 
                      @click="moveBlock(index, -1)" 
                      :disabled="index === 0"
                      class="p-1 hover:text-emerald-600 disabled:opacity-30 disabled:hover:text-gray-500 transition-colors"
                      title="Pindah ke Atas"
                    >
                      <i class="bi bi-arrow-up-circle-fill text-lg"></i>
                    </button>
                    <button 
                      @click="moveBlock(index, 1)" 
                      :disabled="index === pageData.blocks.length - 1"
                      class="p-1 hover:text-emerald-600 disabled:opacity-30 disabled:hover:text-gray-500 transition-colors"
                      title="Pindah ke Bawah"
                    >
                      <i class="bi bi-arrow-down-circle-fill text-lg"></i>
                    </button>
                  </div>
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
import SlideshowBlock from '@/components/blocks/SlideshowBlock.vue'
import ProfileBlock from '@/components/blocks/ProfileBlock.vue'
import AccordionBlock from '@/components/blocks/AccordionBlock.vue'
import CountdownBlock from '@/components/blocks/CountdownBlock.vue'
import AlertBlock from '@/components/blocks/AlertBlock.vue'
import GridBlock from '@/components/blocks/GridBlock.vue'
import PagePreview from '@/components/PagePreview.vue'

const router = useRouter()
const showPreview = ref(false)
const showBlockModal = ref(false)

const pageData = ref({
  title: '',
  slug: '',
  description: '',
  seoImage: '',
  theme: {
    backgroundType: 'color', // 'color' or 'image'
    backgroundColor: '#f9fafb', // Gray 50
    backgroundImage: '',
    accentColor: '#059669' // Emerald 600
  },
  blocks: []
})

const bgColors = [
  { name: 'Gray 50', hex: '#f9fafb' },
  { name: 'Slate 900', hex: '#0f172a' },
  { name: 'Blue 600', hex: '#2563eb' },
  { name: 'Emerald 600', hex: '#059669' },
  { name: 'Rose 600', hex: '#e11d48' },
  { name: 'Amber 500', hex: '#f59e0b' },
  { name: 'Indigo 600', hex: '#4f46e5' },
  { name: 'Violet 600', hex: '#7c3aed' },
  { name: 'Pink 500', hex: '#ec4899' },
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

const moveBlock = (index, direction) => {
  const newIndex = index + direction
  if (newIndex >= 0 && newIndex < pageData.value.blocks.length) {
    const blocks = [...pageData.value.blocks]
    const temp = blocks[index]
    blocks[index] = blocks[newIndex]
    blocks[newIndex] = temp
    pageData.value.blocks = blocks
  }
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

const handleBgImageUpload = (event) => {
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

  const reader = new FileReader()
  reader.onload = (e) => {
    pageData.value.theme.backgroundImage = e.target.result
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

