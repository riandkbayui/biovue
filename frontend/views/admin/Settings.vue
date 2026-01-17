<template>
  <div class="space-y-6 animate-fade-in max-w-4xl">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Pengaturan SEO</h1>
      <p class="text-gray-500 mt-1">Kelola meta tags dan optimasi mesin pencari</p>
    </div>

    <div class="space-y-6">
      <!-- SEO & Meta Settings -->
      <Card>
        <template #header><h3 class="font-bold text-gray-900">SEO & Meta Tags</h3></template>
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Nama Aplikasi (Meta Title)</label>
            <Input v-model="settings.appName" placeholder="Contoh: Aksibio - Bio Link Tool" />
          </div>
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Deskripsi Meta</label>
            <Textarea v-model="settings.metaDescription" placeholder="Deskripsi singkat untuk hasil pencarian Google..." rows="3" />
          </div>
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Kata Kunci Meta (Keywords)</label>
            <Input v-model="settings.metaKeywords" placeholder="bio link, biolink, aksibio, landing page" />
          </div>
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Meta Image (Open Graph)</label>
            <div class="flex items-start gap-6 p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                <div class="shrink-0">
                    <div class="w-32 h-32 rounded-lg bg-white border border-gray-200 flex items-center justify-center overflow-hidden shadow-sm relative group">
                        <img v-if="settings.metaImage" :src="settings.metaImage" class="w-full h-full object-cover" />
                        <div v-else class="text-center p-2">
                            <i class="bi bi-image text-3xl text-gray-300 mb-1 block"></i>
                            <span class="text-[10px] text-gray-400">No Image</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1 space-y-3">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Gambar Preview Sosial Media</h4>
                        <p class="text-xs text-gray-500 mt-1">Gambar ini akan muncul saat tautan aplikasi dibagikan di Facebook, Twitter, WhatsApp, dll. Ukuran rekomendasi: <strong>1200 x 630 piksel</strong>.</p>
                    </div>
                    
                    <div class="flex gap-3">
                         <label class="cursor-pointer bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg shadow-sm transition-all inline-flex items-center gap-2">
                            <i class="bi bi-upload"></i>
                            <span>Unggah Gambar</span>
                            <input type="file" accept="image/*" class="hidden" @change="handleFileChange"/>
                        </label>
                        <button v-if="settings.metaImage" @click="settings.metaImage = null" class="text-red-600 hover:text-red-700 text-sm font-medium px-2">Hapus</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </Card>

      <div class="flex justify-end gap-3">
        <Button variant="secondary">Batalkan</Button>
        <Button variant="primary" @click="saveSettings">Simpan Perubahan</Button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import Card from '../../components/Card.vue';
import Input from '../../components/Input.vue';
import Textarea from '../../components/Textarea.vue';
import Button from '../../components/Button.vue';

const settings = reactive({
  appName: 'Aksibio',
  metaDescription: 'Platform bio link terbaik untuk optimasi media sosial Anda.',
  metaKeywords: 'bio link, biolink, aksibio, landing page, microsite',
  metaImage: 'https://aksibio.com/statics/assets/og-image.jpg',
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    settings.metaImage = URL.createObjectURL(file);
  }
};

const saveSettings = () => {
  console.log('Saving SEO settings:', settings);
  alert('Pengaturan SEO berhasil disimpan!');
}
</script>