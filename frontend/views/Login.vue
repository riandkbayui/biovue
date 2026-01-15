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
        Masuk ke akun Anda
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Atau
        <router-link to="/register" class="font-medium text-emerald-600 hover:text-emerald-500">
          daftar gratis sekarang
        </router-link>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
        <form class="space-y-6" @submit.prevent="handleLogin">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email address
            </label>
            <div class="mt-1">
              <Input id="email" name="email" type="email" autocomplete="email" required v-model="email" placeholder="john@example.com" />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1">
              <PasswordInput id="password" name="password" autocomplete="current-password" required v-model="password" />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox"
                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                Ingat saya
              </label>
            </div>

            <div class="text-sm">
              <router-link to="/forgot-password" class="font-medium text-emerald-600 hover:text-emerald-500">
                Lupa password?
              </router-link>
            </div>
          </div>

          <div>
            <Button type="submit" variant="primary" class="w-full justify-center">
              Masuk
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
                Atau masuk dengan
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
import Input from '@/components/Input.vue'
import PasswordInput from '@/components/PasswordInput.vue'
import Button from '@/components/Button.vue'

const email = ref('')
const password = ref('')
const router = useRouter()

const handleLogin = () => {
    // Mock login logic
    router.push('/member/dashboard')
}
</script>
