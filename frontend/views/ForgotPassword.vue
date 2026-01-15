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
        Lupa Password?
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Masukkan email Anda dan kami akan mengirimkan instruksi reset password.
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
        <form class="space-y-6" @submit.prevent="handleForgot">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email address
            </label>
            <div class="mt-1">
              <Input id="email" name="email" type="email" autocomplete="email" required v-model="email" placeholder="john@example.com" />
            </div>
          </div>

          <div>
            <Button type="submit" variant="primary" class="w-full justify-center">
              Kirim Link Reset
            </Button>
          </div>
        </form>

        <div class="mt-6 text-center">
            <router-link to="/login" class="font-medium text-emerald-600 hover:text-emerald-500">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Input from '@/components/Input.vue'
import Button from '@/components/Button.vue'

const email = ref('')
const router = useRouter()

const handleForgot = () => {
    // Mock flow: directly go to reset password page
    router.push('/reset-password')
}
</script>
