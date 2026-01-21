<template>
  <div class="animate-fade-in">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengaturan Profil</h1>
    
    <!-- Tabs -->
    <div class="flex space-x-6 border-b border-gray-200 mb-6">
      <button 
        @click="activeTab = 'profile'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'profile' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Informasi Pribadi
        <div v-if="activeTab === 'profile'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-600 rounded-t-full"></div>
      </button>
      <button 
        @click="activeTab = 'security'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'security' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Keamanan
        <div v-if="activeTab === 'security'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-600 rounded-t-full"></div>
      </button>
    </div>

    <!-- Notifications -->
    <div v-if="successMsg" class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        {{ successMsg }}
    </div>
    <div v-if="errorMsg" class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ errorMsg }}
    </div>

    <Card>
      <template #header>
        <h2 class="text-lg font-semibold text-gray-700">
          {{ activeTab === 'profile' ? 'Informasi Pribadi' : 'Pengaturan Keamanan' }}
        </h2>
      </template>

      <!-- Profile Tab -->
      <div v-if="activeTab === 'profile'" class="space-y-6">
        <!-- Photo Upload -->
        <div class="flex items-center space-x-6">
          <div class="shrink-0 relative group">
            <img 
              class="h-24 w-24 object-cover rounded-full ring-2 ring-gray-100 bg-gray-50" 
              :src="form.photo || 'https://api.dicebear.com/7.x/avataaars/svg?seed=' + form.username" 
              alt="Profile photo" 
            />
            <div v-if="isUploading" class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center">
                <span class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
            </div>
          </div>
          <label class="block">
            <span class="sr-only">Pilih foto profil</span>
            <input type="file" accept="image/*" :disabled="isUploading" class="block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-emerald-50 file:text-emerald-700
              hover:file:bg-emerald-100
              cursor-pointer disabled:opacity-50
            " @change="handleFileChange"/>
          </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
            <Input v-model="form.name" placeholder="John Doe" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Username</label>
            <Input v-model="form.username" placeholder="johndoe" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Alamat Email</label>
            <Input v-model="form.email" type="email" placeholder="john@example.com" disabled class="bg-gray-50 cursor-not-allowed" />
            <p class="text-[10px] text-gray-400 italic">*Email tidak dapat diubah.</p>
          </div>
        </div>
      </div>

      <!-- Security Tab -->
      <div v-if="activeTab === 'security'" class="space-y-6 max-w-2xl">
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
          <div class="flex items-start">
            <i class="bi bi-shield-check text-blue-600 text-xl mr-3 mt-0.5"></i>
            <div>
              <h4 class="text-sm font-bold text-blue-800">Persyaratan Kata Sandi</h4>
              <ul class="text-xs text-blue-700 mt-1 list-disc list-inside space-y-1">
                <li>Minimal 6 karakter</li>
                <li>Gunakan kombinasi huruf dan angka untuk keamanan lebih baik</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
          <PasswordInput v-model="securityForm.old_password" placeholder="Masukkan kata sandi saat ini" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Kata Sandi Baru</label>
             <PasswordInput v-model="securityForm.new_password" placeholder="Masukkan kata sandi baru" />
          </div>
          
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
             <PasswordInput v-model="securityForm.confirm_new_password" placeholder="Ulangi kata sandi baru" />
          </div>
        </div>
      </div>

      <template #footer>
        <div class="flex justify-end space-x-3">
          <Button variant="secondary" @click="resetForms">Batal</Button>
          <Button variant="primary" :disabled="isLoading" @click="activeTab === 'profile' ? saveProfile() : saveSecurity()">
            <span v-if="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>
            {{ activeTab === 'profile' ? 'Simpan Perubahan' : 'Perbarui Kata Sandi' }}
          </Button>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { reactive, ref, computed, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useProfile } from '@/composables/useProfile';
import { useUpload } from '@/composables/useUpload';
import Card from '@/components/Card.vue';
import Input from '@/components/Input.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import Button from '@/components/Button.vue';

const authStore = useAuthStore();
const { updateProfile, changePassword, isLoading, error, successMsg } = useProfile();
const { uploadImage, isUploading } = useUpload();

const activeTab = ref('profile');

const form = reactive({
  name: '',
  username: '',
  email: '',
  photo: ''
});

const securityForm = reactive({
  old_password: '',
  new_password: '',
  confirm_new_password: ''
});

// Init form data dari store
onMounted(() => {
    resetForms();
});

const resetForms = () => {
    form.name = authStore.user.name;
    form.username = authStore.user.username;
    form.email = authStore.user.email;
    form.photo = authStore.user.photo;

    securityForm.old_password = '';
    securityForm.new_password = '';
    securityForm.confirm_new_password = '';
};

const errorMsg = computed(() => {
    if (!error.value) return null;
    if (typeof error.value === 'object') return Object.values(error.value).join(', ');
    return error.value;
});

const handleFileChange = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  try {
      const result = await uploadImage(file, 'avatars');
      form.photo = result.url;
      // Langsung update profil jika foto diubah? 
      // User biasanya menekan tombol save, jadi kita biarkan di state lokal dulu
  } catch (err) {
      alert('Gagal mengupload foto: ' + (err.response?.data?.message || 'Error'));
  }
};

const saveProfile = async () => {
  try {
      await updateProfile({
          name: form.name,
          username: form.username,
          photo: form.photo
      });
  } catch (err) {}
};

const saveSecurity = async () => {
  if (securityForm.new_password !== securityForm.confirm_new_password) {
    alert('Konfirmasi kata sandi tidak cocok!');
    return;
  }
  
  try {
      await changePassword(securityForm);
      // Reset security form after success
      securityForm.old_password = '';
      securityForm.new_password = '';
      securityForm.confirm_new_password = '';
  } catch (err) {}
};
</script>
