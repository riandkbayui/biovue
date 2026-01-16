<template>
  <div>
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Profile Settings</h1>
    
    <Card>
      <template #header>
        <h2 class="text-lg font-semibold text-gray-700">Personal Information</h2>
      </template>

      <div class="space-y-6">
        <!-- Photo Upload -->
        <div class="flex items-center space-x-6">
          <div class="shrink-0">
            <img 
              class="h-24 w-24 object-cover rounded-full ring-2 ring-gray-100" 
              :src="form.avatarUrl || 'https://via.placeholder.com/150'" 
              alt="Current profile photo" 
            />
          </div>
          <label class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" accept="image/*" class="block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-emerald-50 file:text-emerald-700
              hover:file:bg-emerald-100
              cursor-pointer
            " @change="handleFileChange"/>
          </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Full Name</label>
            <Input v-model="form.name" placeholder="John Doe" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Username</label>
            <Input v-model="form.username" placeholder="johndoe" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Email Address</label>
            <Input v-model="form.email" type="email" placeholder="john@example.com" />
          </div>

          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Phone Number</label>
             <Input v-model="form.phone" type="tel" placeholder="+1 (555) 000-0000" />
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Bio</label>
          <Textarea v-model="form.bio" placeholder="Tell us a little about yourself..." rows="4" />
          <p class="text-xs text-gray-500">Brief description for your profile.</p>
        </div>
      </div>

      <template #footer>
        <div class="flex justify-end space-x-3">
          <Button variant="secondary">Cancel</Button>
          <Button variant="primary" @click="saveProfile">Save Changes</Button>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import Card from '../../components/Card.vue';
import Input from '../../components/Input.vue';
import Textarea from '../../components/Textarea.vue';
import Button from '../../components/Button.vue';

const form = reactive({
  name: 'Riandk',
  username: 'riandk',
  email: 'rian@example.com',
  phone: '',
  bio: 'Full stack developer.',
  avatarUrl: null
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.avatarUrl = URL.createObjectURL(file);
  }
};

const saveProfile = () => {
  // Simulate API call
  console.log('Saving profile:', form);
  alert('Profile saved successfully!');
};
</script>
