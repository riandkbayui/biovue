<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
       <router-link to="/" class="flex items-center justify-center gap-2 mb-6">
          <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-emerald-500 to-emerald-600 flex items-center justify-center font-bold text-white text-xl">
            A
          </div>
          <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500">
            Aksibio
          </span>
       </router-link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Buat akun baru gratis
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Sudah punya akun?
        <router-link to="/login" class="font-medium text-emerald-600 hover:text-emerald-500">
          Masuk di sini
        </router-link>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
        
        <div v-if="errorMsg" class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ errorMsg }}</span>
        </div>

        <form class="space-y-6" @submit.prevent="handleRegister">
            
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
              Nama Lengkap
            </label>
            <div class="mt-1">
              <Input id="name" name="name" type="text" autocomplete="name" required v-model="name" placeholder="John Doe" />
              <p v-if="validationErrors.name" class="text-red-500 text-xs mt-1">{{ validationErrors.name }}</p>
            </div>
          </div>

          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">
              Username
            </label>
            <div class="mt-1">
              <Input id="username" name="username" type="text" autocomplete="username" required v-model="username" placeholder="johndoe" />
              <p v-if="validationErrors.username" class="text-red-500 text-xs mt-1">{{ validationErrors.username }}</p>
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email address
            </label>
            <div class="mt-1">
              <Input id="email" name="email" type="email" autocomplete="email" required v-model="email" placeholder="john@example.com" />
              <p v-if="validationErrors.email" class="text-red-500 text-xs mt-1">{{ validationErrors.email }}</p>
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1">
              <PasswordInput id="password" name="password" autocomplete="new-password" required v-model="password" />
            </div>
          </div>

          <div>
            <label for="password_confirm" class="block text-sm font-medium text-gray-700">
              Konfirmasi Password
            </label>
            <div class="mt-1">
              <PasswordInput id="password_confirm" name="password_confirm" autocomplete="new-password" required v-model="passwordConfirm" />
            </div>
          </div>

          <div class="flex items-center">
             <input id="terms" name="terms" type="checkbox" required
                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" />
              <label for="terms" class="ml-2 block text-sm text-gray-900">
                Saya menyetujui <router-link to="/terms" class="text-emerald-600 hover:text-emerald-500">Syarat & Ketentuan</router-link> dan <router-link to="/privacy" class="text-emerald-600 hover:text-emerald-500">Kebijakan Privasi</router-link>.
              </label>
          </div>

          <div>
            <Button type="submit" variant="primary" class="w-full justify-center" :disabled="isLoading">
              {{ isLoading ? 'Mendaftar...' : 'Daftar Sekarang' }}
            </Button>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Atau daftar dengan
              </span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-2 gap-3">
             <div>
              <a href="#"
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                <i class="bi bi-google text-lg"></i>
              </a>
            </div>
            <div>
              <a href="#"
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                <i class="bi bi-facebook text-lg"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Input from '@/components/Input.vue'
import PasswordInput from '@/components/PasswordInput.vue'
import Button from '@/components/Button.vue'

const name = ref('')
const username = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')
const errorMsg = ref('')
const validationErrors = ref({})
const isLoading = ref(false)

const router = useRouter()
const authStore = useAuthStore()

const handleRegister = async () => {
    // Basic client-side validation
    if (password.value !== passwordConfirm.value) {
        errorMsg.value = 'Password tidak cocok!'
        return
    }

    isLoading.value = true
    errorMsg.value = ''
    validationErrors.value = {}

    const formData = {
        name: name.value,
        username: username.value,
        email: email.value,
        password: password.value,
        confirm_password: passwordConfirm.value
    }

    const result = await authStore.register(formData)
    
    isLoading.value = false

    if (result.success) {
        // Redirect to login or auto-login
        // For now, redirect to login with query param
        router.push('/login?registered=true')
    } else {
        errorMsg.value = result.message
        if (result.errors) {
            validationErrors.value = result.errors
        }
    }
}
</script>
