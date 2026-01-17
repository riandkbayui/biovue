<template>
  <div class="animate-fade-in">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Profile Settings</h1>
    
    <!-- Tabs -->
    <div class="flex space-x-6 border-b border-gray-200 mb-6">
      <button 
        @click="activeTab = 'profile'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'profile' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Personal Information
        <div v-if="activeTab === 'profile'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-600 rounded-t-full"></div>
      </button>
      <button 
        @click="activeTab = 'security'"
        :class="['pb-3 text-sm font-medium transition-colors relative', activeTab === 'security' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700']"
      >
        Security
        <div v-if="activeTab === 'security'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-600 rounded-t-full"></div>
      </button>
    </div>

    <Card>
      <template #header>
        <h2 class="text-lg font-semibold text-gray-700">
          {{ activeTab === 'profile' ? 'Personal Information' : 'Security Settings' }}
        </h2>
      </template>

      <!-- Profile Tab -->
      <div v-if="activeTab === 'profile'" class="space-y-6">
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

      <!-- Security Tab -->
      <div v-if="activeTab === 'security'" class="space-y-6 max-w-2xl">
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
          <div class="flex items-start">
            <i class="bi bi-shield-check text-blue-600 text-xl mr-3 mt-0.5"></i>
            <div>
              <h4 class="text-sm font-bold text-blue-800">Password Requirements</h4>
              <ul class="text-xs text-blue-700 mt-1 list-disc list-inside space-y-1">
                <li>Minimum 8 characters long</li>
                <li>At least one uppercase character</li>
                <li>At least one number or symbol</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700">Current Password</label>
          <PasswordInput v-model="securityForm.currentPassword" placeholder="Enter your current password" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">New Password</label>
             <PasswordInput v-model="securityForm.newPassword" placeholder="Enter new password" />
          </div>
          
          <div class="space-y-2">
             <label class="text-sm font-medium text-gray-700">Confirm New Password</label>
             <PasswordInput v-model="securityForm.confirmPassword" placeholder="Confirm new password" />
          </div>
        </div>
      </div>

      <template #footer>
        <div class="flex justify-end space-x-3">
          <Button variant="secondary">Cancel</Button>
          <Button variant="primary" @click="activeTab === 'profile' ? saveProfile() : saveSecurity()">
            {{ activeTab === 'profile' ? 'Save Changes' : 'Update Password' }}
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
import Textarea from '../../components/Textarea.vue';
import Button from '../../components/Button.vue';

const activeTab = ref('profile');

const form = reactive({
  name: 'Riandk',
  username: 'riandk',
  email: 'rian@example.com',
  phone: '',
  bio: 'Full stack developer.',
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
  // Simulate API call
  console.log('Saving profile:', form);
  alert('Profile saved successfully!');
};

const saveSecurity = () => {
  if (securityForm.newPassword !== securityForm.confirmPassword) {
    alert('New passwords do not match!');
    return;
  }
  console.log('Updating password:', securityForm);
  alert('Password updated successfully!');
  
  // Reset form
  securityForm.currentPassword = '';
  securityForm.newPassword = '';
  securityForm.confirmPassword = '';
};
</script>
