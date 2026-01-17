<template>
  <div class="animate-fade-in max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Profil Admin</h1>
    
    <!-- Tabs -->
    <div class="flex space-x-6 border-b border-gray-200 mb-6">
      <button 
        @click="activeTab = 'profile'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'profile' ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Informasi Pribadi
        <div v-if="activeTab === 'profile'" class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 rounded-t-full"></div>
      </button>
      <button 
        @click="activeTab = 'security'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'security' ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Keamanan
        <div v-if="activeTab === 'security'" class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 rounded-t-full"></div>
      </button>
    </div>

    <Card>
      <template #header>
        <h2 class="text-lg font-semibold text-gray-700">
          {{ activeTab === 'profile' ? 'Detail Profil' : 'Pengaturan Keamanan' }}
        </h2>
      </template>

      <!-- Profile Tab -->
      <div v-if="activeTab === 'profile'" class="space-y-6">
        <!-- Photo Upload -->
        <div class="flex items-center space-x-6">
          <div class="shrink-0">
            <div class="h-24 w-24 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-700 border-2 border-indigo-200 overflow-hidden shadow-sm">
                <img v-if="form.avatarUrl" :src="form.avatarUrl" class="h-full w-full object-cover" />
                <i v-else class="bi bi-person-badge-fill text-5xl"></i>
            </div>
          </div>
          <label class="block">
            <span class="sr-only">Pilih foto profil</span>
            <input type="file" accept="image/*" class="block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-indigo-50 file:text-indigo-700
              hover:file:bg-indigo-100
              cursor-pointer
            " @change="handleFileChange"/>
          </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
            <Input v-model="form.name" placeholder="Bio Admin" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Username</label>
            <Input v-model="form.username" placeholder="admin_aksibio" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Alamat Email</label>
            <Input v-model="form.email" type="email" placeholder="admin@aksibio.com" />
          </div>

          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Jabatan</label>
             <Input v-model="form.role" placeholder="Super Admin" disabled />
          </div>
        </div>
      </div>

      <!-- Security Tab -->
      <div v-if="activeTab === 'security'" class="space-y-6 max-w-2xl">
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6">
          <div class="flex items-start">
            <i class="bi bi-shield-lock-fill text-indigo-600 text-xl mr-3 mt-0.5"></i>
            <div>
              <h4 class="text-sm font-bold text-indigo-800">Keamanan Akun</h4>
              <p class="text-xs text-indigo-700 mt-1">Gunakan kata sandi yang kuat untuk menjaga keamanan akses panel admin.</p>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
          <PasswordInput v-model="securityForm.currentPassword" placeholder="Masukkan kata sandi lama" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Kata Sandi Baru</label>
             <PasswordInput v-model="securityForm.newPassword" placeholder="Masukkan kata sandi baru" />
          </div>
          
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
             <PasswordInput v-model="securityForm.confirmPassword" placeholder="Ulangi kata sandi baru" />
          </div>
        </div>
      </div>

      <template #footer>
        <div class="flex justify-end space-x-3">
          <Button variant="secondary">Batal</Button>
          <Button variant="primary" @click="activeTab === 'profile' ? saveProfile() : saveSecurity()">
            {{ activeTab === 'profile' ? 'Simpan Perubahan' : 'Perbarui Kata Sandi' }}
          </Button>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import Card from '../../components/Card.vue';
import Input from '../../components/Input.vue';
import PasswordInput from '../../components/PasswordInput.vue';
import Button from '../../components/Button.vue';

const activeTab = ref('profile');

const form = reactive({
  name: 'Bio Admin',
  username: 'admin',
  email: 'admin@aksibio.com',
  role: 'Super Admin',
  avatarUrl: null
});

const securityForm = reactive({
  currentPassword: '',
  newPassword: '',
  confirmPassword: ''
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.avatarUrl = URL.createObjectURL(file);
  }
};

const saveProfile = () => {
  console.log('Saving admin profile:', form);
  alert('Profil berhasil diperbarui!');
};

const saveSecurity = () => {
  if (securityForm.newPassword !== securityForm.confirmPassword) {
    alert('Konfirmasi kata sandi tidak cocok!');
    return;
  }
  console.log('Updating admin password:', securityForm);
  alert('Kata sandi berhasil diperbarui!');
  
  securityForm.currentPassword = '';
  securityForm.newPassword = '';
  securityForm.confirmPassword = '';
};
</script>