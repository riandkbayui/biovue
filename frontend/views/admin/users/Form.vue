<template>
  <div class="space-y-6 animate-fade-in max-w-2xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ isEditing ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h1>
            <p class="text-gray-500 mt-1">{{ isEditing ? 'Perbarui informasi pengguna' : 'Tambahkan pengguna baru ke sistem' }}</p>
        </div>
        <Button variant="secondary" @click="$router.push({ name: 'admin-users' })">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </Button>
    </div>

    <Card>
      <form @submit.prevent="saveUser" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <Input v-model="userForm.name" placeholder="Contoh: John Doe" required />
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <Input v-model="userForm.username" placeholder="Contoh: johndoe123" required />
            </div>
            
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <Input type="email" v-model="userForm.email" placeholder="Contoh: john@example.com" required />
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select v-model="userForm.status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
            <div class="md:col-span-2" v-if="isEditing">
                <p class="text-xs text-gray-500 bg-blue-50 p-2 rounded border border-blue-100">
                    <i class="bi bi-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah kata sandi.
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sandi</label>
                <PasswordInput v-model="userForm.password" placeholder="********" :required="!isEditing" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi</label>
                <PasswordInput v-model="userForm.confirmPassword" placeholder="********" :required="!isEditing" />
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <Button type="button" variant="secondary" @click="$router.push({ name: 'admin-users' })">Batal</Button>
            <Button type="submit" variant="primary">
                <i class="bi bi-save mr-2"></i> {{ isEditing ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
            </Button>
        </div>
      </form>
    </Card>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Card from '../../../components/Card.vue';
import Button from '../../../components/Button.vue';
import Input from '../../../components/Input.vue';
import PasswordInput from '../../../components/PasswordInput.vue';

const route = useRoute();
const router = useRouter();

const isEditing = computed(() => !!route.params.id);

const userForm = reactive({
  name: '',
  username: '',
  email: '',
  status: 'Aktif',
  password: '',
  confirmPassword: ''
});

// Mock data fetch for editing
onMounted(() => {
  if (isEditing.value) {
    const mockId = route.params.id;
    console.log(`Fetching data for user ID: ${mockId}`);
    
    // Pre-fill with dummy data
    if (mockId == 1) {
        userForm.name = 'Alex Johnson';
        userForm.username = 'alexj';
        userForm.email = 'alex@example.com';
    }
  }
});

const saveUser = () => {
  // Validate basic info
  if (!userForm.name || !userForm.username || !userForm.email) {
    alert('Mohon lengkapi semua field yang wajib diisi.');
    return;
  }

  // Validate password for new user or if password field is filled
  if (!isEditing.value || userForm.password) {
      if (userForm.password.length < 6) {
          alert('Sandi minimal 6 karakter.');
          return;
      }
      if (userForm.password !== userForm.confirmPassword) {
          alert('Konfirmasi sandi tidak cocok.');
          return;
      }
  }

  // Simulate API call
  console.log('Saving user:', {
      ...userForm,
      password: userForm.password || '(unchanged)'
  });
  
  // Redirect back to list
  router.push({ name: 'admin-users' });
};
</script>